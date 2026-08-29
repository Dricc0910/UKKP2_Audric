<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Menu "User" hanya muncul untuk admin & petugas.
     * Customer tidak melihat menu ini sama sekali (diganti menu Profile).
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isPetugas();
    }

    public function view(User $user, User $model): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isPetugas()) {
            // petugas hanya boleh melihat data petugas & customer, bukan admin
            return in_array($model->role, [User::ROLE_PETUGAS, User::ROLE_CUSTOMER]);
        }

        return false;
    }

    public function create(User $user): bool
    {
        // admin bisa tambah semua role, petugas hanya bisa tambah customer
        return $user->isAdmin() || $user->isPetugas();
    }

    public function update(User $user, User $model): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isPetugas()) {
            // petugas hanya boleh mengubah data customer (data petugas sifatnya view only)
            return $model->role === User::ROLE_CUSTOMER;
        }

        return false;
    }

    public function delete(User $user, User $model): bool
    {
        // tidak boleh menghapus akun sendiri
        if ($user->id === $model->id) {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isPetugas()) {
            return $model->role === User::ROLE_CUSTOMER;
        }

        return false;
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin() || $user->isPetugas();
    }
}
