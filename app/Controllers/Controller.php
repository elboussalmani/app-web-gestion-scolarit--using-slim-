<?php 
namespace App\Controllers;

use Psr\Http\Message\RequestInterface ;
use Psr\Http\Message\ResponseInterface;
 


class Controller{
	private $container;



	public function __construct($container){
    $this->container = $container;
  }

  


   public function render(ResponseInterface $response,$file,$params = []){
    $this->view->render($response,$file,$params);
   }

    public function redirect($response,$route){
    return $response->withStatus(302)->withHeader('location',$this->router->pathFor($route));
   }

  
   public function __get($property){
   	return $this->container->get($property);
   }


    public function flash($type ,$message){
      if(isset($_SESSION['flash'])){
        $_SESSION['flash']=[];
      }
     return $_SESSION['flash'][$type]=$message;
   }


}

