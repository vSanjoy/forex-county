<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function countryDetail()
    {
        return $this->belongsTo(Country::class, 'country');
    }
}
