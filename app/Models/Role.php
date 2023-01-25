<?php
/*
    * Class name    : Role
    * Purpose       : Table declaration
    * Author        :
    * Created Date  :
    * Modified date :
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

	/*
        * Function name : permissions
        * Purpose       : To get permissions
        * Author        :
        * Created Date  :
        * Modified Date : 
        * Input Params  : 
        * Return Value  : 
    */
	public function permissions() {
		return $this->hasMany(RolePermission::class, 'role_id');
	}

	/*
        * Function name : rolePermissionToRolePage
        * Purpose       : To get role permission pages
        * Author        :
        * Created Date  :
        * Modified Date : 
        * Input Params  : 
        * Return Value  : 
    */
    public function rolePermissionToRolePage() {
        return $this->belongsToMany(RolePage::class, 'role_permissions', 'role_id', 'page_id');
    }
    
}