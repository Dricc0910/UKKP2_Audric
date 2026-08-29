<?php

namespace App\Filament\Resources\Pengaduans\Schemas;

use App\Models\Pengaduan;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class PengaduanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nama')
                ->label('Nama Lengkap')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->maxLength(255),

            TextInput::make('no_telp')
                ->label('No. Telepon')
                ->tel()
                ->required()
                ->maxLength(20),

            Textarea::make('aduan')
                ->label('Isi Pengaduan')
                ->required()
                ->rows(5)
                ->columnSpanFull(),

            FileUpload::make('foto')
                ->label('Foto Bukti')
                ->image()
                ->disk('public')
                ->directory('pengaduan')
                ->visibility('public')
                ->maxSize(2048)
                ->columnSpanFull(),

            Select::make('status')
                ->label('Status')
                ->options([
                    Pengaduan::STATUS_BARU => 'Baru',
                    Pengaduan::STATUS_DIPROSES => 'Diproses',
                    Pengaduan::STATUS_SELESAI => 'Selesai',
                ])
                ->default(Pengaduan::STATUS_BARU)
                ->required()
                ->native(false)
                // hanya admin & petugas yang boleh mengubah status penanganan
                ->visible(fn (): bool => (bool) Auth::user()?->isAdmin() || (bool) Auth::user()?->isPetugas()),

            Textarea::make('tanggapan')
                ->label('Tanggapan Petugas')
                ->rows(3)
                ->columnSpanFull()
                ->visible(fn (): bool => (bool) Auth::user()?->isAdmin() || (bool) Auth::user()?->isPetugas()),
        ]);
    }
}
