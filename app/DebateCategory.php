<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DebateCategory extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'debate_category';

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
        'partner_id',
        'name',
        'image_url',
        'icon_url',
        'sort',
        'ads_id',
        'status'
    ];

    /**
     * Makes event date Carbon instance
     *
     * @var array
     */
    protected $dates = ['created_at', 'deleted_at'];


    /**
     * A user has many category preferences
     * @return \Illuminiate\Database\Eloquent\Relations\hasMany
     */
    public function users()
    {
        return $this->belongsToMany(\App\User::class, 'debate_category_user', 'category_id', 'user_id');
    }

    /**
     * A debate has many users
     * @return \Illuminiate\Database\Eloquent\Relations\belongsTo
     */
    public function partner()
    {
        return $this->belongsToMany(\App\User::class, 'debate_user', 'debate_id', 'user_id');
    }

    /**
     * A question belongs to a category
     * @return \Illuminiate\Database\Eloquent\Relations\belongsTo
     */
    public function questions()
    {
        return $this->hasMany(\App\Question::class, 'category_id');
    }
    public function ads(){
        return $this->belongsTo(\App\Ad::class, 'ads_id')->where('publish_at', '<=', Carbon::now())->where([['expire_at', '>=', Carbon::now()], ['status', '!=', 'draft'],])->where('status', '!=', 'deactive');
    }
    public function pro_ads(){
        return $this->belongsTo(\App\Ad::class, 'ads_id');
    }
}
