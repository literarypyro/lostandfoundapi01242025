<?php

namespace App\Services;

use App\Models;
use App\Services\DeleteItemService;

class DeleteItemService {
	

	public static function deleteItem($request){
		$item=\App\Models\Item::where("id",$request)->first();

		$found_records_id=\App\Models\FoundRecord::where("id",$item->found_record_id)->first();

		$details_id=\App\Models\ItemDetail::where("item_id",$request)->first();


		$statuses=\App\Models\ItemStatus::where("item_id",$request)->get();			


		$i=0;

		foreach($statuses as $status){
			$statuses[$i]->delete();	


			$i++;
		}

		$details_id->delete();
		
		$item->delete();

		$found_records_id->delete();
		
		$response="Item deleted";
		
		return $response;		
	
	}



}	
?>



