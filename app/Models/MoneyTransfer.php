<?php
/*
    * Class name    : MoneyTransfer
    * Purpose       : Table declaration
    * Author        :
    * Created Date  : 25/01/2023
    * Modified date :
*/


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoneyTransfer extends Model
{
    use HasFactory;

    /*
        * Function name : countryDetails
        * Purpose       : To get country details
        * Author        :
        * Created Date  : 25/01/2023
        * Modified Date : 
        * Input Params  : 
        * Return Value  : 
    */
    public function countryDetails() {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /*
        * Function name : senderDetails
        * Purpose       : To get sender details
        * Author        :
        * Created Date  : 25/01/2023
        * Modified Date : 
        * Input Params  : 
        * Return Value  : 
    */
    public function senderDetails() {
        return $this->belongsTo(User::class, 'user_id');
    }

    /*
        * Function name : receiverDetails
        * Purpose       : To get receiver details
        * Author        :
        * Created Date  : 25/01/2023
        * Modified Date : 
        * Input Params  : 
        * Return Value  : 
    */
	public function receiverDetails() {
        return $this->belongsTo(User::class, 'recipient_id');  // Recipient::class
    }

    /*
        * Function name : senderBankAccountDetails
        * Purpose       : To get sender bank account details
        * Author        :
        * Created Date  : 25/01/2023
        * Modified Date : 
        * Input Params  : 
        * Return Value  : 
    */
	public function senderBankAccountDetails() {
        return $this->belongsTo(BankAccount::class, 'bank_account_id');
    }
	
    /*
        * Function name : senderCountryDetails
        * Purpose       : To get sender country details
        * Author        :
        * Created Date  : 25/01/2023
        * Modified Date : 
        * Input Params  : 
        * Return Value  : 
    */
	public function senderCountryDetails() {
        return $this->hasOne(Country::class, 'id', 'sender_country_id');
    }

}
