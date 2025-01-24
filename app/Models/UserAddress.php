<?php
namespace App\Models;

use Eloquent;

class UserAddress extends Eloquent {

	protected $table="user_address";

	public function country(){
//		return $this->hasMany("\App\Models\Items","log_id")->whereRaw("log_type in ('cash','shortage','deposit') and transaction_type not in ('catransfer')");
		return $this->hasOne("\App\Models\Country","log_id");

	
	}


}
?>