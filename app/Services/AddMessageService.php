<?php

namespace App\Services;

use App\Models;
use App\Services\AddMessageService;


class AddMessageService {
	
	public static function listItems($request){
		
		$record=$request->record;
		$type=$request->type;
		
		
		//Based on Request Date
		
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
	
	public static function addItemRequest($request){
		$item_request=new \App\Models\ItemRequest;
		
		$item_request->user_id=$request->user_id;
		$item_request->status_id=1;
		$item_request->category_id=$request->category;
		$item_request->description=$request->description;
		$item_request->request_date=$request->request_date;
		
		$item_request->save();
		
		return $item_request->id;
	}

	public static function addMessage($request){
		$message=new \App\Models\Message;
		
		$message->request_id=$request->request_id;
		$message->user_id=$request->user_id;
		$message->message_date=$request->message_date;
		$message->message=$request->message;
		
		$message->save();
		
		return $message->id;
	}

	
	public static function addRequestDetails($request){
		$details=new \App\Models\RequestDetail;
		
		$details->request_id=$request->request_id;
//		$details->category_id=1;
		$details->color=$request->color;
		$details->shape=$request->shape;
		$details->length=$request->length;
		$details->width=$request->width;
		$details->other_details=$request->other_details;
		$details->save();
		
		$response["message"]="Data successfully added";
		
		return $response;
	}

}

?>



