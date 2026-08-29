<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    /**
     * Jaga-jaga tambahan: petugas hanya boleh membuat akun dengan role customer,
     * meskipun pilihan role di form sudah dibatasi.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (Auth::user()?->isPetugas()) {
            $data['role'] = User::ROLE_CUSTOMER;
        }

        return $data;
    }
}
