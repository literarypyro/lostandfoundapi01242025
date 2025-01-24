var requestModule=angular.module('itemsApp',['datatables']);
requestModule.controller("itemsController",['$compile', '$scope','$http','$window','$filter', function searchController($compile, $scope,$http,$window,$filter){

	var host=$window.hostName;

	var request_id = window.location.search.split("date=")[1];	
	$scope.request_id=request_id;
	$scope.assetfolder=host+"assets/images/items/";	
	$scope.date=new Date();


	var dateSplit=request_id.split("to");

	var dateFrom=request_id.split("to")[0];
	var dateTo=request_id.split("to")[1].split("&")[0];

	$scope.prepared_by=request_id.split("&")[1].split("=")[1].replace("%20",' ');
	
	$scope.prepared_by=$scope.prepared_by.replace("%20",' ');
	$scope.prepared_position=request_id.split("&")[2].split("=")[1];


	$scope.prepared_position=$scope.prepared_position.replace("%20",' ');

	$scope.ref_no=request_id.split("&")[3].split("=")[1].replace("%20"," ");

	$scope.ref_no=$scope.ref_no.replace("%20",' ');


	
	$scope.period=new Date(dateFrom.replace("%20",""));
	$scope.period2=new Date(dateTo.replace("%20",""));

	
//	$scope.period=$filter('date')(dateFrom.replace("%20"," "), "MM/yyyy");
	
//	$scope.period2=$filter('date')(dateTo.replace("%20"," "), "MM/yyyy");




	if((dateFrom.replace("%20",""))==(dateTo.replace("%20",""))){
		$scope.period2="";
		
	}
	else {
		$scope.conjunct=" to ";
	}	


	var url=host+"daterangefound/daily/"+request_id.split("&")[0];
//		var request_id=id;
//		var token=$scope.token;
	
		$http.get(url).then(function(resp, status, headers, config) {
			var response=resp.data;

			$scope.items=response;	

			

		});		
		
}]);

