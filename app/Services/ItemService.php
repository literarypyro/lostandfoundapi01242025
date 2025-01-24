<?php

namespace App\Services;

use App\Models;
use App\Services\ItemService;
use Illuminate\Support\Facades\DB;

class ItemService {
	
	public static function listItems($request){
		
		$record=$request->record;
		$type=$request->type;
		
		
		$range=$request->daterange;
		
		//Based on Found Date
		
		if(($record==null)&&($type!="daterange")){

			
			
//		leave open for possibility of listing all items
			return false;
		}	
		else {
			if($type=="category"){
//				return \App\Models\Item::whereRaw("category_id='$record'")->get();

			
			
				$categories=\App\Models\Category::whereRaw("type like '%%$record%'")->get();
				
				
				if($categories==true){
					$i=0;
					foreach($categories as $category){
						$categories[$i]->items=\App\Models\Category::find($category->id)->items()->get();
						$categories[$i]->category=$category->type;
					
						if($range==""){
						$items=\App\Models\Item::whereRaw("category_id='".$category->id."'")->get();
							
						}
						else {
							

							$date=explode("to",$range);
							
							$start_date=date("Y-m-d",strtotime($date[0]));
							$end_date=date("Y-m-d",strtotime($date[1]));
							
							$items=\App\Models\Item::select('found_records.*','items.*','items.id as item_id')->join('found_records', 'items.found_record_id', '=', 'found_records.id')->whereRaw("category_id='".$category->id."' and found_date between '".$start_date." 00:00:00' and '".$end_date." 23:59:59'")->get();
			
			
			

							
						}
					
//						$items=$categories[$i]->items;
//						$items=$items_base::whereRaw('description like %%watch%%');
						
						$k=0;
						foreach($items as $item){
							$item->category=$item->category()->first()->toArray();
							$item->item_type=$item->itemType()->first()->toArray();

							
							$item->found_record=$item->foundRecord()->first();
							$item_label=$item->found_record;
							
							$found=$item->found_record->toArray();
							
							$found_date_label=date("F d, Y",strtotime($found['found_date']));
							
							$item_label->found_date_label=$found_date_label;
								
							$item->found_record=$item_label;
							

							$item->details=\App\Models\ItemDetail::whereRaw("item_id=".$item->id)->first()->toArray();
							
							
							
							
							$k++;
						}

						$categories[$i]->items=$items->toArray();

						$categories[$i]->itemCount=$k;

						$i++;
					}
					
				}
			
				//return \App\Models\Category::whereRaw("type like '%%$record%'")->get();
				$categories->search_type=$type;
			
			
				return $categories;
			
			
			
			
			}
			else if($type=="searchfound"){
				
			
			
			}
	
			else if(($type=="disposed")||($type=="alldisposed")){
				
				
				
				
				$items=\App\Models\Item::join('item_statuses', 'items.id', '=', 'item_statuses.item_id')->whereRaw("status_type_id='5'");
				
				
				if($type=="disposed"){
					$items=$items->limit(20);
					
				}
				
				$items=$items->get();
				
				//whereRaw("description like '%%$record%'")->get();
					if(($items)==true){
						$k=0;
									
									
						foreach($items as $item){
	
							
							$found_record=\App\Models\FoundRecord::whereRaw("id=".$item->found_record_id)->first();

							$items[$k]->found_record=$found_record->toArray();

							

							$user=\App\Models\User::whereRaw("id=".$found_record->user_id)->first();

							if($user==""){
							
							$items[$k]->user="";
							}
							else {

							$items[$k]->user=$user->toArray();
							}
									
								$items[$k]->found_date_label=date("F d, Y",strtotime($found_record['found_date']));

							$items[$k]->details=\App\Models\ItemDetail::whereRaw("item_id=".$item->item_id)->first()->toArray();
							$items[$k]->category=\App\Models\Category::whereRaw("id=".$item->category_id)->first()->toArray();
							$items[$k]->item_type=\App\Models\ItemType::whereRaw("id=".$item->item_type_id)->first()->toArray();
							$latest_stat=\App\Services\ItemService::getLatestStatus($item->id);
							
							if($latest_stat==""){
								$items[$k]->is_claimed="Unclaimed";
								
							}
							else {
									$items[$k]->latest_status=$latest_stat->toArray();
							}
									
									
									
							$k++;
						}		
					}



					$items->search_type=$type;
					
				return $items;		
			}

			else if($type=="itemType"){
//				return \App\Models\Item::whereRaw("item_type_id='$record'")->get();
				
				//\App\Models\Category::whereRaw("type like '%%$record%'")->get();


					
				$itemTypes=\App\Models\ItemType::whereRaw("name like '%%$record%'")->get();

				if($itemTypes==true){
					$i=0;
					foreach($itemTypes as $itemType){
						$itemTypes[$i]->items=\App\Models\ItemType::find($itemType->id)->items()->get();

						


							


						
						$itemTypes[$i]->item_type=$itemType->name;
//						$items=$itemTypes[$i]->items;

					

					
					
					
					
						if($range==""){
						$items=\App\Models\Item::whereRaw("item_type_id='".$itemType->id."'")->get();
							
						}
						else {
							

							$date=explode("to",$range);
							
							$start_date=date("Y-m-d",strtotime($date[0]));
							$end_date=date("Y-m-d",strtotime($date[1]));
							
							$items=\App\Models\Item::select('found_records.*','items.*','items.id as item_id')->join('found_records', 'items.found_record_id', '=', 'found_records.id')->whereRaw("item_type_id='".$itemType->id."' and found_date between '".$start_date." 00:00:00' and '".$end_date." 23:59:59'")->get();
			
			
			

							
						}

						
						$k=0;
						foreach($items as $item){

							$item->category=$item->category()->first()->toArray();
							$item->item_type=$item->itemType()->first()->toArray();
						
							$item->found_record=$item->foundRecord()->first();
							$item_label=$item->found_record;
							
							$found=$item->found_record->toArray();
							
							$found_date_label=date("F d, Y",strtotime($found['found_date']));
							
							$item_label->found_date_label=$found_date_label;
								
							$item->found_record=$item_label;
							

  						    $details=\App\Models\ItemDetail::whereRaw("item_id=".$item->id)->first();
							if($details==""){
								$item->details="No details available";
							}
							else {
								$item->details=$details->toArray();
							}

							$k++;
						}

						$itemTypes[$i]->items=$items->toArray();
						
						$itemTypes[$i]->itemCount=$k;

						$i++;
					}
				}
			
				//return \App\Models\Category::whereRaw("type like '%%$record%'")->get();
			
				$itemTypes->search_type=$type;

			
				return $itemTypes;
			
				
			}
			
			else if($type=="daterange"){

					

					$date=explode("to",$range);
					
					$start_date=date("Y-m-d",strtotime($date[0]));
					$end_date=date("Y-m-d",strtotime($date[1]));
					
					
					if($record==""){
						$items=\App\Models\Item::select('found_records.*','items.*','items.id as item_id')->join('found_records', 'items.found_record_id', '=', 'found_records.id')->whereRaw("found_date between '".$start_date." 00:00:00' and '".$end_date." 23:59:59'")->get();
					}

					else {
						$items=\App\Models\Item::select('found_records.*','items.*','items.id as item_id')->join('found_records', 'items.found_record_id', '=', 'found_records.id')->whereRaw("items.description like '%%$record%%' and found_date between '".$start_date." 00:00:00' and '".$end_date." 23:59:59'")->get();
	
					}
			

					
					
					
					if(($items)==true){
						$k=0;
									
									
						foreach($items as $item){
							
							if($item->item_id==""){
								$item_id=$item->id;
															
							}
							else {
								$item_id=$item->item_id;
							}
							
							$record=\App\Models\FoundRecord::whereRaw("id=".$item->found_record_id)->first();



							$found=$record->toArray();							
							$found['found_date_label']=date("F d, Y",strtotime($found['found_date']));

							$items[$k]->found_record=$found;
							
							
								$location=\App\Services\ItemService::getLocation($record);

								if($location){
									$items[$k]->location=$location->toArray();
								
								}							
							
							$items[$k]->details=\App\Models\ItemDetail::whereRaw("item_id=".$item_id)->first()->toArray();
							$items[$k]->category=\App\Models\Category::whereRaw("id=".$item->category_id)->first()->toArray();
							$items[$k]->item_type=\App\Models\ItemType::whereRaw("id=".$item->item_type_id)->first()->toArray();
							
							$latest_stat=\App\Services\ItemService::getLatestStatus($item->id);
							
							if($latest_stat==""){
								$items[$k]->is_claimed="Unclaimed";
								
							}
							else {
									$items[$k]->latest_status=$latest_stat->toArray();
									if($latest_stat->status_type_id==3){
										$items[$k]->is_claimed="Claimed";
									}
									else {
										$items[$k]->is_claimed="Unclaimed";
									}
							}
							
							
									
									
							$k++;
						}		
					}



					$items->search_type=$type;
				return $items;	

				
//				return \App\Models\Item::whereRaw("title like '%%$record%'")->get();
			}			
			else if($type=="search"){

				if($range==""){
				$items=\App\Models\Item::whereRaw("description like '%%$record%'")->get();
					
				}
				else {

					$date=explode("to",$range);
					
					$start_date=date("Y-m-d",strtotime(trim($date[0])));
					$end_date=date("Y-m-d",strtotime(trim($date[1])));


					
					$items=\App\Models\Item::select('found_records.*','items.*','items.id as item_id')->join('found_records', 'items.found_record_id', '=', 'found_records.id')->whereRaw("description like '%%$record%' and found_date between '".$start_date." 00:00:00' and '".$end_date." 23:59:59'")->get();
	

				}
					
					
					if(($items)==true){
						$k=0;
									
									
						foreach($items as $item){
							
							if($item->item_id==""){
								$item_id=$item->id;
															
							}
							else {
								$item_id=$item->item_id;
							}
							
							
							
							$items[$k]->found_record=\App\Models\FoundRecord::whereRaw("id=".$item->found_record_id)->first()->toArray();
							$items[$k]->details=\App\Models\ItemDetail::whereRaw("item_id=".$item_id)->first()->toArray();
							$items[$k]->category=\App\Models\Category::whereRaw("id=".$item->category_id)->first()->toArray();
							$items[$k]->item_type=\App\Models\ItemType::whereRaw("id=".$item->item_type_id)->first()->toArray();
							$latest_stat=\App\Services\ItemService::getLatestStatus($item->id);
							
							if($latest_stat==""){
								$items[$k]->is_claimed="Unclaimed";
								
							}
							else {
								$items[$k]->latest_status=$latest_stat->toArray();
							}
									
									
									
							$k++;
						}		
					}



					$items->search_type=$type;
				return $items;	

				
//				return \App\Models\Item::whereRaw("title like '%%$record%'")->get();
			}
			else if($type=="limited_search"){

			
			
			
				$categories=\App\Models\Item::select('category_id', DB::raw('count(*) as total'))->whereRaw("description like '%%$record%'")->groupBy("category_id")->get();
				
				
				
				$i=0;
				
				foreach($categories as $category){
					
					
					$cat=\App\Models\Category::find($category->category_id)->first();
					
					$categories[$i]->category=$cat->type;
					$categories[$i]->itemCount=$category->total;
				}
					
					
					
					
			
				
				return $categories;
					

				
//				return \App\Models\Item::whereRaw("title like '%%$record%'")->get();
			}



			else if($type=="single"){
				$item=\App\Models\Item::find($record)->first();
				$location=\App\Services\ItemService::getLocation($record);
				$found=\App\Models\FoundRecord::whereRaw("id=".$item->found_record_id)->first()->toArray();							

				$item->location=$location;
				$item->found_record=$found;


				return $item;
			}
			else if($type=="all"){
//				return \App\Models\Item::orderBy('found_date', 'DESC')->get();
				return \App\Models\Item::all();
			}
			else if($type=="expired"){
				return \App\Services\ItemService::listExpired($range);
			

			}
			else if(($type=="recent")||($type=="all_found")){
				
//				$recent_date=date_create(date("Y-m-d",strtotime("2000-07-01")));
				$recent_date=date_create(date("Y-m-d"));

//				date_sub($recent_date,date_interval_create_from_date_string("240 days"));
					
				
				
//				$rec=\App\Models\FoundRecord::whereRaw("found_date>='".date_format($recent_date,"Y-m-d")." 00:00:01'")->get();


			if($type=="all_found"){

				$records=\App\Models\FoundRecord::orderBy('found_date','DESC')->get();

			}
			else {
				$rec=\App\Models\FoundRecord::orderBy('found_date','DESC')->limit(20);
				$records=$rec->get();	
				
			}
				

				if($records==true){	
						$i=0;
						
						$prevDate="";
						$prevLocation="";
						$iter=1;
						
//						$new_records=new \stdClass();
						
						
						foreach($records as $record){
								$receiver=\App\Services\ItemService::getReceiver($record);

								if($receiver){
									$record->receiver=$receiver->toArray();
									
									
									
								}
								$location=\App\Services\ItemService::getLocation($record);

								if($location){
									$record->location=$location->toArray();
								
								}
								
								if($prevLocation==""){
								
									$prevLocation=$record->location_id;
									$iter=1;
								}
								else {
									if($prevLocation==$record->location_id){		
																		
										if($prevDate==""){
											$prevDate=$record->found_date;		
										}
										else {
											if(date("Y-m-d",strtotime($prevDate))==date("Y-m-d",strtotime($record->found_date))){
												$iter++;
												
											}
											else {
												$prevDate=$record->found_date;
												
												$iter=1;
												
											}
										}
									
									
									}
									else {
										$prevLocation=$record->location_id;
										$iter=1;
									}
									
									
									
									
								}
								
								
								if($record->reference_number==""){
									$record->reference_number=\App\Services\AddItemService::processReferenceNumber($records[$i],$iter);
									
								}
									
													

							
								
								
								

							$record->items=\App\Models\FoundRecord::find($record->id)->items()->whereRaw("item_type_id not in ('3')")->get();
								if(($record->items)==true){
								$k=0;
									
								$items=$record->items;	
									
								foreach($items as $item){
									$items[$k]->user=\App\Models\UserProfile::whereRaw("user_id=".$record->user_id)->get()->toArray();

									$items[$k]->details=\App\Models\ItemDetail::whereRaw("item_id=".$item->id)->get()->toArray();
									$items[$k]->category=\App\Models\Category::whereRaw("id=".$item->category_id)->first()->toArray();
								//$items[$k]->found_record=$found;
									$found=\App\Models\FoundRecord::whereRaw("id=".$item->found_record_id)->first()->toArray();							
									//$found['found_date_label']=date("F d, Y",strtotime($found['found_date']));								

									$check=\App\Models\ItemType::whereRaw("id=".$item->item_type_id)->first();
									
									if($check){
										$items[$k]->item_type=$check->toArray();
										
									}
									
									$items[$k]->found_date_label=date("F d, Y",strtotime($found['found_date']));
									
									
									
									
									$latest_stat=\App\Services\ItemService::getLatestStatus($item->id);
									
									if($latest_stat){
									
										$items[$k]->latest_status=$latest_stat->toArray();

										if($k==0){
											
											$record->latest_st=$latest_stat->status_type_id;		
										}
										
									}
									$k++;
								}
								
								$record->items=$items->toArray();
							
							
							}
							
							//$new_records->appends($record);
							
							$i++;				

						}
						
				$found_r = $records->filter(function($record)
						{
							if(($record->latest_st==4)||($record->latest_st==5))
							{
								
								
								
							}
							else {
								return $record;
							}
					 });						
				
						return $found_r;
				}
				else {
					return $new_records;
				}
				
				
				
				
				
				
				
//				return $records;
						
			}
			else if($type=="found_record"){

				$record_id=$record;
				$recent_date=date("Y-m-d",strtotime(date("Y-m-d")."-5 months"));

				$found_records=\App\Models\FoundRecord::whereRaw("id=$record and 'found_date'>'".$recent_date." 00:00:01'")->take(1)->get();
				if($found_records==true){	
						$i=0;
						foreach($found_records as $found_record){
							$found_records[$i]->items=\App\Models\Item::whereRaw("found_record_id='$record_id'")->get();
								if(($found_records[$i]->items)==true){
								$k=0;
									
								$items=$found_records[$i]->items;	
									
								foreach($items as $item){
									$items[$k]->details=\App\Models\ItemDetail::whereRaw("item_id=".$item->id)->get()->toArray();
									$k++;
								}
								
								$found_records[$i]->items=$items->toArray();
							}
							$i++;				
						}
						return $found_records;
				}
				else {
					return $found_records;
				}

//				return \App\Models\Item::whereRaw("found_record_id='$record'")->get();
			}
			else {
				return \App\Models\Item::whereRaw("found_record_id='$record'")->get();
			}
		}	
	}
	
