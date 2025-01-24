<?php

namespace App\Services;

use App\Models;
use App\Services\ModifyItemService;
use App\Services\ModifyEntryService;
use Intervention\Image\ImageManagerStatic as Image;


class ModifyItemService {
	
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
	
	public static function modifyFoundRecord($request,$item){
		$found_record=\App\Models\FoundRecord::where("id",$request)->first();
				
		$found_record=\App\Services\ModifyEntryService::modifyEntry($found_record,$item);
				
		return $found_record;
	


	
	}

	
	public static function modifyItem($request,$entry){
		/*
		$search_type=$request->search;
		$search_id=$request->id;
		if($search_type=="by_found"){
			$item=\App\Models\Item::where("found_record_id='".$search_id."'")->first();
			
		}
		else {
			*/
			$item=\App\Models\Item::where("id",$request)->first();
			/*
		}
*/
		$response=\App\Services\ModifyEntryService::modifyEntry($item,$entry);

		
//		$item->save();
		
		return $response;		
	
	}

	public static function modifyItemDetails($request,$item){

		$detail=\App\Models\ItemDetail::whereRaw("item_id='".$request."'")->first();
		
		
		if($item->modifyField=="picture"){
			$response=\App\Services\ModifyItemService::addPhoto($detail,$item);
		}
		else if($item->modifyField=="details") {
			
			
			$item_entry=\App\Models\Item::whereRaw("id='".$request."'")->first();

			
			$response=\App\Services\ModifyEntryService::modifyEntryDetails($item_entry,$item);
		}

		else if($item->modifyField=="particulars") {
			$response=\App\Services\ModifyEntryService::modifyEntryDetails($detail,$item);
		}

		else {
			$response=\App\Services\ModifyEntryService::modifyEntry($detail,$item);
		}
		//$detail->save();
		
		return $response;


	
	}

	public static function modifyItemIdentification($request,$item){
		$identification=\App\Models\Identification::whereRaw("item_id='".$request."'")->first();

		$identification=\App\Services\ModifyEntryService\modifyEntry($identification,$item);

//		$identification->save();



		return $identification;
	}
	public static function addPhoto($details,$request){
			$image=$request->photo;
			
			$fileName   = time() . '.' . $image->getClientOriginalExtension();

            $img = Image::make($image->getRealPath());
            $img->resize(420, 320, function ($constraint) {
                $constraint->aspectRatio();                 
            });

            $img->stream(); // <-- Key point



			
			$img->save(public_path()."/assets/images/items/".$fileName);
			
			
			$details->picture=$fileName;
			$details->save();
	}

}	
?>



