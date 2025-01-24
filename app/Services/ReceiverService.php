<?php
namespace App\Services;

use App\Models;
use App\Services\ReceiverService;

class ReceiverService {
/*
	public static function modifyEntry($item,$request){
		$field=$request->modifyField;
		$value=$request->modifyValue;
		
		$item->$field=$value;
		$item->save();

	}
*/
	public static function addReceiver($request){
		$item=new \App\Models\Receiver;
		
		$item->firstName=$request->firstName;	
		$item->lastName=$request->lastName;	
		$item->position=$request->position;	
		
		
		
		$item->save();
		return $item->id;
	


	
	}
	
	
	public static function listReceivers(){
		$item=\App\Models\Receiver::orderBy("lastName","DESC")->get();
		return $item;
	}
	

	
	
	
	public static function removeEntry($item){
		$item->delete();
	}

	
	public static function modifyEntryDetails($request, $item){



		for($i=0;$i<count($item);$i++){
			$field=$item[$i]["type"];
			$field_value=$item[$i]["value"];

			$request->$field=$field_value;


		}


		return $request;



	}

}
?>