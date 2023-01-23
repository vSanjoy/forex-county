<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bank extends Model
{
    use HasFactory;

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
