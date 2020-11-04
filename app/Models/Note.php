<?php

namespace  App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model {
	protected $table= 'notes' ;

	protected $fillable =['id','student_id','module_id','note1','note2','total','student_name','module_libele'];
	public $timestamps = false;
}

