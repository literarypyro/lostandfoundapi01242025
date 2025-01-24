<?php
namespace App\Models;

use Eloquent;

class Claim extends Eloquent {

	protected $table="claims";

	public function itemStatus(){
		return $this->belongsTo("\App\Models\UserContact","status_id");

	
	}

	public function itemRequest(){
		return $this->belongsTo("\App\Models\ItemRequest","request_id");

	
	}


}
?>