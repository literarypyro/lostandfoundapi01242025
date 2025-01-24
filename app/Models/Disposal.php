<?php
namespace App\Models;

use Eloquent;

class Disposal extends Eloquent {

	protected $table="disposals";

	public function foundation(){
		return $this->belongsTo("\App\Models\Foundation","foundation_id");

	
	
	}


}
?>