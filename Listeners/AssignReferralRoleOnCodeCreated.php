<?php

declare(strict_types=1);

namespace Modules\Referral\Listeners;

use App\Models\User;
use Modules\Referral\Models\ReferralCode;
use Spatie\Permission\Models\Role;
use Spine\Events\EntityCreated;

/**
 * Assign role referral ke pemilik kode saat kode referral dibuat.
 *
 * User entity mana pun (customer/surveyor/agency/association) atau referrer
 * murni yang membuat kode resmi jadi referrer — dapat role referral kalau
 * belum punya (role halus lain tetap utuh; assign hanya tambah).
 */
class AssignReferralRoleOnCodeCreated
{
    public function created(EntityCreated $event): void
    {
        if (! $event->entity instanceof ReferralCode) {
            return;
        }

        $user = User::find($event->entity->user_id);
        if (! $user) {
            return;
        }

        $role = Role::findByName('referral', 'sanctum');
        if ($role && ! $user->hasRole($role)) {
            $user->assignRole($role);
        }
    }
}
