<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengaduan extends Model
{
    use HasFactory;

    public const STATUS_BARU = 'baru';

    public const STATUS_DIPROSES = 'diproses';

    public const STATUS_SELESAI = 'selesai';

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'no_telp',
        'aduan',
        'foto',
        'status',
        'tanggapan',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
