<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    /**
     * Jaga-jaga tambahan: petugas tidak boleh mengubah role user menjadi selain customer.
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (Auth::user()?->isPetugas()) {
            $data['role'] = User::ROLE_CUSTOMER;
        }

        return $data;
    }
}
