<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Makes event date Carbon instance
     *
     * @var array
     */
    protected $dates = ['created_at', 'deleted_at'];

    /**
     * A partner has many admins
     * @return \Illuminiate\Database\Eloquent\Relations\hasMany
     */
    public function admins()
    {
        return $this->hasMany(\App\User::class, 'partner_user', 'partner_id', 'user_id');
    }

    /**
     * A partner has many questions
     * @return \Illuminiate\Database\Eloquent\Relations\hasMany
     */
    public function questions()
    {
        return $this->hasMany(\App\Question::class);
    }
}
