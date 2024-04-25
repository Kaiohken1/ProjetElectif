<?php

namespace App\Models;

use App\Models\Appartement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    public function tag(): BelongsTo {
        return $this->belongsTo(Appartement::class);
    }
}
