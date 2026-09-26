<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use Filament\Auth\Pages\Register as BaseRegister;
use Illuminate\Database\Eloquent\Model;

class Register extends BaseRegister
{
    /**
     * Halaman register di panel ini HANYA untuk customer.
     * Tidak ada pilihan role di form, semua akun baru otomatis
     * mendapat role "customer".
     */
    protected function handleRegistration(array $data): Model
    {
        $data['role'] = User::ROLE_CUSTOMER;

        return parent::handleRegistration($data);
    }
}
