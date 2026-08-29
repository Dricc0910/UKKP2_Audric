<?php

namespace App\Policies;

use App\Models\Pengaduan;
use App\Models\User;

class PengaduanPolicy
{
    public function viewAny(User $user): bool
    {
        // admin, petugas, dan customer semua boleh melihat menu Pengaduan
        // (isi datanya sendiri dibatasi lewat scope query di resource)
        return true;
    }

    public function view(User $user, Pengaduan $pengaduan): bool
    {
        if ($user->isAdmin() || $user->isPetugas()) {
            return true;
        }

        return $pengaduan->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        // hanya customer yang mengajukan pengaduan
        return $user->isCustomer();
    }

    public function update(User $user, Pengaduan $pengaduan): bool
    {
        if ($user->isAdmin() || $user->isPetugas()) {
            return true;
        }

        // customer hanya boleh mengubah pengaduan miliknya selama belum diproses
        return $pengaduan->user_id === $user->id && $pengaduan->status === Pengaduan::STATUS_BARU;
    }

    public function delete(User $user, Pengaduan $pengaduan): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isCustomer()) {
            return $pengaduan->user_id === $user->id && $pengaduan->status === Pengaduan::STATUS_BARU;
        }

        return false;
    }
}
