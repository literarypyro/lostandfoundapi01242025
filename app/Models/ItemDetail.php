<?php
namespace App\Models;

use Eloquent;

class ItemDetail extends Eloquent {

	protected $table="item_details";

	public function item(){
//		return $this->hasMany("\App\Models\Items","log_id")->whereRaw("log_type in ('cash','shortage','deposit') and transaction_type not in ('catransfer')");
		return $this->belongsTo("\App\Models\ItemDetail","item_id");
	}

}
?>