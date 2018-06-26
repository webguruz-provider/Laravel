<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Follower;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'handle',
        'bio',
        'avatar_url',
        'background_img',
        'go_online',
        'notification_settings',
        'total_points',
        'last_activity',
        'is_admin',
        'gender',
        'ads_id',
        'timezone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
    public function categories()
    {
        //return $this->belongsToMany(\App\DebateCategory::class, 'debate_category_user', 'user_id', 'category_id');
        return $this->belongsToMany(\App\DebateCategory::class, 'debate_category_user', 'user_id', 'category_id')->where('status', 'live');
    }


    /**
     * A user has many category preferences
     * @return \Illuminiate\Database\Eloquent\Relations\hasMany
     */
    public function fingerprints()
    {
        return $this->hasMany(\App\Fingerprint::class, 'user_id');
    }

    /**
     * A user has many debates
     * @return \Illuminiate\Database\Eloquent\Relations\belongsTo
     */
    public function debates()
    {
        return $this->belongsToMany(\App\Debate::class, 'user_id', 'debate_id');
        
    }


    /**
     * A user has one debate_user entry based on user_id and debate_id
     * @return \Illuminiate\Database\Eloquent\Relations\belongsTo
     */
    
    public function debate_users()
    {
        return $this->hasOne(\App\DebateUser::class, 'user_id');
    }




    /**
     * A debate has many users
     * @return \Illuminiate\Database\Eloquent\Relations\hasMany
     */
    public function arguments()
    {
        return $this->hasMany(\App\DebateArgument::class);
    }

    /**
     * A user has many comments
     * @return \Illuminiate\Database\Eloquent\Relations\hasMany
     */
    public function comments()
    {
        return $this->hasMany(\App\DebateComment::class);
    }

    /**
     * A user has many comments
     * @return \Illuminiate\Database\Eloquent\Relations\hasMany
     */
    public function partners()
    {
        return $this->belongstoMany(\App\Partners::class, 'partner_user', 'user_id', 'partner_id');
    }

    /**
     * A user has many comments
     * @return \Illuminiate\Database\Eloquent\Relations\hasMany
     */
    public function isOnboarded()
    {
        if ($this->handle && $this->email) {
            return true;
        }
        return false;
    }

    /**
     * A user has many comments
     * @return \Illuminiate\Database\Eloquent\Relations\hasMany
     */
    public function hasHandle()
    {
        return (!is_null($this->handle) ? true : false);
    }



    

    // i am not following these users but they following me 
    public function follow_suggestion($user_id){


        // case 1 
            // when someone follow you but you not following 

        // case 2
            // when no one follow you 
            // then take random 3 user

        //return DB::select( DB::raw("select id, name, handle, avatar_url, is_admin from users u1 where u1.id!=$user_id AND u1.handle!='' AND not exists (select 1 from followers a where a.followerid=$user_id and a.user_id=u1.id and a.status='follow') order by rand() Limit 3"));

        return DB::select( DB::raw("select id, name, handle, avatar_url, is_admin from users u1 where u1.id!=$user_id AND u1.is_admin!=1 AND u1.handle!='' AND not exists (select 1 from followers a where a.followerid=$user_id and a.user_id=u1.id and a.status='follow') order by rand() Limit 3"));
        
    }

    /*
    public function followers(){
        return $this->hasMany(\App\Follower::class,'user_id');
    }
    */
    

    public function followings(){
        return $this->hasMany(\App\Follower::class, 'followerid');
    }

    public function ads(){
        return $this->belongsTo(\App\Ad::class, 'ads_id')->where('publish_at', '<=', Carbon::now())->where([['expire_at', '>=', Carbon::now()], ['status', '!=', 'draft'],])->where('status', '!=', 'deactive');
    }
    public function pro_ads(){
        return $this->belongsTo(\App\Ad::class, 'ads_id');
    }
}
