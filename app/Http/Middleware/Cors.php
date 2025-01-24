<?php

namespace App\Http\Middleware;
 
use Closure;
 
public class Cors
{
	public function handle($request, Closure $next)
	{
		return $next($request)
			->header('Access-Control-Allow-Origin', '*')
			->header('Access-Control-Allow-Methods', '*')
			->header('Access-Control-Allow-Credentials', true)
//			->header('Access-Control-Allow-Headers', 'X-Requested-With,Content-Type,X-Token-Auth,Authorization')
			->header('Access-Control-Allow-Headers', '*')
			->header('Accept', 'application/json');
	}
}
?>