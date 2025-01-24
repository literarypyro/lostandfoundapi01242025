<?php
namespace App\Models;

use Eloquent;

class ItemStatus extends Eloquent {

	protected $table="item_statuses";

	public function itemClaim(){
//		return $this->hasMany("\App\Models\Items","log_id")->whereRaw("log_type in ('cash','shortage','deposit') and transaction_type not in ('catransfer')");
		return $this->hasOne("\App\Models\Claim","log_id");
	}	

	public function disposal(){
//		return $this->hasMany("\App\Models\Items","log_id")->whereRaw("log_type in ('cash','shortage','deposit') and transaction_type not in ('catransfer')");
		return $this->hasOne("\App\Models\Disposal","log_id");
	}	

	public function statusType(){
//		return $this->hasMany("\App\Models\Items","log_id")->whereRaw("log_type in ('cash','shortage','deposit') and transaction_type not in ('catransfer')");
		return $this->belongsTo("\App\Models\StatusType","status_type_id");
	}	

}
?>