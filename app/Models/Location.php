<?php
namespace App\Models;

use Eloquent;

class Location extends Eloquent {

	protected $table="locations";

	public function foundRecords(){
//		return $this->hasMany("\App\Models\Items","log_id")->whereRaw("log_type in ('cash','shortage','deposit') and transaction_type not in ('catransfer')");
		return $this->hasMany("\App\Models\FoundRecord","location_id");

	
	}

//	public function itemRequests(){
//		return $this->hasMany("\App\Models\Items","log_id")->whereRaw("log_type in ('cash','shortage','deposit') and transaction_type not in ('catransfer')");
//		return $this->hasMany("\App\Models\ItemRequests","log_id");

	
//	}

}
?>