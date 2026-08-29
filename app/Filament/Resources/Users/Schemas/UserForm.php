<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Nama')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),

            TextInput::make('no_telp')
                ->label('No. Telepon')
                ->tel()
                ->maxLength(20),

            Select::make('role')
                ->label('Role')
                ->options(function () {
                    /** @var User $current */
                    $current = Auth::user();

                    if ($current?->isAdmin()) {
                        return [
                            User::ROLE_ADMIN => 'Admin',
                            User::ROLE_PETUGAS => 'Petugas',
                            User::ROLE_CUSTOMER => 'Customer',
                        ];
                    }

                    // petugas hanya boleh membuat/mengubah user dengan role customer
                    return [
                        User::ROLE_CUSTOMER => 'Customer',
                    ];
                })
                ->default(User::ROLE_CUSTOMER)
                ->required()
                ->native(false),

            TextInput::make('password')
                ->label('Password')
                ->password()
                ->revealable()
                ->required(fn (string $operation): bool => $operation === 'create')
                ->dehydrated(fn (?string $state): bool => filled($state))
                ->minLength(6)
                ->maxLength(255),
        ]);
    }
}
