<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function resolveRouteBinding($value, $field = null) {
        return $this->where('id', customEncryptionDecryption($value, 'decrypt'))->firstOrFail();
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
