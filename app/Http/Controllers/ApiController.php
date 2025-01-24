<?php

namespace App\Http\Controllers;

use App\Services;
use App\Models;
//use \App\Controllers;
use Illuminate\Support\Str;
//use Illuminate\Http\Request;

use Request;

class ApiController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id=null,$component=null)
	{
		
	}
	
	public function refreshToken(Request $request){
		return \App\Services\ApiService::generateToken($request);
		
	}
	
	public function listCategory(){
		$item=\App\Services\CategoryService::listCategory()->toArray();
		return $item;
	}
	public function listCountry(){
		$item=\App\Services\CategoryService::listCountry()->toArray();
		return $item;
	}
	
	
	public function listFoundations(){
		$item=\App\Services\FoundationService::listFoundations()->toArray();
		return $item;
	}
	
	
	public function listItemType(){
		$item=\App\Services\CategoryService::listItemType()->toArray();
		return $item;
	}
	

	public function addCategory(){
		
		$input=Request::all();
		
		$request=$input["type"];
		
		$item=\App\Services\CategoryService::addCategory($request);
		return $item;
	}

	public function addFoundation(){
		
		$input=Request::all();
		
		$request=new \stdClass();
		
		$request->name=$input["name"];
		$request->address=$input["address"];
		$request->email=$input["email"];
		$request->contact_no=$input["contact_no"];
		
		$item=\App\Services\FoundationService::addFoundation($request);
		//return $item;
	
		return "Foundation successfully added";
	}
	
	public function addItemType(){

		
		$input=Request::all();
		
		$request=new \stdClass();
		$request->name=$input["name"];
		$request->duration=$input["duration"];

		$item=\App\Services\CategoryService::addItemType($request);
		return $item;
	}
	

	public function listReceivers(){
		$item=\App\Services\ReceiverService::listReceivers()->toArray();
		return $item;
	}

	public function addReceiver(){

		
		$input=Request::all();
		
		$request=new \stdClass();
		$request->firstName=$input["firstName"];
		$request->lastName=$input["lastName"];
		$request->position=$input["position"];

		$item=\App\Services\ReceiverService::addReceiver($request);
		return $item;
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
