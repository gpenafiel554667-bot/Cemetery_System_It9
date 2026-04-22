<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'deceased_id',
        'first_name',
        'last_name',
        'relationship',
        'contact_number',
        'email',
        'address',
    ];

    public function deceased()
    {
        return $this->belongsTo(Deceased::class);
    }
}