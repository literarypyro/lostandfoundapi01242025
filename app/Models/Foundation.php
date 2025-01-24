<?php
namespace App\Models;

use Eloquent;

class Foundation extends Eloquent {

	protected $table="foundations";

	public function items(){
//		return $this->hasMany("\App\Models\Items","log_id")->whereRaw("log_type in ('cash','shortage','deposit') and transaction_type not in ('catransfer')");
		return $this->hasMany("\App\Models\Item","category_id");
		//hasManyThrough
	}
	
	public function disposals(){
		return $this->hasMany("\App\Models\Disposal","foundation_id");

	}

	public function itemRequests(){
//		return $this->hasMany("\App\Models\Items","log_id")->whereRaw("log_type in ('cash','shortage','deposit') and transaction_type not in ('catransfer')");
		return $this->hasMany("\App\Models\ItemRequests","log_id");

	
	}

}
?>