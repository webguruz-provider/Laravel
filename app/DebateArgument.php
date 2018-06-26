<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DebateArgument extends Model
{
/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'debate_argument';

    /**
     * Allows soft deletion of events
     * @var string
     */
    protected $softDelete = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'debate_id',
        'user_id',
        'argument',
        'status',
        'created_at'
    ];

    /**
     * Makes event date Carbon instance
     *
     * @var array
     */
    protected $dates = ['created_at', 'deleted_at'];

    /**
     * An argument belongs to a debate
     * @return \Illuminiate\Database\Eloquent\Relations\belongsTo
     */
    public function debate()
    {
        return $this->belongsTo(\App\Debate::class, 'debate_id');
    }


    /**
     * An argument belongs to user
     * @return \Illuminiate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
       /* return $this->belongsToMany(\App\User::class, 'debate_user', 'debate_id', 'user_id')
        ->withPivot(['side','votes']);*/
    }
    


    /**
     * An argument belongs to user
     * @return \Illuminiate\Database\Eloquent\Relations\belongsTo
     */
    public function authorIsFirst()
    {
        if ($this->user->id == $this->debate->users()->first()->id) {
            return true;
        }
        return false;
    }
}
