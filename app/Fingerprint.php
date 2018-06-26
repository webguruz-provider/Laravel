<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fingerprint extends Model
{


	public function user_points()
    {
        //return $this->hasMany(\App\UserPoint::class, 'id');
        return $this->hasMany(\App\UserPoint::class, 'fingerprint_id');
    }
    

    


}