	public static function filterSearch($request){
		
		$range=$request->dateRange;
		
		$date=explode("to",$range);
					
		$start_date=date("Y-m-d",strtotime($date[0]));
		$end_date=date("Y-m-d",strtotime($date[1]));
		
		$category_id=$request->category;
		$item_type_id=$request->itemType;
		$searchTerm=$request->searchTerm;

		$conditionClause.=\App\Services\ItemService::conditionBuilder("category_id",$category_id);
		$conditionClause.=\App\Services\ItemService::conditionBuilder("item_type_id",$item_type_id);

		if($searchTerm!=""){
			$conditionClause.=" and UPPER(description) like '%%".strtoupper($searchTerm)."%%' ";
			
		}
		
		
		$item=DB::table("items")->join("found_records",'items.found_record_id','=','found_records.id')->whereRaw("found_date between '".$start_date." 00:00:00' and '".$end_date." 23:59:59' ".$conditionClause." order by found_date desc")->get();	
		if($item){
		
		
			foreach($item as $i){
				$i->latest_stat=\App\Services\ItemService::getLatestStatus($i->id);
				$i->category=\App\Services\ItemService::getCategory($i);	

				$i->item_type=\App\Services\ItemService::getItemType($i);	

			}
			return $item->toArray();

		}
		else {
			
			return "";
		}

		
	}

