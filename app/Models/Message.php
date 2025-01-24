<?php
namespace App\Models;

use Eloquent;

class Message extends Eloquent {

	protected $table="messages";

/*	public function itemDetail(){
//		return $this->hasMany("\App\Models\Items","log_id")->whereRaw("log_type in ('cash','shortage','deposit') and transaction_type not in ('catransfer')");
		return $this->hasOne("\App\Models\ItemDetail","item_id");
	}

	public function identification(){
		return $this->hasOne("\App\Models\Identification","item_id");
	}
	
	public function itemStatus(){
		return $this->hasOne("\App\Models\ItemStatus","item_id");
	}
	public function itemType(){
		return $this->belongsTo("\App\Models\ItemType","item_type_id");
	}

	
	public function category(){
		return $this->belongsTo("\App\Models\Category","category_id");
	}
	
	public function foundRecord(){
		return $this->belongsTo("\App\Models\FoundRecord","found_record_id");
	}
	
*/
}
?>