<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Classes extends Model
{
    use HasFactory;
    protected $fillable = [
        'name' ,
        'description'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'class_id'); 
    }
}
