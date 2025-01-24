<?php

//namespace App;

use App\Services;
use App\Models;
//use \App\Controllers;

class ItemRequestController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id=null,$component=null)
	{
		if($component=="cash"){
			return $this->retrieveCashLogbook($id);		
		}
		else if($component=="ticket"){
			return $this->retrieveTicketLogbook($id);		
			
		}
		else if($component=="dsr"){
			return $this->retrieveDsrEntry($id);		
			
		}
		else if($component=="dsrsum"){
			return $this->retrieveDsrEntrySummary($id);		
			
		}
		else if($component=="dsroverall"){
			return $this->retrieveDsrOverall($id);		
			
		}


//		$request=\App\Models\Logbook::find($id)->first();
//		return \App\Services\LogbookService::sumRefund($request);





		
		//		return $this->retrieveDsrTest($id); 

//		return $this->retrieveCashLogbook('1263'); 
//		return $this->retrieveTicketLogbook('1263'); 
		//Response::json();
		
	}
	public function search($station,$date,$shift=null,$revenue=null)
	{
		$request=new stdClass();
		
		if($shift==null){
			$request->log_date=$date;
			$request->station=$station;

			return \App\Services\LogbookService::listLogbooks($request);
		}
		else {
			if($shift=="ext"){
				$request->log_date=$date;
				$request->station=$station;

				return \App\Services\LogbookService::extendLogbooks($request);
				
				
			}
			else {
				$request->log_date=$date;
				$request->station=$station;
				$request->shift=$shift;
				$request->revenue=$revenue;

				return \App\Services\LogbookService::queryLogbook($request);
			}	
		}
		
	}
	
	public function retrieveLogbookHeader($logbook){
		$log_id=$logbook->id;

		$logbook->cashAssistant=\App\Services\UserService::retrieveCashAssistant($logbook->cash_assistant)->toArray();	
		$logbook->log_shift=\App\Services\ShiftService::retrieveShift($logbook->shift)->toArray();	


		
		return $logbook;
		
		
		
	}
	
	public function retrieveCashLogbook($id){
		$logbook=\App\Models\Logbook::find($id);
		
		$logbook=$this->retrieveLogbookHeader($logbook);	
		
		$logbook->type="cash";
		
		$logbook->cashBeginningBalance=\App\Services\LogbookService::retrieveCashBeginningBalance($logbook);	

		
		$logbook->cashTransactions=\App\Services\TransactionService::detailedTransactions($logbook)->toArray();
		$logbook->cashTransfer=\App\Services\TransactionService::endingTransfer($logbook)->toArray();
		
		
		$logbook->openControlSlips=\App\Services\ControlSlipService::openControlSlips($logbook)->toArray();



		return Response::json($logbook);
		
		
	}

	public function retrieveTicketLogbook($log){
		$logbook=\App\Models\Logbook::find($log);
		
		$logbook=$this->retrieveLogbookHeader($logbook);	
		
		$logbook->type="ticket";

		$logbook->ticketBeginningBalance=\App\Services\LogbookService::retrieveTicketBeginningBalance($logbook);	

		$logbook->ticketTransactions=\App\Services\TransactionService::detailedTransactions($logbook)->toArray();
		
		

		
		$logbook->ticketTransfer=\App\Services\TransactionService::endingTransfer($logbook)->toArray();
		

		$logbook->physicallyDefective=\App\Services\TransactionService::physicallyDefective($logbook)->toArray();
		
		$logbook->openControlSlips=\App\Services\ControlSlipService::openControlSlips($logbook)->toArray();

		
		return Response::json($logbook);
		
		
	}
	
	public function retrieveDsrEntry($log){
		$logbook=\App\Models\Logbook::find($log);
		
		$logbook=$this->retrieveLogbookHeader($logbook);	
		
		$logbook->remittances=\App\Services\ControlRemittanceService::getDetailedControlRemittances($logbook->id)->toArray();
		
		
		return Response::json($logbook);
		
		
	}


	public function retrieveDsrEntrySummary($log){
		$logbook=\App\Models\Logbook::find($log);
		
//		$logbook=$this->retrieveLogbookHeader($logbook);	
		
//		$logbook->remittances=\App\Services\ControlRemittanceService::getDetailedControlRemittances($logbook->id)->toArray();
//		$logbook->salesAmount=\App\Services\LogbookService::ticketSalesAmount($logbook)->toArray();	
		$logbook->ticketSales=\App\Services\LogbookService::ticketSales($logbook);	
		$logbook->salesAmount=\App\Services\LogbookService::ticketSalesAmount($logbook);	
		$logbook->fareAdjustment=\App\Services\LogbookService::sumFareAdjustment($logbook);	
		$logbook->unregSale=\App\Services\LogbookService::sumUnregSale($logbook);	
		$logbook->refund=\App\Services\LogbookService::sumRefund($logbook);	
		$logbook->discrepancy=\App\Services\LogbookService::getCashDiscrepancy($logbook);	
		$logbook->ticketDiscrepancies=\App\Services\LogbookService::getTicketDiscrepancy($logbook);	

		$logbook->defectiveTickets=\App\Services\LogbookService::getDefectiveTickets($logbook);	
		
		return Response::json($logbook);
		
		
	}

	public function retrieveDsrOverall($log){
		$logbook=\App\Models\Logbook::find($log);
		
		
		$logbook->stn=\App\Models\Station::find($logbook->station)->first()->toArray();
		
		//Gross Sales, Part 1
		$logbook->grossSales=\App\Services\CalculationService::calculateGrossSales($logbook);	

		//Ticket Summary, Part 2
		$logbook->ticketBeginningBalance=\App\Services\LogbookService::retrieveTicketBeginningBalance($logbook);	

		
		$logbook->ticketSummary=\App\Services\CalculationService::calculateSummaryTickets($logbook);	

		$logbook->ticketDeductions=\App\Services\CalculationService::calculateTicketDeductions($logbook);	
		
		
		//Overall Summary, Part 3
		$logbook->cashBeginningBalance=\App\Services\LogbookService::retrieveCashBeginningBalance($logbook);	
		$logbook->fixedFund=\App\Services\LogbookService::getFixedFund($logbook);	
		
		$logbook->salesAmount=\App\Services\LogbookService::ticketSalesAmount($logbook);	
		
		
		$logbook->bankDeposit=\App\Services\LogbookService::retrieveBankDeposits($logbook);	
		
		$logbook->overages=\App\Services\CalculationService::calculateOverages($logbook);	
		$logbook->tvmRefund=\App\Services\CalculationService::calculateTvmRefund($logbook);	
	
		
	
		return Response::json($logbook);
		
		
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