	public static function advancedFilter($request){
		
		$range=$request->dateRange;
		
		$date=explode("to",$range);
					
		$start_date=date("Y-m-d",strtotime($date[0]));
		$end_date=date("Y-m-d",strtotime($date[1]));
		
		$category_id=$request->category;
		$item_type_id=$request->itemType;
		$searchTerm=$request->searchTerm;
		
		$shape=$request->shape;
		$color=$request->color;
		$width=$request->width;
		$length=$request->length;
		$other_details=$request->other_details;
		
		$conditionClause="";

		$conditionClause.=\App\Services\ItemService::conditionBuilder("category_id",$category_id);
		$conditionClause.=\App\Services\ItemService::conditionBuilder("item_type_id",$item_type_id);

		$conditionClause.=\App\Services\ItemService::conditionBuilder("shape",$shape);
		$conditionClause.=\App\Services\ItemService::conditionBuilder("color",$color);
		$conditionClause.=\App\Services\ItemService::conditionBuilder("width",$width);
		$conditionClause.=\App\Services\ItemService::conditionBuilder("length",$length);
//		$conditionClause.=\App\Services\ItemService::conditionBuilder("other_details",$other_details);

		$conditionClause.=\App\Services\ItemService::conditionBuilder("description",$searchTerm);
		
		
		$conditionalClause="found_date between '".$start_date." 00:00:00' and '".$end_date." 23:59:59' ".$conditionClause." order by found_date desc";	
		$item=DB::table("items")->join("found_records",'items.found_record_id','=','found_records.id')->join("item_details",'item_details.item_id','=','items.id')->whereRaw($conditionalClause)->get();	
		if($item){
		
		
			foreach($item as $i){
				$i->latest_stat=\App\Services\ItemService::getLatestStatus($i->item_id);
				$i->category=\App\Services\ItemService::getCategory($i);	

				$i->item_type=\App\Services\ItemService::getItemType($i);	

			}
			return $item->toArray();

		}
		else {
			
			return "";
		}
		
	}

