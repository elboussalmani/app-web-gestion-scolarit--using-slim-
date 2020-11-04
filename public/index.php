<?php
require '../vendor/autoload.php';
use App\Models\User;
session_start();

$app=new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true 
    ]
 ]);
 require ('../app/container.php'); 

$app->get('/hello',function(\Slim\Http\Request $request, \Slim\Http\Response $response ){
   
    $users=User::where('id',1)->first(); 
    // $users= $this->db->table('users')->where('id',1)->get();
    var_dump($users->name);
    die();
   //return $response->write('hello from route');
});



  $app->get('/',\App\Controllers\PageController::class .':login')->setName('login');
  //$app->get('/check',\App\Controllers\PageController::class .':check')->setName('check');
  $app->get('/user_interface',\App\Controllers\PageController::class .':user_interface')->setName('user_interface');
  /// walid
  $app->post('/getSignIn',\App\Controllers\PageController::class .':getSignIn')->setName('getSignIn');

$container=$app->getContainer();


$app->get('/post',\App\Controllers\PageController::class .':post')->setName('post');
$app->get('/allnews',\App\Controllers\PageController::class .':allnews')->setName('allnews');

$app->add(new \App\Middlewares\FlashMiddlewares($container->view->getEnvironment()));

 $app->get('/login',\App\Controllers\PageController::class .':getlogin')->setName('getlogin');
 $app->post('/login',\App\Controllers\PageController::class .':postlogin')->setName('postlogin');

 //$app->post('/loginn',\App\Controllers\PageController::class .':getSignIn')->setName('getSignIn');
 



//////////////////////////////////////    modules    //////////////////////////////////////////////:


$app->get('/affichermodules',\App\Controllers\PageController::class .':affichermodules')->setName('affichermodules'); 
$app->get('/ajoutermodulesget',\App\Controllers\PageController::class .':ajoutermodulesget')->setName('ajoutermodulesget');
$app->post('/ajoutermodulespost',\App\Controllers\PageController::class .':ajoutermodulespost')->setName('ajoutermodulespost');



$app->post('/getmodules_classe',\App\Controllers\PageController::class .':getmodules_classe')->setName('getmodules_classe');


$app->post('/getmodules_students',\App\Controllers\PageController::class .':getmodules_students')->setName('getmodules_students');

$app->post('/setstudent_notes',\App\Controllers\PageController::class .':setstudent_notes')->setName('setstudent_notes');


  $app->post('/mesnotes',\App\Controllers\PageController::class .':mesnotes')->setName('mesnotes');

 $app->get('/demande',\App\Controllers\PageController::class .':demande')->setName('demande');
 $app->post('/demande',\App\Controllers\PageController::class .':demande')->setName('demande');
 

 
$app->run();








