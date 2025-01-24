<?php
namespace App\Services;

use App\Models;
use App\Services\ItemService;
use App\Services\ModifyEntryService;
use Intervention\Image\ImageManagerStatic as Image;

class ModifyEntryService {

	public static function modifyEntry($item,$request){
		
		
		$field=$request->modifyField;
		$value=$request->modifyValue;
		
		$item->$field=$value;
		$item->save();
		
		return $item;

	}

	public static function modifyDescription($request,$item){
		
		$item_details=\App\Models\Item::whereRaw("id='".$request."'")->first();		
		$item_details->description=$item->description;
		
		$item_details->save();

		$result["description"]=$item_details->description;	
		


		return $result;

	}



	public static function removeEntry($item){
		$item->delete();
	}

	
	public static function modifyEntryDetails($request, $item){
		
				
		$item_details=\App\Models\ItemDetail::whereRaw("item_id='".$request."'")->first();		
		
		$item_details->shape=$item->shape;
		$item_details->color=$item->color;
		$item_details->width=$item->width;
		$item_details->length=$item->length;
		$item_details->other_details=$item->other_details;
		
		$item_details->save();


		$result["shape"]=$item_details->shape;
		$result["color"]=$item_details->color;
		$result["width"]=$item_details->width;
		$result["length"]=$item_details->length;
		$result["other_details"]=$item_details->other_details;
		



		return $result;



	}
	
	public static function modifyItemDetails($request, $item){
		
				
		$item_details=\App\Models\Item::whereRaw("id='".$request."'")->first();		
	
		$item_details->item_no=$item->item_no;
		$item_details->item_type_id=$item->item_type_id;
		$item_details->category_id=$item->category_id;
		
		$item_details->save();

		$found=\App\Models\FoundRecord::whereRaw("id='".$item_details->found_record_id."'")->first();	

		
		$found->found_date=$item->found_date;
		$found->location_id=$item->location_id;
		
		$found->save();


		$result["found_date"]=$found->found_date;
		$result["location_id"]=$found->location_id;
		
		$result["item_no"]=$item_details->item_no;
		$result["item_type_id"]=$item_details->item_type_id;
		$result["category_id"]=$item_details->category_id;		
		
		return $result;



	}

	public static function modifyPicture($request,$item){
		$item_details=\App\Models\ItemDetail::whereRaw("item_id='".$request."'")->first();		

			$image=$item->picture;
			
			$fileName   = time() . '.' . $image->getClientOriginalExtension();

            $img = Image::make($image->getRealPath());
            $img->resize(420, 320, function ($constraint) {
                $constraint->aspectRatio();                 
            });

            $img->stream(); // <-- Key point



            //dd();
			//Storage::disk('local')->put('images/items'.$fileName, $img, 'public');
			
			$img->save(public_path()."/assets/images/items/".$fileName);
			
			$item_details->picture=$fileName;
			$item_details->save();

			$res["picture"]=$item_details->picture;

			return $res;
	}
}
?>