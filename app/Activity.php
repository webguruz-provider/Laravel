<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'subject_id',
        'subject_type',
        'subject_verb',
        'name',
        'user_id',
        'provider_id'
    ];

    /**
     * An activity is performed by a user
     * @return [type] [description]
     */
    public function user()
    {
        return $this->belongsto(\App\User::class);
    }


    /**
     * An activity is performed by a user
     * @return [type] [description]
     */
    public function subject()
    {
        return $this->morphTo();
    }
}