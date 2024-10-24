<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScannedQRCode extends Model
{
    use HasFactory;
    protected $table = 'scanned_qr_codes'; 
    protected $fillable = [
        'user_id',
        'token', 
        'scanned_at', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
