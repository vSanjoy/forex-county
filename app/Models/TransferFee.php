<?php
/*
    * Class name    : TransferFee
    * Purpose       : Table declaration
    * Author        :
    * Created Date  : 24/01/2023
    * Modified date :
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransferFee extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];    // The field name inside the array is not mass-assignable

    /*
        * Function name : resolveRouteBinding
        * Purpose       : Resolve route binding
        * Author        :
        * Created Date  : 20/01/2023
        * Modified Date : 
        * Input Params  : 
        * Return Value  : 
    */
    public function resolveRouteBinding($value, $field = null) {
        return $this->where('id', customEncryptionDecryption($value, 'decrypt'))->firstOrFail();
    }

    /*
        * Function name : currencyDetails
        * Purpose       : Currency details
        * Author        :
        * Created Date  : 24/01/2023
        * Modified Date : 
        * Input Params  : 
        * Return Value  : 
    */
    public function currencyDetails() {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    /*
        * Function name : countryDetails
        * Purpose       : Country details
        * Author        :
        * Created Date  : 24/01/2023
        * Modified Date : 
        * Input Params  : 
        * Return Value  : 
    */
    public function countryDetails() {
        return $this->belongsTo(Country::class, 'country_id');
    }

}
