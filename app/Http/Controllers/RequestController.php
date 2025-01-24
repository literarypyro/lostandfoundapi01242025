<?php

namespace App\Http\Controllers;

use App\Services;
use App\Models;
//use \App\Controllers;
use Illuminate\Http\Request;

class RequestController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id=null,$component=null)
	{

		return $this->retrieveRequest($id);
	}
	public function search($search_type,$search_term=null)
	{
		$request=new \stdClass();
		$request->record=$search_term;
		$request->type=$search_type;
	//	$item=\App\Services\ItemRequestService::listRequest($request)->toArray();
		$item=\App\Services\ItemRequestService::detailedItemRequests($request)->toArray();

		return \Response::json($item);
	}

	public function listMessages($id){
		$request=new stdClass();
		$request->request_id=$id;
		
		$message=\App\Services\MessageService::listMessages($request);

		return \Response::json($message);

	}
	
	
	public function retrieveRequest($id){
		$item=\App\Models\ItemRequest::find($id);
		$item->details=\App\Services\ItemRequestService::getRequestDetails($item);
		$item->category=\App\Services\ItemRequestService::getCategory($item);
		$item->user_info=\App\Services\ItemRequestService::getUserInformation($item);

//		$item->status=\App\Services\ItemRequestService::getRequestStatus($item->id)->latest()->get()->toArray();

		return \Response::json($item);
	}
	
	public function status($id,$latest=null){
		$item=\App\Models\ItemRequest::find($id);

		if($latest==1){
			
			$status=\App\Services\ItemRequestService::getLatestStatus($id);
			
			if($status){
					$item->status=$status->toArray();
			}
			else {
				
			}
		}
		else {
			$item->status=\App\Services\ItemRequestService::getRequestStatus($id)->toArray();

		
		}

		return \Response::json($item);
	}

	public function addRequest($id){
		
		$input = Input::all();

		$request=new stdClass();

		$request->user_id=$input['user_id'];

		$request->status=1;

		if($input["request_date"]==""){
			$request->request_date=date("Y-m-d");

		}
		else {
			$request->request_date=date("Y-m-d",strtotime($input["request_date"]));
		}	

		$request->description=$input["description"];

		

		$request->shape=$this->fillVoid($input['shape']);
		$request->category=$this->fillVoid($input['category']);
		$request->color=$this->fillVoid($input['color']);
		$request->length=$this->fillVoid($input['length']);
		$request->width=$this->fillVoid($input['width']);
		$request->other_details=$this->fillVoid($input['other_details']);
		
		$key=\App\Services\AddItemRequestService::addItemRequest($request);

		$request->request_id=$key;

		$response=\App\Services\AddItemRequestService::addRequestDetails($request);

		$request->status_date=date("Y-m-d");
		$request->status_type_id=1;
		$request->status_details="Request Received";

		\App\Services\AddRequestStatusService::addRequestStatus($request);

		
		return \Response::json($response);
	}
	

	public function addMessage($id){
		
		$input = Input::all();

		$request=new stdClass();

		$request->request_id=$id;


		$request->request_id=$id;
		$request->user_id=$input['user_id'];
		$request->message_date=date("Y-m-d H:i:s");
		$request->message=$input['message'];
		

		$response=\App\Services\AddMessageService::addMessage($request);

		
		return \Response::json($response);
	}	
	public function fillVoid($element){
		
		if($element==""){
			return "N/A";
		}
		
		return $element;
		
		
	}
	
	public function addClaim(Request $reqItem){
		$input=$reqItem->all();
		$request=new \stdClass();
		$request->claim_date=$input['claim_date'];
		$request->request_id=$input['request_id'];
		$request->picture=$reqItem->file('file');
		$request->details=$input['details'];
		
		$response=\App\Services\ItemRequestService::addClaim($request);
		
	}
	
	
	

	public function modifyRequestStatus(Request $request){

		$input = Input::all();
		$request=new \stdClass();

		$request->status_date=date("Y-m-d H:i:s");

		$request->request_id=$input["request_id"];
		$request->status_type_id=$input["status_type"];
		$request->status_details=$input["details"];

		$request->status_type=\App\Models\StatusType::find($request->status_type_id)->first();

		
		
		$response=\App\Services\AddRequestStatusService::addRequestStatus($request);

		if($request->status_type_id==3){
			$request->status_id=$response->id;
			$request->details=$request->status_details;

			$request->claim_date=date("Y-m-d H:i:s");

			\App\Services\AddRequestStatusService::addClaim($request);
	
		}

		
		
		return \Response::json($response);
	}

	
	public function modifyRequest($id,$type){
		
		$input = Input::all();
//		$request=new stdClass();

		$request=$input["request_updates"];
		
		if($type=="details"){
			\App\Services\ModifyItemRequestService::modifyRequestDetails($id,request);	
			
		}
		else if($type=="request"){
			\App\Services\ModifyItemRequestService::modifyItemRequest($id,request);
			
		}
		
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
