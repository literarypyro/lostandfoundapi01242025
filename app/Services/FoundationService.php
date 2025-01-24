<?php

namespace App\Services;

use App\Models;
use App\Services\FoundationService;


class FoundationService {
	
	public static function listFoundations(){
		
		return \App\Models\Foundation::get();
		
		/*
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
		*/
	}

	public static function addFoundation($request){
		$foundation=new \App\Models\Foundation;
		
		$foundation->name=$request->name;
		$foundation->address=$request->address;
		$foundation->email=$request->email;
		$foundation->contact_no=$request->contact_no;
		
		$foundation->save();
		
		$foundation->message=true;
		return  $foundation;
	}
	
	public static function addItemStatus($request){
		$item_request=new \App\Models\ItemStatus;
		
		$item_request->item_id=$request->item_id;
		$item_request->status_date=$request->status_date;
		$item_request->status_type_id=$request->status_type_id;
		$item_request->details=$request->status_details;
		$item_request->received_by=$request->received_by;
		
		$item_request->save();
		
		$item_request->message=true;
		return  $item_request;
	}

	
	public static function addClaim($request){
		$details=new \App\Models\Claim;
			
		$details->request_id=$request->request_id;
		$details->status_id=$request->status_id;
		$details->claim_date=$request->claim_date;
			
		$details->save();
	}		

	public static function addDisposal($request){
		$details=new \App\Models\Disposal;
			
		$details->status_id=$request->status_id;
		$details->details=$request->details;
		$details->disposal_date=$request->disposal_date;
			
		$details->save();
	}

}

?>



