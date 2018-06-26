<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPoint extends Model
{
    //
    protected $dates = ['created_at', 'deleted_at'];
    //public $timestamps = true;



    public function fingerprint(){
    	return $this->belongstoMany(\App\Fingerprint::class,  'fingerprint_id');
    } 

}
