<?php
namespace App\Models;

use Eloquent;

class Status extends Eloquent {

	protected $table="status";

	public function itemRequests(){
//		return $this->hasMany("\App\Models\Items","log_id")->whereRaw("log_type in ('cash','shortage','deposit') and transaction_type not in ('catransfer')");
		return $this->belongsTo("\App\Models\ItemRequest","log_id");

	
	}

}
?>