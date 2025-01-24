<?php
namespace App\Services;

use App\Models;
use App\Services\LocationService;

class LocationService {

	public static function modifyEntry($item,$request){
		$field=$request->modifyField;
		$value=$request->modifyValue;
		
		$item->$field=$value;
		$item->save();

	}

	public static function addCategory($request){
		$item=new \App\Models\Location;
		
		$item->location=$request;
		$prefix=date("Ymd")."-";
		$iterator=rand(0,1000);
		

		$item->code=$prefix.$iterator;
		
		$item->save();
		return $item->id;
	


	
	}
	
	
	public static function listLocations(){
		$item=\App\Models\Location::all();
		return $item;
	}

	

	
	
	
	public static function removeEntry($item){
		$item->delete();
	}

	

}
?>