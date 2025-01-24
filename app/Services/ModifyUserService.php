<?php

namespace App\Services;

use App\Models;
use App\Services\ModifyUserService;
use App\Services\ModifyEntryService;


class ModifyUserService {
	
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
	
	public static function modifyUser($request){
		$user=\App\Models\User::find($request)->first();
		return $user;
	
	}

	
	public static function modifyUserProfile($request){
		$details=\App\Models\UserProfile::whereRaw("user_id='".$request."')"->first();
		return $details;
		
	}

	public static function modifyUserAddress($request){
		$details=\App\Models\UserAddress::whereRaw("profile_id='".$request."')"->first();
		return $details;
	
	}

	public static function addUserContact($request){
		$details=\App\Models\UserContact::whereRaw("profile_id='".$request."')"->first();
		return $details;

	
	}
	
}

?>



