<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appartement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'surface',
        'guestCount',
        'roomCount',
        'description',
        'price',
        'image'
    ];

    protected $hidden = [
        'availabillity'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
