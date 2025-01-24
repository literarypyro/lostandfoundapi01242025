<?php

namespace App\Services;

use App\Models;
use App\Services\ModifyItemRequestService;
use App\Services\ModifyEntryService;



class ModifyItemRequestService {
	
	public static function listItems($request){
		
		$record=$request->record;
		$type=$request->type;
		
		if($record==null){			
//		leave open for possibility of listing all items
			return false;
		}	
		else {
			if($type=="category"){
				
				return \App\Models\Item::whereRaw("category_id='$record'")->get();
			}
			else if($type=="itemType"){
				return \App\Models\Item::whereRaw("item_type_id='$record'")->get();
				
			}
			else if($type=="search"){
				return \App\Models\Item::whereRaw("item_title like '%%$record%'")->get();

			}
			else if($type=="single"){
				return \App\Models\Item::find($record)->first();
			}
			else {
				return \App\Models\Item::whereRaw("record_id='$record'")->get();
			}
		}	
		
	}
	
	public static function modifyItemRequest($request,$item){
		$item_request=\App\Models\ItemRequest::find($request)->first();
		
		
		$item_request=\App\Services\ModifyEntryService::modifyEntry($item_request,$item);
		



		$item_request->save();
		
		
		
		
		return $item_request;
	}




	public static function modifyRequestDetails($request,$item){
		$details=\App\Models\RequestDetails::whereRaw("item_request_id='".$request."')"->first();

		$details=\App\Services\ModifyEntryService::modifyEntry($details,$item);

		$details->save();
		
		return $details;
	}

}

?>



