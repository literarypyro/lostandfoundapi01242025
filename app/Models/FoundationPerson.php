<?php
namespace App\Models;

use Eloquent;

class FoundationPerson extends Eloquent {

	protected $table="foundation_persons";

	public function foundation(){
//		return $this->hasMany("\App\Models\Items","log_id")->whereRaw("log_type in ('cash','shortage','deposit') and transaction_type not in ('catransfer')");
		return $this->belongsTo("\App\Models\Foundation","foundation_id");

	
	//hasManyThrough
	
	}

	public function itemRequests(){
//		return $this->hasMany("\App\Models\Items","log_id")->whereRaw("log_type in ('cash','shortage','deposit') and transaction_type not in ('catransfer')");
		return $this->hasMany("\App\Models\ItemRequests","log_id");

	
	}

}
?>