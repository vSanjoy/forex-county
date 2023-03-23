<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryUser extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function resolveRouteBinding($value, $field = null) {
        return $this->where('id', customEncryptionDecryption($value, 'decrypt'))->firstOrFail();
    }

    /*
        * Function name : countryDetails
        * Purpose       : To get country details
        * Author        :
        * Created Date  :
        * Modified Date :
        * Input Params  :
        * Return Value  :
    */
    public function countryDetails() {
        return $this->belongsTo('App\Models\Country', 'country_id');
    }
}