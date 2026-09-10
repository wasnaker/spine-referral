<?php

declare(strict_types=1);

namespace Modules\Referral\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Modules\Referral\Listeners\AssignReferralRoleOnCodeCreated;
use Modules\Referral\Listeners\LogReferralActivity;
use Modules\Referral\Listeners\LogReferralCodeActivity;
use Spine\Events\EntityCreated;
use Spine\Events\EntityDeleted;
use Spine\Events\EntityUpdated;

class ReferralServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../Http/routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Referral lifecycle hooks
        Event::listen(EntityCreated::class, LogReferralActivity::class . '@created');
        Event::listen(EntityUpdated::class, LogReferralActivity::class . '@updated');
        Event::listen(EntityDeleted::class, LogReferralActivity::class . '@deleted');

        // ReferralCode lifecycle hooks
        Event::listen(EntityCreated::class, LogReferralCodeActivity::class . '@created');
        Event::listen(EntityUpdated::class, LogReferralCodeActivity::class . '@updated');
        Event::listen(EntityDeleted::class, LogReferralCodeActivity::class . '@deleted');

        // Kode referral dibuat -> user pemilik resmi referrer (role referral).
        Event::listen(EntityCreated::class, AssignReferralRoleOnCodeCreated::class . '@created');
    }
}