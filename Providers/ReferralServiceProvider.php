<?php

declare(strict_types=1);

namespace Modules\Referral\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
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
        Event::listen(EntityCreated::class, LogReferralActivity::class);
        Event::listen(EntityUpdated::class, LogReferralActivity::class);
        Event::listen(EntityDeleted::class, LogReferralActivity::class);

        // ReferralCode lifecycle hooks
        Event::listen(EntityCreated::class, LogReferralCodeActivity::class);
        Event::listen(EntityUpdated::class, LogReferralCodeActivity::class);
        Event::listen(EntityDeleted::class, LogReferralCodeActivity::class);
    }
}