<?php
namespace App\Models;

use Eloquent;

class UserProfile extends Eloquent {

	protected $table="user_profiles";

	public function address(){
//		return $this->hasMany("\App\Models\Items","log_id")->whereRaw("log_type in ('cash','shortage','deposit') and transaction_type not in ('catransfer')");
		return $this->hasOne("\App\Models\UserAddress","profile_id");

	
	}

	public function contactNo(){
//		return $this->hasMany("\App\Models\Items","log_id")->whereRaw("log_type in ('cash','shortage','deposit') and transaction_type not in ('catransfer')");
		return $this->hasOne("\App\Models\UserContact","profile_id");

	
	}

}
?>