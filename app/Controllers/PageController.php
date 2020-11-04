<?php 
namespace App\Controllers;

use Psr\Http\Message\RequestInterface ;
use Psr\Http\Message\ResponseInterface;

use App\Models\User;
use App\Models\Module;
use App\Models\Note;

class PageController extends Controller{
 
////////////////////////////////////////:  Module /////////////////////////////////////////:

    public function affichermodules(RequestInterface $request,ResponseInterface $response){
          $modules= Module::All();
          // return $this-> redirect($response,'affichermodules',['modules' => $modules]);
          return $this->render($response,'pages/modules/affichermodules.php.twig',['modules' => $modules]);
    }


    public function ajoutermodulesget(RequestInterface $request,ResponseInterface $response){
       return $this->render($response,'pages/modules/ajoutermodules.php.twig');
    }




   public function ajoutermodulespost(RequestInterface $request,ResponseInterface $response){ 

         Module::create([ 
               'libele'=>$request->getParam('libele'),  
               'niveau'=>$request->getParam('niveau'),
               'semestre'=>$request->getParam('semestre'),
         ]);

         $module=Module::where('libele',$request->getParam('libele') )->where( 'niveau',$request->getParam('niveau'))->where('semestre',$request->getParam('semestre'))->first(); 
        $users=User::where('niveau',$request->getParam('niveau'))->where('role','stud')->get();

        foreach ($users as  $user) {
             Note::create([ 
               'student_id'=>$user->id,  
               'module_id'=>$module->id,
               'student_name'=>$user->name,
               'note1' => -1,
               'note2' => -1,
               'total' => -1,
         ]);
        }
        
            $this->flash('success','Le module est ajouté avec succes');
            return $this-> redirect($response,'affichermodules');
             // return $this-> redirect($response,'affichermodules',['modules' => $modules]);
             // return $this->render($response,'pages/modules/affichermodules.php.twig');
    }

   


    public function getmodules_classe(RequestInterface $request,ResponseInterface $response){
         //$classe=$request->getParam('classe') ;
        
       $modules=Module::where('niveau',$request->getParam('classe'))->get(); 
      return $this->render($response,'pages/modules/affichermodules.php.twig',['modules' => $modules]);
    }

 



     public function getmodules_students(RequestInterface $request,ResponseInterface $response){
       //$classe=$request->getParam('classe');
       $modules=Module::where('id',$request->getParam('module_id'))->first();
       $Notes=Note::where('module_id',$modules->id)->get();
       return $this->render($response,'pages/notes/student_file.php.twig',['Notes' => $Notes,'module'=>$modules->libele,'module_id'=>$modules->id]);
    }

       public function setstudent_notes(RequestInterface $request,ResponseInterface $response){  

       $notes=Note::where('id',$request->getParam('note_id'))->where('module_id',$request->getParam('module_id'))->first();
        
       $notes->update([
        'note1'=> $request->getParam('note1'),
        'note2'=> $request->getParam('note2') ,
       ]);

       if($notes->note1!=-1 and  $notes->note2!=-1)
        $notes->update([
         'total'=> ($notes->note1 + $notes->note2)/2,
       ]);

       $modules=Module::where('id',$request->getParam('module_id'))->first();
       $Notes=Note::where('module_id',$modules->id)->get();
       return $this->render($response,'pages/notes/student_file.php.twig',['Notes' => $Notes,'module'=>$modules->libele,'module_id'=>$modules->id]);
    }



 

      public function mesnotes(RequestInterface $request,ResponseInterface $response){
       $notes=Note::where('student_id',$request->getParam('student_id'))->get();  
       return $this->render($response,'pages/notes/mesnotes.php.twig',['notes' => $notes]);
    }




    public function demande(RequestInterface $request,ResponseInterface $response){
        if($request->isPost()){
         $notes=Note::where('student_id',$request->getParam('student_id'))->where('type',$request->getParam('demande'))->get(); 
 
        Note::create([ 
               'student_id'=>$request->getParam('student_id'),  
               'type'=>$request->getParam('demande'),
         ]); 

         $this->flash('success','La demande a été faite avec succes');
         return $this->render($response,'pages/demande/demande.php.twig' );
        }
        else  return $this->render($response,'pages/demande/demande.php.twig' );
     
    }













	public function home(RequestInterface $request,ResponseInterface $response){

          

        
        
         

         // return  $this->render($response,'home.twig');
    }


    public function addModule(RequestInterface $request,ResponseInterface $response){

         $users=User::where('niveau',$request->getParam('niveau'))->get();
           
         
          Module::create([ 
               'libele'=>$request->getParam('libele'),  
               'niveau'=>$request->getParam('niveau'),
         ]);

         

         $module=Module::where('niveau',$request->getParam('niveau'))->where('libele',$request->getParam('libele'))->first();
        foreach ($users as  $user) {
             echo "<h1>".$user->id."</h1>";
              Note::create([ 
               'id_student'=>$user->id,  
               'id_module'=>$module->id,
               'note1' => -1,
               'note2' => -1,
               'total' => -1,
         ]);

         }


        

         // $response->getBody()->write("hy every body");

         // return  $this->render($response,'home.twig');
    }













    public function getlogin(RequestInterface $request,ResponseInterface $response){
         return $this->render($response,'pages/login.html.twig');
    }

    
    public function postlogin(RequestInterface $request,ResponseInterface $response){
       
      
      if(1){ $this->flash('success','you logged in');
      }
      else  $this->flash('error','Error check your password or email');  
      
        //  var_dump("email ". $request->getParam('email')."pass ".$request->getParam('password'));
        return $this->redirect($response,'home');
     //return $this->render($response,'pages/login.html.twig',['email' => $email ,'password'=>$password]);
       
    }


    public function login(RequestInterface $request,ResponseInterface $response){
  //waliddddddd
       return $this->render($response,'login.twig');
    }


    public function user_interface(RequestInterface $request,ResponseInterface $response){
         return $this->render($response,'layout.twig');
    }

     public function allnews(RequestInterface $request,ResponseInterface $response){
         return $this->render($response,'pages/indexnews.php.twig');
    }

     public function post(RequestInterface $request,ResponseInterface $response){
         return $this->render($response,'pages/postnews.html.twig');
    }    

//888888888888888888888888888 walid
public function attempt($email,$password)
  {

     $user=User::where('email',$email)->first();

     if(!$user)
     {
      return false;
     }
     else 
     {
          if($user->password==$password)
          {
            $_SESSION['user']=$user->id;
             return true; 
           }else
           {
            return false; 
           }
      }
     
     
  }

    public function getSignIn($request,$response)
    {
        $auth=$this->attempt(
        $request->getParam('email'),
        $request->getParam('password')
        );
        if(!$auth)
        {
          return $response->withRedirect($this->render($response,'login.twig'));
        }
        else
        {
           return $response->withRedirect($this->render($response,'layout.twig'));
        }
        
    }

    public function check()
    {
             return isset($_SESSION['user']);

    }
    public function user()
    {
      return User::find($_SESSION['user']);
    }

}