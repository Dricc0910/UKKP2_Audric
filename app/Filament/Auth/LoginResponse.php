<?php

namespace App\Filament\Auth;

use App\Filament\Resources\Pengaduans\PengaduanResource;
use Filament\Auth\Http\Responses\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportRedirects\Redirector;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        $user = Auth::user();

        // Customer diarahkan langsung ke daftar pengaduan miliknya.
        if ($user?->isCustomer()) {
            return redirect()->intended(PengaduanResource::getUrl('index'));
        }

        // Admin & petugas diarahkan ke dashboard panel seperti biasa.
        return redirect()->intended(filament()->getUrl());
    }
}
