<?php
namespace App\
class Auth
{


	public function attempt($email,$password)
	{

     $user=User::where('email',$email)->first();

     if(!$user)
     {
     	return false;
     }

     if($user->password==$password)
     {
     	$_SESSION['user']=$user->id;
     	return true;
     }
      return false;
	}
}