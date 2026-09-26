<?php

namespace App\Filament\Resources\Pengaduans\Tables;

use App\Models\Pengaduan;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PengaduansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('foto')
                    ->label('Foto')
                    ->circular(),

                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('no_telp')
                    ->label('No. Telepon'),

                TextColumn::make('aduan')
                    ->label('Aduan')
                    ->limit(40)
                    ->wrap(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Pengaduan::STATUS_BARU => 'Baru',
                        Pengaduan::STATUS_DIPROSES => 'Diproses',
                        Pengaduan::STATUS_SELESAI => 'Selesai',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        Pengaduan::STATUS_BARU => 'danger',
                        Pengaduan::STATUS_DIPROSES => 'warning',
                        Pengaduan::STATUS_SELESAI => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        Pengaduan::STATUS_BARU => 'Baru',
                        Pengaduan::STATUS_DIPROSES => 'Diproses',
                        Pengaduan::STATUS_SELESAI => 'Selesai',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
