<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deceased extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'date_of_death',
        'cause_of_death',
        'photo',
    ];

    public function burial()
    {
        return $this->hasOne(Burial::class);
    }

    public function families()
    {
        return $this->hasMany(Family::class);
    }
}