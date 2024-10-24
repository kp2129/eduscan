<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScannedQRCode extends Model
{
    use HasFactory;
    protected $table = 'scanned_qr_codes';
    protected $fillable = [
        'token',
        'user_id',
        'scanned_at',
    ];

    public function qrCode()
    {
        return $this->belongsTo(QRCode::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'scanned_by_user_id');
    }
}