	public static function conditionBuilder($type,$term){
		if(($term!="") && ($term!="N/A") && ($term!="undefined")){

			if($type=="description"){
				return " and UPPER(description) like '%%".strtoupper($term)."%%' ";
			
			}
			else {
				return " and ".$type."='".$term."' ";	
			}
		}
		else {



			return "";
		}
	}

	public static function recentList($request){
		
		$range=$request->dateRange;
		
		$date=explode("to",$range);
					
		$start_date=date("Y-m-d",strtotime($date[1]));
		$end_date=date("Y-m-d",strtotime($date[0]));

		$item=DB::table("items")->join("found_records",'items.found_record_id','=','found_records.id')->whereRaw("found_records.found_date between '".$start_date." 00:00:00' and '".$end_date." 23:59:59' order by found_date desc")->get();	

		if($item){
		
		
			foreach($item as $i){
				$i->latest_stat=\App\Services\ItemService::getLatestStatus($i->id);
				$i->category=\App\Services\ItemService::getCategory($i);	

				$i->item_type=\App\Services\ItemService::getItemType($i);	

			}
			return $item->toArray();

		}
		else {
			
			return "";
		}

		
	}

	public static function detailedItems($request){
		
		$items=false;

		$items=ItemService::listItems($request);
		
		if($items==true){	
			$i=0;

			foreach($items as $item){
				$items[$i]->details=ItemService::getItemDetails($item);
				$items[$i]->status=ItemService::getItemStatus($item);
				
				$i++;				
			}
			return $items;
		}
		else {
			return $items;
		}
		return $items;
	}

	

	
	
