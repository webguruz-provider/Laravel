<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialAccount extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_social_accounts';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'provider',
        'provider_id',
        'provider_url'
    ];

    /**
     * Makes event date Carbon instance
     *
     * @var array
     */
    protected $dates = ['created_at', 'deleted_at'];

    /**
     * A social account belongs to a user
     * @return \Illuminiate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
