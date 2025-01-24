<?php

namespace App\Services;

use App\Models;
use App\Services\UserService;
use App\Services\ItemRequestService;


class UserService {
	
	public static function listUser($request){
		
		$record=$request->record;
		$type=$request->type;
		
		
		
		if($record==null){			
//		leave open for possibility of listing all items

			return false;
		}	
		else {
			if($type=="search"){
//				return \App\Models\User::whereRaw("last_name like '%$record%%'")->get();

			}
			else if($type=="single"){
				
				return \App\Models\User::whereRaw("id=$record")->first();
			}
			else {
				return \App\Models\User::find($record)->first();

			}
				
		}	
		
	}
	


	public static function detailedUsers($request){
		
		$users=false;

		$users=\App\Services\UserService::listUser($request);
		
		if($users){
			if(($request->type)=="single"){
				$users->password="***";
				$users->username="***";
				$users->api_token="***";
				$profile=\App\Services\UserService::getDetailedUserProfile($users);
				if($profile){
					$users->profile=$profile->toArray();
				}
				else {
					$users->profile=$profile;
				}
				
	//			$users->profile=\App\Services\UserService::getDetailedUserProfile($users);	
				
			}
			
		}
		
		
		/*		




		if($users==true){	
			$i=0;

			foreach($users as $user){
				$users[$i]->profile=\App\Services\UserService::getDetailedUserProfile($user);
				$users[$i]->profile=$user->id;
				//$users[$i]->requests=ItemRequestService::listItemRequests($user);
				
				$i++;				
			}
			return $users;
		}
		else {
			return $users;
		}
		*/
		return $users;
	}
	
	public static function getUserProfile($request){

		$user_id=$request->id;
	
	
		$user=\App\Models\UserProfile::where("user_id",$user_id);	
//		$user=\App\Models\User::find($request->id)->first();	
		return $user;
	
	
	
	}
	public static function getDetailedUserProfile($request){

		$user=\App\Services\UserService::getUserProfile($request)->first();
		
		if($user){
			$address=\App\Services\UserService::getUserAddress($user->user_id);
			if($address){
				$user->address=$address->toArray();
			}
			$contact=\App\Services\UserService::getUserContact($user->user_id);
			if($contact){
				$user->contact=$contact->toArray();
			}
		}
		
		return $user;
	
	
	
	}
	

	public static function getUserAddress($request){
		$user=\App\Models\UserAddress::whereRaw("profile_id='".$request."'")->first();	
//		$user=$request;
		return $user;
	
	}

	public static function getUserContact($request){
		$user=\App\Models\UserContact::whereRaw("profile_id='".$request."'")->first();	
	
		return $user;
	
	}


	
	
	
}
?>



