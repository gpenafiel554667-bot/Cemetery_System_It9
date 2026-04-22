<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Burial extends Model
{
    use HasFactory;

    protected $fillable = [
        'deceased_id',
        'lot_id',
        'burial_date',
        'burial_type',
        'notes',
    ];

    public function deceased()
    {
        return $this->belongsTo(Deceased::class);
    }

    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}