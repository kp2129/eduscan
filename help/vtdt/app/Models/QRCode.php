<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class QRCode extends Model
{
    use HasFactory;
    protected $table = 'qr_codes';
    protected $fillable = ['user_id', 'token', 'expires_at'];

    // Check if the token is still valid
    public function isValid()
    {
        return $this->expires_at->isFuture();
    }

    // Generate a new QR token with 2-minute expiration
    public static function generateForUser($user)
    {
        return self::create([
            'user_id' => $user->id,
            'token' => \Str::random(32), 
            'expires_at' => Carbon::now()->addMinutes(2),
        ]);
    }
}
