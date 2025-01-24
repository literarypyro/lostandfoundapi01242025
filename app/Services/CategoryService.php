<?php
namespace App\Services;

use App\Models;
use App\Services\CategoryService;

class CategoryService {

	public static function modifyEntry($item,$request){
		$field=$request->modifyField;
		$value=$request->modifyValue;
		
		$item->$field=$value;
		$item->save();

	}

	public static function addCategory($request){
		$item=new \App\Models\Category;
		
		$item->type=$request;	
		
		
		
		$item->save();
		return $item->id;
	


	
	}
	
	public static function addItemType($request){
		$item=new \App\Models\ItemType;

		$item->name=$request->name;
		$item->duration=$request->duration;

		$item->save();
		return $item->id;
	}
	
	public static function listItemType(){
		$item=\App\Models\ItemType::all();
		return $item;
	}
	
	public static function listCategory(){
		$item=\App\Models\Category::all();
		return $item;
	}

	public static function listCountry(){
		$item=\App\Models\Country::all();
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