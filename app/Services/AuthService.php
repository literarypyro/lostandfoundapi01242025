<?php

namespace App\Services;

use App\Models;
use App\Services\UserService;
use App\Services\ItemRequestService;
use App\Services\ApiService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;




class AuthService {


	public function login (Request $request) {
		$validator = Validator::make($request->all(), [
			'password' => 'required|string|min:6|confirmed',
		]);
		if ($validator->fails())
		{
			return response(['errors'=>$validator->errors()->all()], 422);
		}
		
		$username=$request->username;
		$password=$request->password;

		$user=\App\Models\User::whereRaw("username='$username'")->first();
		
		
		
//		$user = User::where('email', $request->email)->first();
		if ($user) {
			if (Hash::check($request->password, $user->password)) {
				$token = $user->createToken('Laravel Password Grant Client')->accessToken;
				$response = ['token' => $token,'user'=>$user->username,'name'=>$user->name,'userid'=>$user->id,'login_type'=>$user->login_type,'confirm'=>true];
				
				
			} else {
				$response = ["message" => "Password mismatch",'confirm'=>false];


			}
		
			return $response;
		
		} else {
			$response = ["message" =>'User does not exist','confirm'=>false];

			return $response;
		}
		
	}


	public static function loginUser($request){
		
		$username=$request->username;
		$password=$request->password;

		$auth["message"]="Invalid authentication";

	/*	
		if (Auth::attempt(array('username'=>$username, 'password'=>$password))) {

			$user=\App\Models\User::whereRaw("username='$username'")->first();
		
			$auth["message"]="User authenticated";
			$auth["user"]=$user->username;
			$auth["name"]=$user->name;
				
			$auth["userid"]=$user->id;
				
			$auth["token"]=$user->api_token;
			$auth["login_type"]=$user->login_type;
			$auth["confirm"]=true;



		} else {

			$auth["message"]="Invalid password";
			$auth["confirm"]=false;




		}		
		return $auth;
		*/
		
		$user=\App\Models\User::whereRaw("username='$username'")->first();
		
		
		
		if($user==""){
			$auth["message"]="Invalid credentials";
			$auth["confirm"]=false;


		}
		else {
//			if (Hash::check($password,$user->password)){

			if((md5($password)==($user->password))||(Hash::check($password,$user->password))){			
				
			$auth["message"]="User authenticated";
			$auth["user"]=$user->username;
			$auth["name"]=$user->name;
				
			$auth["userid"]=$user->id;
				
			$auth["token"]=$user->api_token;
			$auth["login_type"]=$user->login_type;
			$auth["confirm"]=true;				
				
			}
			
			else {
				$auth["message"]="Invalid password";
				$auth["confirm"]=false;

			}

		}
		return $auth;
		
	}
	
	public static function changePassword($request){
		$password=$request->password;
		$user_id=$request->user_id;
		$new_password=$request->new_password;


		$user=\App\Models\User::whereRaw("id='$user_id'")->first();				

//			$user=\App\Models\User::whereRaw("id='$user_id'")->first();

//		if (Auth::attempt(array('id'=>$user_id, 'password'=>$password))) {

		if (Hash::check($password,$user->password)){



			$user->password=Hash::make($new_password);
			$user->save();

			$auth["message"]="Password successfully changed";
			$auth["confirm"]=true;			
		}
		else {
			$auth["message"]="Invalid password";
			$auth["confirm"]=false;			
			
		}
		
		return $auth;
	}
	
	
}
?>



