<?php

declare(strict_types=1);

namespace Modules\Referral\Listeners;

use Modules\Referral\Models\Referral;
use Spine\Events\EntityCreated;
use Spine\Events\EntityDeleted;
use Spine\Events\EntityUpdated;
use Spine\Services\ActivityLogService;

class LogReferralActivity
{
    public function __construct(private readonly ActivityLogService $activityLog) {}

    public function created(EntityCreated $event): void
    {
        if (! $event->entity instanceof Referral) {
            return;
        }

        $this->activityLog->log(
            "Referral created: " . $this->label($event->entity),
            $event->entity,
            $this->user(),
            ['event' => 'created'],
        );
    }

    public function updated(EntityUpdated $event): void
    {
        if (! $event->entity instanceof Referral) {
            return;
        }

        $changes = $event->changes;

        $this->activityLog->log(
            "Referral updated: " . $this->label($event->entity) . " (" . $this->describe($changes) . ")",
            $event->entity,
            $this->user(),
            ['event' => 'updated', 'changes' => $changes],
        );

        $status = $changes['status'] ?? null;
        if ($status && $status['old'] !== $status['new']) {
            $this->activityLog->log(
                "Referral status changed: {$status['old']} -> {$status['new']}",
                $event->entity,
                $this->user(),
                ['event' => 'referral.status_changed', 'old' => $status['old'], 'new' => $status['new']],
            );
        }
    }

    public function deleted(EntityDeleted $event): void
    {
        if (! $event->entity instanceof Referral) {
            return;
        }

        $this->activityLog->log(
            "Referral deleted: " . $this->label($event->entity),
            null,
            $this->user(),
            ['event' => 'deleted', 'id' => $event->entity->getKey()],
            null,
            $event->entityType,
        );
    }

    private function describe(array $changes): string
    {
        $parts = [];
        foreach ($changes as $field => $change) {
            if (in_array($field, ['updated_at', 'remember_token'], true)) {
                continue;
            }
            $label = Referral::labels()[$field] ?? $field;
            $parts[] = $label . ': ' . $change['old'] . ' -> ' . $change['new'];
        }
        return implode(', ', $parts);
    }

    private function label($entity): string
    {
        return (string) ($entity->status ?? $entity->getKey());
    }

    private function user(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return auth('sanctum')->user() ?? auth()->user();
    }
}