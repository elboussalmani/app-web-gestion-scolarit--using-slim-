<?php
namespace App\Controlles\Auth
use  App\Molels\User
class AuthContoller extends Controller
{


	public function getSignIn($request,$response)
	{
      
      $auth=$this->auth->attempt(
    $request->getParam('email'),
    $request->getParam('password')
      );
			if(!$auth)
			{
				return $response->withRedirect($this->render($response,'pages/login.html.twig'))
			}
			
	}
}
