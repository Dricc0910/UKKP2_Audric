<?php

namespace App\Filament\Resources\Pengaduans\Pages;

use App\Filament\Resources\Pengaduans\PengaduanResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePengaduan extends CreateRecord
{
    protected static string $resource = PengaduanResource::class;

    /**
     * Pengaduan yang dibuat customer otomatis terhubung ke akunnya
     * dan status awal selalu "baru".
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();

        if ($user?->isCustomer()) {
            $data['user_id'] = $user->id;
            $data['status'] = 'baru';
        }

        return $data;
    }
}
