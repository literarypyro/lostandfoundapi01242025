<?php

namespace App\Services;


use Auth;
use App\Models;
use App\Services\AddItemService;

use Intervention\Image\ImageManagerStatic as Image;

class AddItemService {
	
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
	
	public static function addFoundRecord($request){
		

		$found_record=new \App\Models\FoundRecord;
		
		$found_record->found_date=$request->found_date;
		$receiver_id=$request->receiver_id;
		
		$reference_number=\App\Services\AddItemService::processReferenceNumber($request);
	
	
		//$user=Auth::user();
		$user_id=1;
		//$user_id=$user->id;
	
		$found_record->user_id=$user_id;
		$found_record->receiver_id=$receiver_id;

		$found_record->location_id=$request->location_id;



		$found_record->reference_number=$reference_number;
		

		$found_record->save();
		
		return $found_record->id;



	
	}

	public static function processReferenceNumber($request,$iter=null){
		
		
		$location=$request->location_id;
		$found_date=date("Y-m-d",strtotime($request->found_date));
		$fprefix=date("Ymd",strtotime($request->found_date));
		
		if($iter==null){
			
			$found_record=\App\Models\FoundRecord::select(\DB::raw("location_id,found_date,count(1) iterator"))->whereRaw("found_date like '%$found_date%%' and location_id=$location")
			->groupBy(\DB::raw("location_id,found_date"))->first();
			
			if($found_record){
				$iterator=$found_record->iterator;
			}
			else {
				$iterator=1;

			}
			$iterator++;
			
		}
		else {
			$iterator=$iter;
		}
		
		
		
		return $location."-".$fprefix."-".$iterator;
		
		
	}


	
	public static function addItem($request){
		$item=new \App\Models\Item;
		
		$item->found_record_id=$request->found_record_id;
		$item->item_no=$request->item_no;

		$item->item_type_id=$request->item_type;
		$item->category_id=$request->category;
		$item->description=$request->description;
		$item->item_type_id=$request->item_type;
//		$item->category_id=1;
		
		
		
//		$item->found_date=$request->found_date;
		
		$item->save();

		if(($request->category=="4")||($request->category=="21")){
			
			if($request->identification_ref_no==""){
				
			}
			else {
				$request->item_id=$item->id;
				
				\App\Services\AddItemService::addItemIdentification($request);
			}
					
			
		}

		return $item->id;
	


	
	}

	
	public static function addPhoto($details,$request){

//		if ($request->hasFile('photo')) {
            //$image      = $request->file('file');
			$image=$request->photo;
			
			$fileName   = time() . '.' . $image->getClientOriginalExtension();

            $img = Image::make($image->getRealPath());
            $img->resize(420, 320, function ($constraint) {
                $constraint->aspectRatio();                 
            });

            $img->stream(); // <-- Key point



            //dd();
			//Storage::disk('local')->put('images/items'.$fileName, $img, 'public');
			
			
			$img->save(public_path()."/assets/images/items/".$fileName);
			
			
			$details->picture=$fileName;
			$details->save();

//		}	
	
	}
	
	public static function addItemDetails($request){
		$details=new \App\Models\ItemDetail;
		
		$details->item_id=$request->item_id;
		$details->color=$request->color;
		$details->shape=$request->shape;
		$details->length=$request->length;
		$details->width=$request->width;
		$details->other_details=$request->other_details;
		
		$details->save();

		

		
	
		\App\Services\AddItemService::addPhoto($details,$request);

	
	}

	public static function addItemIdentification($request){
		$identification=new \App\Models\Identification;
		$identification->reference_number=$request->identification_ref_no;
		$identification->identification_type=$request->identification_type;
		$identification->item_id=$request->item_id;
		$identification->save();
	
	}

}	
?>



