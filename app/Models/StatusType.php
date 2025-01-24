<?php
namespace App\Models;

use Eloquent;

class StatusType extends Eloquent {

	protected $table="status_types";

	public function itemStatus(){
//		return $this->hasMany("\App\Models\Items","log_id")->whereRaw("log_type in ('cash','shortage','deposit') and transaction_type not in ('catransfer')");
		return $this->hasMany("\App\Models\ItemStatus","log_id");

	
	}

}
?>