	public static function getItemDetails($request){
		$item=\App\Models\Item::with("ItemDetail")->find($request)->itemDetail();	

		
		$item->item_type=\App\Models\Item::with("ItemType")->find($request)->itemType()->first()->toArray();
	
		
		$category=\App\Models\Item::with("Category")->find($request)->category()->first();
		$item->category=$category->toArray();
	
		if($category->id==5){
			$ident=\App\Models\Item::with("Identification")->find($request)->identification()->first();
			if($ident){
			$item->identification=$ident->toArray();
			}
		}
		return $item;

	}

	public static function getUser($request){
		$item=\App\Models\Item::with("User")->find($request)->user()->first();	

		
		return $item;

	}


	public static function getCategory($request){




		$category=\App\Models\Category::whereRaw("id='".$request->category_id."'")->first();
	

		return $category;
	
	
	
	}
	public static function getItemType($request){

		$item_type=\App\Models\ItemType::whereRaw("id='".$request->item_type_id."'")->first();
	

		return $item_type;
	
	
	
	}

	public static function listExpired($range,$limit){

				if($range==""){

					$records=\App\Models\FoundRecord::orderBy('found_date','DESC');

					if($limit=="recent"){
						$records=$records->limit(20);
						
						$records=$records->get();
					}
					
					else {
						$records=$records->get();
						
					}

//					$records=\App\Models\FoundRecord::all();
					
//					$records = $records->sortByDesc('found_date');

					
				}
				else {
					

					$date=explode("to",$range);
					
					$start_date=date("Y-m-d",strtotime($date[0]));
					$end_date=date("Y-m-d",strtotime($date[1]));


					
//					$records=\App\Models\FoundRecord::whereRaw("found_date between '".$start_date." 00:00:00' and '".$end_date." 23:59:59'")->orderBy('found_date','DESC')->get();
					$records=\App\Models\FoundRecord::whereRaw("found_date between '".$start_date." 00:00:00' and '".$end_date." 23:59:59'");

					if($limit=="recent"){
						$records->limit(20);
						
						$records->get();
					}
					
					else {
						$records->get();
						
					}
					$records = $records->sortByDesc('found_date');

					
				}		



			if($records){	
				$i=0;
				foreach($records as $record){

					$items=\App\Models\FoundRecord::find($record->id)->items()->get();
					
					if($items){
							$k=0;
										
					//		$items=$records[$i]->items;	
										
							$m=0;					
							foreach($items as $item){
								$items[$k]->user=\App\Models\User::whereRaw("id=".$record->user_id)->get()->toArray();

								$items[$k]->details=\App\Models\ItemDetail::whereRaw("item_id=".$item->id)->get()->toArray();
								$items[$k]->category=\App\Models\Category::whereRaw("id=".$item->category_id)->first()->toArray();
										
								$itemType=\App\Models\ItemType::whereRaw("id=".$item->item_type_id)->first();
								
								$found=\App\Models\FoundRecord::whereRaw("id=".$item->found_record_id)->first()->toArray();							
									
								$items[$k]->found_date_label=date("F d, Y",strtotime($found['found_date']));
									
														
								
								$expired=\App\Services\ItemService::getLatestStatus($item->id);

								if($expired){
									$items[$k]->latest_status=$expired->toArray();
									
								}
								$items[$k]->latest_stat=$expired;
								
								
								if($itemType){
								$expirationlength=$itemType->duration." days";
								}
								
								$foundDate=$record->found_date;
								
								if($itemType){
								$duration=($itemType->duration)." days";
								$expiration_date=date("Y-m-d",strtotime($foundDate." +".$duration));		

								}
								
								

								
								if($itemType){
								$items[$k]->item_type=$itemType->toArray();
								}
								
								$recent_date=date("Y-m-d");
								
								if(strtotime($recent_date)>=strtotime($expiration_date)){
									
									if($itemType){
										$expired_items[$m]=$items[$k];
										$m++;
										$items[$k]->expired=true;
									}
									
								}
								else {
									if($expired){
										if($expired->status_type_id!=4){
											$items[$k]->expired=false;
										
										}
										else {
											$items[$k]->expired=true;
											$expired_items[$m]=$items[$k];
											$m++;										
										}
									}
									
								}
								
							
								

								$items[$k]->expiration=$expiration_date;

										
								$k++;
							}
							
						}				

					$expired_items = $items->filter(function($item)
						{
							if($item->expired==true)
							{
								
								$status=$item->latest_stat;
								
								if($status){
								
									if($status->status_type_id==4){
										return $item;

									}
									else if($status->status_type_id==5){
										
									}
									else {
										\App\Services\ItemService::markExpired($item);
										return $item;

									}
								}
								else {
										\App\Services\ItemService::markExpired($item);
										return $item;
									
								}
								
								
							}
					 });						
					$records[$i]->expired_items=$expired_items->toArray();
					$records[$i]->items=$records[$i]->expired_items;
					$i++;
				}
				
				$expired_records=$records->filter(function($record){
					if(count($record->expired_items)>0){
						return true;
					}
					
					
					
				});
				
				
			}
			return $expired_records;

	}
	
