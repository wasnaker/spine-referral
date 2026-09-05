<?php

declare(strict_types=1);

namespace Modules\Referral\Listeners;

use Modules\Referral\Models\ReferralCode;
use Spine\Events\EntityCreated;
use Spine\Events\EntityDeleted;
use Spine\Events\EntityUpdated;
use Spine\Services\ActivityLogService;

class LogReferralCodeActivity
{
    public function __construct(private readonly ActivityLogService $activityLog) {}

    public function created(EntityCreated $event): void
    {
        if (! $event->entity instanceof ReferralCode) {
            return;
        }

        $this->activityLog->log(
            "ReferralCode created: " . $this->label($event->entity),
            $event->entity,
            $this->user(),
            ['event' => 'created'],
        );
    }

    public function updated(EntityUpdated $event): void
    {
        if (! $event->entity instanceof ReferralCode) {
            return;
        }

        $changes = $event->changes;

        $this->activityLog->log(
            "ReferralCode updated: " . $this->label($event->entity) . " (" . $this->describe($changes) . ")",
            $event->entity,
            $this->user(),
            ['event' => 'updated', 'changes' => $changes],
        );

        $status = $changes['is_active'] ?? null;
        if ($status && $status['old'] !== $status['new']) {
            $this->activityLog->log(
                "ReferralCode status changed: " . $this->boolLabel($status['old']) . " -> " . $this->boolLabel($status['new']),
                $event->entity,
                $this->user(),
                ['event' => 'referral_code.status_changed', 'old' => $status['old'], 'new' => $status['new']],
            );
        }
    }

    public function deleted(EntityDeleted $event): void
    {
        if (! $event->entity instanceof ReferralCode) {
            return;
        }

        $this->activityLog->log(
            "ReferralCode deleted: " . $this->label($event->entity),
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
            $label = ReferralCode::labels()[$field] ?? $field;
            $parts[] = $label . ': ' . $change['old'] . ' -> ' . $change['new'];
        }
        return implode(', ', $parts);
    }

    private function boolLabel(mixed $value): string
    {
        return $value ? 'Aktif' : 'Nonaktif';
    }

    private function label($entity): string
    {
        return (string) ($entity->code ?? $entity->getKey());
    }

    private function user(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return auth('sanctum')->user() ?? auth()->user();
    }
}