<?php
require '../vendor/autoload.php';


class DemoMiddlewar{

       public function __invoke(\Slim\Http\Request $request,\Slim\Http\Response $response,$next){  
	     $response->write('<h1>hello</h1>');  
	      $next($request,$response);
	     $response->write('<h1>see you later</h1>');
	     return $response;	  
	     	  
       } 
}

 


   class Database {
     
     private  $pdo;
     public function __construct(PDO $pdo){
     	$this->pdo = $pdo;
     }

     public function query($sql){
       $req= $this->pdo->prepare($sql);
	   $req->execute();
	   return $req->fetchAll();
     }
   }

$app=new \Slim\App();
$app->add(new DemoMiddlewar());
$container = $app->getContainer();
$container['pdo'] = function(){ 
       $pdo=new PDO('mysql:dbname=slimproject;host=localhost','root','');
       $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
     return $pdo;
  };

$container['db']= function($container){
    return  new Database($container->pdo);
};

$app->get('/hello/{name}',function(\Slim\Http\Request $request, \Slim\Http\Response $response,$args){
	//var_dump($request->getParams()); 
     $posts= $this->db->query('SELECT * FROM users');
	 var_dump($posts);
   return $response->write(' hello ana jay ' . $args['name']);
});
 
$app->get('/hello',function(\Slim\Http\Request $request, \Slim\Http\Response $response ){
	//var_dump($request->getParams());
   return $response->write('hello from seconde route');
});




class MyController{

   private $container;
   public function __construct ($container){
    $this->container = $container;
   }

	public function test(\Slim\Http\Request $request, \Slim\Http\Response $response,$args){
	  $posts= $this->container->db->query('SELECT * FROM users');
	  // var_dump($posts);
	  echo"<table border='1'>";
	  echo"<tr><td>name</td><td>email</td><td>password</td><td>role</td></tr>";
	  foreach($posts as $post){
	    echo "<tr>";
	   	echo "<td>".$post['name']."</td>";
	   	echo "<td>".$post['email']."</td>";
	   	echo "<td>".$post['password']."</td>";
	   	echo "<td>".$post['role']."</td>";
	    echo "</tr>";
	  }
	  echo"</table>";
	   return $response->write('hello ana jay ' ); 
	}

}
 
 $app->get('/controll','MyController:test');

$app->run();