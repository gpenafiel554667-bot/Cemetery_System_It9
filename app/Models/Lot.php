<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    use HasFactory;

    protected $fillable = [
        'lot_number',
        'section',
        'row',
        'type',
        'status',
        'price',
        'description',
    ];

    public function burial()
    {
        return $this->hasOne(Burial::class);
    }
}