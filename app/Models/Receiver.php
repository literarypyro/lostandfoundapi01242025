<?php
namespace App\Models;

use Eloquent;

class Receiver extends Eloquent {

	protected $table="receivers";

	public function receiver(){
		return $this->hasMany("\App\Models\FoundRecord","receiver_id");

	}


}
?>