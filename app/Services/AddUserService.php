<?php

namespace App\Services;

use App\Models;
use App\Services\AddUserService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Request;

class AddUserService {
	
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
	
	public static function addUser($request){
		$user=new \App\Models\User;
/*
		$validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
			'password' => 'required|string|min:6|confirmed',
		]);
		if ($validator->fails())
		{
			return response(['errors'=>$validator->errors()->all()], 422);
		}
		
		*/
		/*
		$user["username"]=$request->username;
		$user['name']=$request->name;
		$user['password']=Hash::make($request->password);
		$user['remember_token'] = Str::random(60);
		$new_user = User::create($user->toArray());
		$token = $new_user->createToken('Laravel Password Grant Client')->accessToken;
		$response = ['token' => $token,'auth_id'=>$user->id];

*/

//		return response($response, 200);



	
		$user->username=$request->username;
		$user->password=Hash::make($request->password);
		$user->name=$request->name;
		$user->login_type=$request->user_type;
        $user->api_token=Str::random(60);	
        $user->remember_token=Str::random(60);	
			
		$user->save();
		
		
		$auth["user_id"]=$user->id;
		return $auth;

	
	}

	
	public static function addUserProfile($request){
		
		$profile=\App\Models\UserProfile::whereRaw("user_id='".$request->user_id."'")->first();
		
		if($profile){
			$details=$profile;

		}	
		else {
			$details=new \App\Models\UserProfile;

			
		}
		$details->user_id=$request->user_id;
		$details->first_name=$request->first_name;
		$details->last_name=$request->last_name;
		$details->middle_name=$request->middle_name;
		$details->save();
		$auth["profile_id"]=$details->id;
		$message="Profile successfully saved";
		return $auth;
	
	}

	public static function addUserAddress($request){
		$address=\App\Models\UserAddress::whereRaw("profile_id='".$request->profile_id."'")->first();
		
		if($address){
			$details=$address;

		}	
		else {
			$details=new \App\Models\UserAddress;

			
		}
		
		$details->profile_id=$request->profile_id;
		$details->unit=$request->unit;
		$details->street=$request->street;
		$details->subdivision=$request->subdivision;
		$details->city=$request->city;
		$details->province=$request->province;
		$details->zip_code=$request->zip_code;
		$details->country_id=$request->country_id;
		$details->save();
	
		$auth["profile_id"]=$request->profile_id;
		return $auth;

	
	}

	public static function addUserContact($request){

		$address=\App\Models\UserContact::whereRaw("profile_id='".$request->profile_id."'")->first();
		
		if($address){
			$details=$contact;

		}	
		else {
			$details=new \App\Models\UserContact;
			
		}
		
		$details->profile_id=$request->profile_id;
		$details->landline=$request->landline;
		$details->mobile=$request->mobile;
		$details->email=$request->email;
		
		$details->save();
		
		$auth["profile_id"]=$details->profile_id;
		return $auth;
	
	}
	
}

?>



