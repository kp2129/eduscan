<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon; 
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'class_id',
        'is_at_school',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function scannedQRCodes()
    {
        return $this->hasMany(ScannedQRCode::class);
    }

    public function hasScannedToday(): bool
    {
        return $this->scannedQRCodes()
            ->whereDate('scanned_at', today())
            ->exists();
    }

    public function latestScannedQRCode()
    {
        return $this->scannedQRCodes()->latest()->first();
    }

    public function updateIsAtSchoolIfNotScannedToday()
    {
        if (!$this->hasScannedToday()) {
            $this->update(['is_at_school' => 1]);
        }
    }
}
