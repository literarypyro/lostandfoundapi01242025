<?php

namespace App\Http\Controllers;

use App\Services;
use App\Models;
//use App\Http;
//use App\Http\Controllers;
//use App\Http\Controllers;
//use Request;
use Illuminate\Http\Request;


class FoundItemController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id=null,$component=null)
	{
		
		
		return $this->retrieveItem($id);

	}
	public function search($search_type,$search_term=null,$daterange=null)
	{

		
		$request=new \stdClass();

		
		$request->record=$search_term;

		$request->type=$search_type;
		
		if($search_type=="daily"){
    		    $date=explode("to",$daterange);
							
		    $start_date=date("Y-m-d",strtotime($date[0]));
		    $end_date=$start_date;
                    $request->daterange=$start_date." to ".$end_date;

                 	$request->type="daterange";

			

		}
		else if($search_type=="monthly"){
    		    $date=explode("to",$daterange);

		    $month=date("m",strtotime($date[0]));	
		    $year=date("Y",strtotime($date[0]));	
		    $day=date("d",strtotime($date[0]));	
 
							
		    $start_date=$year."-".$month."-".$day;
		    $end_date=$year."-".$month."-31";
                    $request->daterange=$start_date." to ".$end_date;
                 	$request->type="daterange";


		}
		else {
		    $request->daterange=$daterange;
		}


		$item=\App\Services\ItemService::listItems($request)->toArray();
		
		return \Response::json($item);
		
		
	}

	public function listRecent()
	{
		
		$item=$this->search("recent",1,date("Y-m-d"));
		
		
		return \Response::json($item);
		
		
	}

	public function listFound()
	{
		
		$item=$this->search("all_found",1,date("Y-m-d"));
		
		
		return \Response::json($item);
		
		
	}



	public function listDisposed()
	{
		
		$item=$this->search("disposed",1,date("Y-m-d"));
		
		
		return \Response::json($item);
		
		
	}
	
	
	public function listAllDisposed()
	{
		
		$item=$this->search("alldisposed",1,date("Y-m-d"));
		
		
		return \Response::json($item);
		
		
	}	
	public function dateRangeFound($search_type,$daterange){


		$item=$this->search($search_type,"",$daterange);
		
		
		return \Response::json($item);


	}

	public function dateRangeSearch($search_type,$search_term,$daterange){


		$item=$this->search("daterange",$search_term,$daterange);
		
		
		return \Response::json($item);


	}

	public function itemTypeSearch($search_type,$search_term,$daterange){


		$item=$this->search("itemType",$search_term,$daterange);
		
		
		return \Response::json($item);


	}

	public function categorySearch($search_type,$search_term,$daterange){


		$item=$this->search("category",$search_term,$daterange);
		
		
		return \Response::json($item);


	}

	public function retrieveItem($id){
		
		$item=\App\Models\Item::find($id);
		

		$item->details=\App\Services\ItemService::getItemDetails($item->id)->first()->toArray();
		
		$status=\App\Services\ItemService::getItemStatus($item->id)->first();
		
		if($status){
			$item->status=$status->toArray();
		}
		$item->category=\App\Services\ItemService::getCategory($item)->first()->toArray();
		$item->itemType=\App\Services\ItemService::getItemType($item)->first()->toArray();
		
		$latest_status=\App\Services\ItemService::getLatestStatus($id);
				$found_s=\App\Models\FoundRecord::whereRaw("id=".$item->found_record_id)->first();	
				$found=$found_s->toArray();
				$location=\App\Services\ItemService::getLocation($found_s);

				$item->location=$location;
				$item->found_record=$found;		
				
				
				
				$date_f=$found["found_date"];
				$item->found_record_label=date("F d, Y", strtotime($date_f));
		if($latest_status){
		
			$item->latest_status=$latest_status->toArray();
		}
		//	$item->user=\App\Services\ItemService::getUser($id)->toArray();
		


		return \Response::json($item);
	}
	
	public function status($id,$latest=null){
		
		$item=\App\Models\Item::find($id);
		
		if($latest==1){
			
			$status=\App\Services\ItemService::getLatestStatus($item->id);
			
			if($status){
					$item_status->status=$status->toArray();
			}
			else {
				
			}
		}
		else {
			$item->status=\App\Services\ItemService::getItemStatus($item->id)->toArray();
			
		}
		return \Response::json($item);
	}
	public function removeItem($id){
		
//		$input = Request::all();
//		$request=new stdClass();

//		$item_id=$id;
		
		$key=\App\Services\DeleteItemService::deleteItem($id);


		return $key;
		
	}	

	public function filterSearch(Request $requestitem){
		$input=$requestitem->all();
		$request=new \stdClass();		

		$request->dateRange=$input['dateRange'];
		$request->itemType=$input['itemType'];
		$request->category=$input['category'];
		$request->searchTerm=$input['searchTerm'];
		
		$advanced=$input['advanced'];
		if($advanced==true){
			$request->shape=$input['shape'];
			$request->color=$input['color'];
			$request->width=$input['width'];
			$request->length=$input['length'];
			$request->other_details=$input['other_details'];
			
			$item=\App\Services\ItemService::advancedFilter($request);
		}
		else {
			$item=\App\Services\ItemService::filterSearch($request);
		
		}

		if($item){
			return \Response::json($item)->getContent();

			
		}

	}

	public function recentList(){
//		$input=$requestitem->all();
		$request=new \stdClass();		


		$start_date=date("Y-m-d");
		
		$end_date=date("Y-m-d", strtotime('-6 months',strtotime(date("Y-m-d"))));



		$request->dateRange=$start_date." to ".$end_date;

		
		$item=\App\Services\ItemService::recentList($request);

		
		if($item){
			echo \Response::json($item)->getContent();

			
		}	
	}


	public function allList(){
//		$input=$requestitem->all();
		$request=new \stdClass();		


		$start_date=date("Y-m-d");
		
		$end_date=date("Y-m-d", strtotime('-10 years',strtotime(date("Y-m-d"))));



		$request->dateRange=$start_date." to ".$end_date;

		
		$item=\App\Services\ItemService::recentList($request);

		
		if($item){
			echo \Response::json($item)->getContent();

			
		}	
	}


	public function addItem(Request $requestitem){
		
		$input = $requestitem->all();
		$request=new \stdClass();


		if($input["found_date"]==""){
			$request->found_date=date("Y-m-d");

		}
		else {
			$request->found_date=date("Y-m-d",strtotime(str_replace("\"","",$input["found_date"])));
//			$request->found_date=$input["found_date"];
		}
		$request->receiver_id=$input["receiver_id"];
		$request->location_id=$input["location_id"];
		
//		try {
		$found_record=$request;
		
		$request->found_record_id=\App\Services\AddItemService::addFoundRecord($request);
		//		$request->found_record_id=1;
//		}
//		catch($error){
//			throw $error;
//		}

		$request->item_no=str_replace("\"","",$input["item_no"]);

		
		$request->description=str_replace("\"","",$input["description"]);



		//$request->description=$_POST["description"];
		
		$request->category=$input['category'];
		$request->item_type=$input['item_type'];

		//$request->category=1;
		//$request->item_type=1;
		

		if(($request->category=="4")||($request->category=="21")){
		
			if($input['identification_ref_no']==""){
				$request->identification_ref_no="";
			}
			else {
				$request->identification_ref_no=$input['identification_ref_no'];
			}
			
			
			if($input['identification_type']==""){
				$request->identification_type="";
			}
			else {
				$request->identification_type=$input['identification_type'];
			}
		}
		
		$key=\App\Services\AddItemService::addItem($request);
		$request->item_id=$key;

		/*
		$request->shape=$input['shape'];
		$request->color=$input['color'];
		$request->length=$input['length'];
		$request->width=$input['width'];
		$request->other_details=$input['other_details'];
		*/
		
		
		$request->shape=$this->fillVoid($input['shape']);
		$request->color=$this->fillVoid($input['color']);
		$request->length=$this->fillVoid($input['length']);
		$request->width=$this->fillVoid($input['width']);
		$request->other_details=$this->fillVoid($input['other_details']);
		
		
//		$request->photo="";		
		$request->photo=$requestitem->file('file');


		$response=\App\Services\AddItemService::addItemDetails($request);
//		$request->status=1;
		
		$request->status_date=date("Y-m-d  H:i:s");
		$request->status_type_id=1;
		$request->status_details="Found Item Recorded";
		
		$request->received_by="";

		\App\Services\AddItemStatusService::addItemStatus($request);

///		return $request->category;
		return \Response::json($request);
	
	}
	public function addParticular($found_record_id,Request $request){
		
		$input = $request->all();
		$request=new stdClass();

		$request->found_date=date("Y-m-d");
		$request->found_record_id=$found_record_id;
		//		$request->found_record_id=1;



		$request->description=$input["description"];
		$request->category=$input['category'];
		$request->item_type=$input['item_type'];

		if(($request->category=="4")||($request->category=="21")){
		
			if($input['identification_ref_no']==""){
				$request->identification_ref_no="";
			}
			else {
				$request->identification_ref_no=$input['identification_ref_no'];
			}
			
			
			if($input['identification_type']==""){
				$request->identification_type="";
			}
			else {
				$request->identification_type=$input['identification_type'];
			}
		}


		
		$key=\App\Services\AddItemService::addItem($request);
		
		
		
		
		$request->item_id=$key;

		$request->shape=$this->fillVoid($input['shape']);
		$request->color=$this->fillVoid($input['color']);
		$request->length=$this->fillVoid($input['length']);
		$request->width=$this->fillVoid($input['width']);
		$request->other_details=$this->fillVoid($input['other_details']);
		$request->photo=Input::file('file');
		
		
		
		

		$response=\App\Services\AddItemService::addItemDetails($request);
//		$request->status=1;
		
		$request->status_date=date("Y-m-d  H:i:s");
		$request->status_type_id=1;
		$request->status_details="Found Item Recorded";
		$request->received_by="N/A";

		\App\Services\AddItemStatusService::addItemStatus($request);

		return \Response::json($response);
	
	
	}


	public function fillVoid($element){
		
		if(($element=="")||($element==null)){
			$element="";
		}
		
		return str_replace("\"","",$element);
		
		
	}
	
	public function modifyItemStatus(Request $request){

		$input = $request->all();
		$request=new \stdClass();

		$request->status_date=date("Y-m-d H:i:s");

		$request->item_id=$input["item_id"];
		$request->status_type_id=$input["status_type"];
		$request->status_details=$input["details"];
		if($input["status_type"]==6){
					
			$request->received_by=$input["received_by"];
		}
		else {
			$request->received_by="N/A";
		}
		
		$request->foundation_id="null";
		
		
		$response=\App\Services\AddItemStatusService::addItemStatus($request);

		/*

		if($status_type_id==3){
			\App\Services\AddItemStatuService::addClaim($request);
	
		}
		*/

		if($request->status_type_id==5){
			
			$request->status_id=$response["id"];
			$request->details=$request->status_details;
			$request->disposal_date=date("Y-m-d");			
			
			\App\Services\AddItemStatusService::addDisposal($request);
		}
		
		
		
		return \Response::json($response);
	}
	public function markExpired(){

		$range="";
		$response=\App\Services\ItemService::listExpired($range,"recent");
		
		
		
		return \Response::json($response);
		
	}
	public function markAllExpired(){

		$range="";
		$response=\App\Services\ItemService::listExpired($range,"all");
		
		
		
		return \Response::json($response);
		
	}



	public function modifyItem($id,$type, Request $request){

		$input = $request->all();
		$item=new \stdClass();

		if($input["editField"]=="found_date"){
			$item->modifyValue=date("Y-m-d",strtotime($input["editValue"]));	
		}
//		else if($input["editField"]=="picture"){
//			$item->modifyValue=Input::file('editValue');
			
/*			if($item->modifyValue==""){
				$response="problem";
			}
	*/		
//		}
		else {
			$item->modifyValue=$input["editValue"];
		}
		
		$item->modifyField=$input["editField"];
		
		
		
//		$item=$input["item_updates"];
		if($type=="found_record"){
			$response=\App\Services\ModifyItemService::modifyFoundRecord($id,$item);	
			
		}
		else if($type=="item"){
			$response=\App\Services\ModifyItemService::modifyItem($id,$item);
			
		}	
	
		
		else if($type=="description"){
			$item->description=$input['description'];
			$response=\App\Services\ModifyEntryService::modifyDescription($id,$item);

		}			
		else if($type=="picture"){
			$item->picture=$request->file('file');
			$response=\App\Services\ModifyEntryService::modifyPicture($id,$item);

		}			
		else if($type=="details"){

			$item->item_id=$input["item_id"];
			$item->item_no=$input["item_no"];
			$item->location_id=$input["location"];
			$item->category_id=$input["category"];
			$item->item_type_id=$input["item_type"];
			$item->found_date=$input["found_date"];
			
			
		
			$response=\App\Services\ModifyEntryService::modifyItemDetails($id,$item);
			
		}	
		
		
		else if($type=="particulars"){

			$item->item_id=$input["item_id"];
			$item->shape=$input["shape"];
			$item->color=$input["color"];
			$item->width=$input["width"];
			$item->length=$input["length"];
			$item->other_details=$input["other_details"];
			
			
		
			$response=\App\Services\ModifyEntryService::modifyEntryDetails($id,$item);
			
		}	
		else if($type=="identification"){
			$response=\App\Services\ModifyItemService::modifyItemIdentification($id,$item);
		}	
		return \Response::json($response);

	}

	public function listLocations(){
		
		
		$locations=\App\Services\LocationService::listLocations();
			
		return \Response::json($locations);
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