	public static function markExpired($item){
			$request=new \stdClass();

			
			$statuses=\App\Services\ItemService::getLatestStatus($item->id);
			
			if($statuses){
				
				$latest_stat=$item->latest_stat;
				
				
				if($latest_stat->status_type_id==4){
					$request->status_date=$item->expiration;
					$request->item_id=$item->id;
					$request->status_type_id=4;
					$request->status_details="Period of Storage Expired";
					$request->received_by="";					
					
				}
				else {

					$request->status_date=$item->expiration;
					$request->item_id=$item->id;
					$request->status_type_id=4;
					$request->status_details="Period of Storage Expired";
					$request->received_by="";
					\App\Services\AddItemStatusService::addItemStatus($request);

				}
							
			}
			else {
/*
				$request->status_date=$item->expiration;

				$request->item_id=$item->id;
				$request->status_type_id=4;
				$request->status_details="Period of Storage Expired";
				\App\Services\AddItemStatusService::addItemStatus($request);

*/
			}
	}
	
	
	public static function getItemStatus($request){
//		$items=\App\Models\Item::with("ItemStatus")->find($request)->itemStatus()->get();	

		
		$statuses=\App\Models\ItemStatus::whereRaw("item_id=$request order by status_date desc")->get();	

		
		
		$i=0;
		foreach($statuses as $status){
			if($i==0){  
				$statuses[$i]->latest=true;
			}
			
			else {
				$statuses[$i]->latest=false;
			}
			$statuses[$i]->status_type=\App\Models\ItemStatus::with("StatusType")->find($status->id)->statusType()->first()->toArray();


//			$items[$i]->type=\App\Models\ItemStatus::with("StatusType")->find($item->id)->statusType()->first()->toArray();
			$i++;

			
		}
		return $statuses;
		
	}
	public static function getReceiver($request){
		$id=$request->receiver_id;
		
		$receiver="";
		if($id==""){
		}
		else {
		$receiver=\App\Models\Receiver::whereRaw("id=$id")->first();
		
		}
//		$request->receiver()->first();
		return $receiver;
	}

	public static function getLocation($request){
		$id=$request->location_id;
		
		$location="";
		if($id==""){
		}
		else {
			
		$location=\App\Models\Location::whereRaw("id=$id")->first();
		
		}
//		$request->receiver()->first();
		return $location;
	}
	
	
	public static function getLatestStatus($request){
//		$items=\App\Models\Item::with("ItemStatus")->find($request)->itemStatus()->get();	

		
		$statuses=\App\Models\ItemStatus::whereRaw("item_id=$request order by status_date desc")->first();	

		if($statuses){
				
			
			$statuses->status_type=$statuses->statusType()->first()->toArray();
		}
		
			
		return $statuses;
	}
}

?>



