<?php

namespace App\Http\Controllers;

use App\User;

use App\Services;
use App\Models;
//use \App\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Request;

class AuthController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id=null,$component=null)
	{
		
	}
	
	public function loginUser(){
		$input = \Request::all();
		$request=new \stdClass();

		
		$request->username=$input["username"];
		$request->password=$input["password"];

		
		 $auth=\App\Services\AuthService::loginUser($request);
		
//		 $auth=\App\Services\AuthService::login($request);
		
		
		 if($auth["confirm"]==false){
		 		
				 
		 return \Response::json($auth);
//			return response($auth,422);
		 }
		 else {
			 
		 return \Response::json($auth);
//			return response($auth,200); 
			 
		 }
		
		 if($auth==""){
			return "Login failed with ".$input['username'];
		 
		 }
		else if($auth==null){
		 	return \Response::json($auth);
		}
		else {
			return "No response";
		} 
		
	}
	public function retrieveUser($id){

		$request=new \stdClass();

		 $request->record=$id;
		 $request->type="single";		
		
		 $auth=\App\Services\UserService::detailedUsers($request);
		 return \Response::json($auth);
		
	}
	
	public function registerUser(){




	
		$input = Request::all();
		$request=new \stdClass();

		$request->username=$input['username'];
		$request->password=$input['password'];

		$request->name=$input['name'];
		$request->user_type=$input['user_type'];
		
		$auth=\App\Services\AddUserService::addUser($request);

//		return \Response::json($auth,200);
		return \Response::json($auth);
		
	}
	
	public static function logoutUser($request){
		$token = $request->user()->token();
		$token->revoke();
		$response = ['message' => 'You have been successfully logged out!'];
		return response($response, 200);		



	}		
	
	
	public function changePassword(){
		
		$input = Request::all();
		$request=new \stdClass();

		$request->user_id=$input['user_id'];
		$request->password=$input['password'];
		$request->new_password=$input['new_password'];

		
		$auth=\App\Services\AuthService::changePassword($request);

		return \Response::json($auth);
		
	}
	
	public function addUserProfile($id){

		$input = Request::all();
		$request=new \stdClass();


		$request->user_id=$id;
		
		$request->first_name=$input['first_name'];
		$request->middle_name=$input['middle_name'];
		$request->last_name=$input['last_name'];
//		$request->user_type=$input['user_type'];
		



		
		$auth=\App\Services\AddUserService::addUserProfile($request);
		return \Response::json($auth);
		
		
	}

	public function addUserAddress($id){
		$input = Request::all();
		$request2=new \stdClass();


		$request2->profile_id=$id;
		
		$request2->unit=$input['unit'];
		$request2->street=$input['street'];
		$request2->subdivision=$input['subdivision'];
		$request2->city=$input['city'];
		$request2->province=$input['province'];
		$request2->country_id=$input['country_id'];
		$request2->zip_code=$input['zip_code'];


		
		$auth=\App\Services\AddUserService::addUserAddress($request2);
		return \Response::json($auth);
	}
	public function addUserContact($id){

		$input = Request::all();
		$request2=new \stdClass();


		$request2->profile_id=$id;
		
		$request2->landline=$input['landline'];
		$request2->mobile=$input['mobile'];
		$request2->email=$input['email'];
	
		
		$auth=\App\Services\AddUserService::addUserContact($request2);
		return \Response::json($auth);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
			
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		
		
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
	
}
?>
