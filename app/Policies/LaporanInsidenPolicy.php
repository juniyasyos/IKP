<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\LaporanInsiden;
use Illuminate\Auth\Access\HandlesAuthorization;

class LaporanInsidenPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:LaporanInsiden');
    }

    public function view(AuthUser $authUser, LaporanInsiden $laporanInsiden): bool
    {
        return $authUser->can('View:LaporanInsiden');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:LaporanInsiden');
    }

    public function update(AuthUser $authUser, LaporanInsiden $laporanInsiden): bool
    {
        return $authUser->can('Update:LaporanInsiden');
    }

    public function delete(AuthUser $authUser, LaporanInsiden $laporanInsiden): bool
    {
        return $authUser->can('Delete:LaporanInsiden');
    }

    public function restore(AuthUser $authUser, LaporanInsiden $laporanInsiden): bool
    {
        return $authUser->can('Restore:LaporanInsiden');
    }

    public function forceDelete(AuthUser $authUser, LaporanInsiden $laporanInsiden): bool
    {
        return $authUser->can('ForceDelete:LaporanInsiden');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:LaporanInsiden');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:LaporanInsiden');
    }

    public function replicate(AuthUser $authUser, LaporanInsiden $laporanInsiden): bool
    {
        return $authUser->can('Replicate:LaporanInsiden');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:LaporanInsiden');
    }

}