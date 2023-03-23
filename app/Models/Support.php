<?php
/*
    * Class name    : Support
    * Purpose       : Table declaration
    * Author        :
    * Created Date  : 21/03/2023
    * Modified date :
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    protected $guarded = ['id'];    // The field name inside the array is not mass-assignable

    /*
        * Function name : resolveRouteBinding
        * Purpose       : Resolve route binding
        * Author        :
        * Created Date  : 21/03/2023
        * Modified Date : 
        * Input Params  : 
        * Return Value  : 
    */
    public function resolveRouteBinding($value, $field = null) {
        return $this->where('id', customEncryptionDecryption($value, 'decrypt'))->firstOrFail();
    }

    /*
        * Function name : userDetails
        * Purpose       : User details
        * Author        :
        * Created Date  : 21/03/2023
        * Modified Date : 
        * Input Params  : 
        * Return Value  : 
    */
    public function userDetails() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
