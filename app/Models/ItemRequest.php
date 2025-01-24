<?php
namespace App\Models;

use Eloquent;

class ItemRequest extends Eloquent {

	protected $table="item_requests";

	public function itemClaim(){
//		return $this->hasMany("\App\Models\Items","log_id")->whereRaw("log_type in ('cash','shortage','deposit') and transaction_type not in ('catransfer')");
		return $this->hasOne("\App\Models\Claim","log_id");
	}	

	public function requestDetail(){
//		return $this->hasMany("\App\Models\Items","log_id")->whereRaw("log_type in ('cash','shortage','deposit') and transaction_type not in ('catransfer')");
		return $this->hasOne("\App\Models\RequestDetail","request_id");
	}	

	public function requestStatus(){
		return $this->hasMany("\App\Models\RequestStatus","request_id");
	}	

	public function category(){
		return $this->belongsTo("\App\Models\Category","category_id");
	}	

	public function user(){
		return $this->belongsTo("\App\Models\User","user_id");
	}	
	
}
?>