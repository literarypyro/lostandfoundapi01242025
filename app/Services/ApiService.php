<?php

namespace App\Services;

use App\Models;
use App\Services\UserService;
use App\Services\ItemRequestService;


class ApiService {
	
	public static function generateToken($request){
		
        $token = Str::random(60);

        $request->user()->forceFill([
            'api_token' => hash('sha256', $token),
		])->save();


		$data['token']=$token;

        return $data;
	}
	
}
?>



