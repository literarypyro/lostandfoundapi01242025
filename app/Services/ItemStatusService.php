<?php

namespace App\Services;

use App\Models;
use App\Services\ItemStatusService;


class ItemStatusService {
	
	public static function listStatus($request){
		
		$record=$request->record;
		$type=$request->type;
		
		return \App\Models\Item::with("ItemStatus")->find($record)->orderBy("status_date","DESC")->get();
		
		
	}
	


	public static function detailedItemStatus($request){
		
		
		$itemStatuses=false;

		$itemStatuses=ItemStatusService::listStatus($request);
		
		if($itemStatuses==true){	
			$i=0;

			foreach($itemStatuses as $itemStatus){
				$itemStatuses[$i]->type=ItemStatusService::getStatusType($itemRequest);
				$itemStatuses[$i]->details=ItemStatusService::getStatusDetails($itemRequest);
				
				$i++;				
			}
			return $itemStatuses;
		}
		else {
			return $itemStatuses;
		}
		return $itemStatuses;
	}


	public static function getCategory($request){


		return \App\Models\ItemStatus::with("StatusType")->find($request)->statusType($request)->first();
	
	
	}
	public static function getStatusDetails($request){

		$itemStatus=false;
		$itemStatus=\App\Models\ItemRequest::with("RequestDetail")->find($request)->requestDetail($request)->first();

		switch($itemStatus->status_type_id){
			case 1:
				$disposal=\App\Models\ItemStatus::with("Disposal")->find($request)->disposal($request)->first();
				if($disposal->foundation_id==""){
				}
				else {
					$foundation=$disposal->foundation()->first();
				}
			
				$itemStatus->disposal=$disposal;
			
			
			
			end
			
			case 1:
				$itemStatus->claim=\App\Models\ItemStatus::with("Claim")->find($request)->claim($request)->first();
			
			end
			
			
			
		}

		
		
		return $itemStatus;
	
	
	
	}

	
}
?>



