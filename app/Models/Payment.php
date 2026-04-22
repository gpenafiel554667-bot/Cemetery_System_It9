<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'burial_id',
        'amount',
        'type',
        'status',
        'payment_date',
        'notes',
    ];

    public function burial()
    {
        return $this->belongsTo(Burial::class);
    }
}