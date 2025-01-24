<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*

Route::get('/', function () {
    return view('welcome');
});
*/
	Route::get('/countries', ['as' => 'request', 'uses' => 'ApiController@listCountry']);
	Route::get('/location', ['as' => 'post', 'uses' => 'FoundItemController@listLocations']);
	Route::get('/itemType/list', ['as' => 'request', 'uses' => 'ApiController@listItemType']);
	Route::get('/category', ['as' => 'request', 'uses' => 'ApiController@listCategory']);
	Route::post('/register',['as'=>'post', 'uses'=>'AuthController@registerUser']);


	Route::post('/registerProfile/{id}',['as'=>'post', 'uses'=>'AuthController@addUserProfile']);
	Route::post('/registerAddress/{id}',['as'=>'post', 'uses'=>'AuthController@addUserAddress']);
	Route::post('/registerContact/{id}',['as'=>'post', 'uses'=>'AuthController@addUserContact']);



/*
	Route::get('/items/{search_type}/{search_term}/list', ['as' => 'request', 'uses' => 'FoundItemController@search']);
	Route::get('/items/{search_type}', ['as' => 'request', 'uses' => 'FoundItemController@search']);
	Route::get('/item/{id}/status', ['as' => 'request', 'uses' => 'FoundItemController@status']);
	Route::get('/item/{id}/status/{latest}', ['as' => 'request', 'uses' => 'FoundItemController@status']);

*/
	Route::get('/item/{id}', ['as' => 'request', 'uses' => 'FoundItemController@retrieveItem']);

	Route::get('/recentlist', ['as' => 'request', 'uses' => 'FoundItemController@recentList']);
	Route::get('/all', ['as' => 'request', 'uses' => 'FoundItemController@allList']);

	Route::post('/filter', ['as' => 'request', 'uses' => 'FoundItemController@filterSearch']);




	Route::get('/daterangesearch/{search_type}/{search_term}/range/{daterange}', ['as' => 'request', 'uses' => 'FoundItemController@dateRangeSearch']);


	Route::get('/daterangefound/{search_type}/{daterange}', ['as' => 'request', 'uses' => 'FoundItemController@dateRangeFound']);

	Route::get('/itemtypesearch/{search_type}/{search_term}/range/{daterange}', ['as' => 'request', 'uses' => 'FoundItemController@itemTypeSearch']);
	Route::get('/categorysearch/{search_type}/{search_term}/range/{daterange}', ['as' => 'request', 'uses' => 'FoundItemController@categorySearch']);


	Route::get('/recent', ['as' => 'request', 'uses' => 'FoundItemController@listRecent']);
	Route::get('/allfound', ['as' => 'request', 'uses' => 'FoundItemController@listFound']);


	Route::get('/expired', ['as' => 'request', 'uses' => 'FoundItemController@markExpired']);
	Route::get('/allexpired', ['as' => 'request', 'uses' => 'FoundItemController@markAllExpired']);

	Route::post('/edititem/{id}/{type}', ['as' => 'request', 'uses' => 'FoundItemController@modifyItem']);


	Route::get('/disposed', ['as' => 'request', 'uses' => 'FoundItemController@listDisposed']);
	Route::get('/alldisposed', ['as' => 'request', 'uses' => 'FoundItemController@listAllDisposed']);

	Route::post('/editstatus', ['as' => 'request', 'uses' => 'FoundItemController@modifyItemStatus']);


	Route::post('/item/{id}/status', ['as' => 'request', 'uses' => 'FoundItemController@modifyItemStatus']);

	Route::post('/newitem', ['as' => 'post', 'uses' => 'FoundItemController@addItem']);
	


	Route::post('/particular/{found_record_id}', ['as' => 'post', 'uses' => 'FoundItemController@addParticular']);
	
		Route::post('/login',['as'=>'post', 'uses'=>'AuthController@loginUser']);
	
	
	Route::get('/requests/{search_type}/{search_term}', ['as' => 'request', 'uses' => 'RequestController@search']);
//	Route::get('/requests/{search_type}', ['as' => 'request', 'uses' => 'RequestController@search']);

	Route::post('/request/{id}/status', ['as' => 'request', 'uses' => 'RequestController@modifyRequestStatus']);

//	Route::post('/request/{id}/edit/{type}', ['as' => 'request', 'uses' => 'RequestController@modifyRequest']);

	
	Route::get('/request/{id}', ['as' => 'request', 'uses' => 'RequestController@index']);
	Route::get('/request/{id}/status', ['as' => 'request', 'uses' => 'RequestController@status']);

	Route::get('/user/{id}', ['as' => 'request', 'uses' => 'AuthController@retrieveUser']);


	Route::get('/request/{id}/messages/list', ['as' => 'request', 'uses' => 'RequestController@listMessages']);
	Route::post('/request/{id}/messages', ['as' => 'request', 'uses' => 'RequestController@addMessage']);

	


	Route::post('/auth', ['as' => 'post', 'uses' => 'AuthController@changePassword']);

	

	Route::get('/foundations', ['as' => 'request', 'uses' => 'ApiController@listFoundations']);
	
	Route::post('/found/new', ['as' => 'request', 'uses' => 'ApiController@addFoundation']);

	Route::post('/category', ['as' => 'request', 'uses' => 'ApiController@addCategory']);

	Route::post('/addclaim', ['as' => 'request', 'uses' => 'RequestController@addClaim']);



	Route::get('/receivers', ['as' => 'request', 'uses' => 'ApiController@listReceivers']);
	
	Route::post('/receivers', ['as' => 'request', 'uses' => 'ApiController@addReceiver']);
	
	
	



	
	Route::post('/itemType', ['as' => 'request', 'uses' => 'ApiController@addItemType']);

	
	Route::get('/request/{id}/status/{latest}', ['as' => 'request', 'uses' => 'RequestController@status']);

	
	Route::post('/request/{id}', ['as' => 'post', 'uses' => 'RequestController@addRequest']);
	
//});
    
	
//});	
/*
    Event::listen('illuminate.query', function($query, $bindings, $time, $name)
    {
        $data = compact('bindings', 'time', 'name');

        // Format binding data for sql insertion
        foreach ($bindings as $i => $binding)
        {   
            if ($binding instanceof \DateTime)
            {   
                $bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
            }
            else if (is_string($binding))
            {   
                $bindings[$i] = "'$binding'";
            }   
        }       

        // Insert bindings into query
        $query = str_replace(array('%', '?'), array('%%', '%s'), $query);
        $query = vsprintf($query, $bindings); 

        Log::info($query, $data);
    });

*/
/*
if (Config::get('database.log', false))
{           
    Event::listen('illuminate.query', function($query, $bindings, $time, $name)
    {
        $data = compact('bindings', 'time', 'name');

        // Format binding data for sql insertion
        foreach ($bindings as $i => $binding)
        {   
            if ($binding instanceof \DateTime)
            {   
                $bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
            }
            else if (is_string($binding))
            {   
                $bindings[$i] = "'$binding'";
            }   
        }       

        // Insert bindings into query
        $query = str_replace(array('%', '?'), array('%%', '%s'), $query);
        $query = vsprintf($query, $bindings); 

        Log::info($query, $data);
    });
}
*/

//});
/*
Route::get('/logout', function()
{
    Auth::logout();
	$auth["message"]="Authentication failed";
	return Response::json($auth);
});
*/







//	Route::any('{all}', 'LogbookController@index')->where('all', '^(?!api).*$');
	Route::any('{all}', 'ApiController@index')->where('all', '^(?!api).*$');

