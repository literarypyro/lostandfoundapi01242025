<?php
namespace App\Models;
//use Illuminate\Auth\UserInterface;
//use Illuminate\Auth\Reminders\RemindableInterface;
use HasApiTokens, Notifiable;
use Eloquent;

class User extends Eloquent 
//  implements UserInterface
{

	protected $table="users";

	public function userProfile(){
//		return $this->hasMany("\App\Models\Items","log_id")->whereRaw("log_type in ('cash','shortage','deposit') and transaction_type not in ('catransfer')");
		return $this->hasOne("\App\Models\UserProfile","user_id");
	}
	
	public function itemRequests(){
//		return $this->hasMany("\App\Models\Items","log_id")->whereRaw("log_type in ('cash','shortage','deposit') and transaction_type not in ('catransfer')");
		return $this->hasMany("\App\Models\ItemRequest","user_id");
	}

	public function userContact(){
		return $this->userProfile()->contactNo();
	}	

	public function userAddress(){
		return $this->userProfile()->address();
	}	

//  public function getAuthIdentifier()
 // {
  //  return $this->getKey();
 // }
  
/*
  public function getAuthPassword()
  {
    return $this->password;
  } 
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
		return 'api_token';
	}
*/	
	
}
?>