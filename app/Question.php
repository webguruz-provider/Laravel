<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
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
		'user_id',
        'category_id',
        'name',
        'text',
        'medium',
        'source',
        'source_url',
        'publish_at',
        'expire_at',
        'created_at',
        'updated_at',
        'deleted_at',
		'status',
        'ads_id',
        'question_type',
        'answer_type',
        'allowed_other_answer',
        'instant_result',
        'has_multiple_ans',
    ];

    /**
     * A question belongs to a category
     * @return \Illuminiate\Database\Eloquent\Relations\belongsTo
     */
    public function debates()
    {
        return $this->hasMany(\App\Debate::class, 'question_id');
    }



    public function active_debates()
    {
        return $this->hasMany(\App\Debate::class, 'question_id')->where('status','=', 'active');
    }

    public function needs_opponent_debates()
    {
        return $this->hasMany(\App\Debate::class, 'question_id')->where('status','=', 'needs_opponent');
    }


    

    /**
     * Get all of the posts for the country.
     */
    public function users()
    {
        return $this->hasManyThrough('App\Debate', 'App\User');
    }


    /**
     * A question belongs to a category
     * @return \Illuminiate\Database\Eloquent\Relations\belongsTo
     */
    public function category()
    {
        return $this->belongsTo(\App\DebateCategory::class, 'category_id');
    }




    /**
     * A question belongs to a partner
     * @return \Illuminiate\Database\Eloquent\Relations\belongsTo
     */
    public function partner()
    {
        return $this->belongsTo(\App\Partner::class, 'partner_id');
    }

    /**
     * A debate has many users
     * @return \Illuminiate\Database\Eloquent\Relations\belongsToMany
     */
    public function author()
    {

        return $this->belongsTo(\App\User::class, 'user_id');
    }

    /**
     * Scope a query to only include published questions.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    // for login user
    public function scopePublished($query)
    {
        return $query->where('publish_at', '<=', Carbon::now())->where([['expire_at', '>=', Carbon::now()], ['user_id', '=', auth()->user()->id], ['status', '!=', 'draft'],])->where('status', '!=', 'deactive');
    }

    /**
     * Scope a query to only include draft questions.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDraft($query)
    {
        return $query->where('user_id', '=', auth()->user()->id)->where('status', '=', 'draft');
    }

    /**
     * Scope a query to only include deactivated questions.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDeactivated($query)
    {
        return $query->where('user_id', '=', auth()->user()->id)->where('status', '=', 'deactive');
    }

    /**
     * Scope a query to only include published questions.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeScheduled($query)
    {
        return $query->where([['publish_at', '>', Carbon::now()], ['user_id', '=', auth()->user()->id], ['status', '!=', 'draft'],])->where('status', '!=', 'deactive');
    }

    /**
     * Scope a query to only include expired questions.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExpired($query)
    {
        return $query->where([['expire_at', '<', Carbon::now()], ['user_id', '=', auth()->user()->id], ['status', '!=', 'draft'],])->where('status', '!=', 'deactive');
    }


    // for front end user
    public function scopePublicLive($query){
        return $query->where('publish_at', '<=', Carbon::now())->where([['expire_at', '>=', Carbon::now()], ['status', '!=', 'draft'],])->where('status', '!=', 'deactive');
    }


    /*impressions */
    public function impressions()
    {
        return $this->hasMany(\App\Impression::class, 'question_id');
    }


    public function ads(){
        return $this->belongsTo(\App\Ad::class, 'ads_id')->where('publish_at', '<=', Carbon::now())->where([['expire_at', '>=', Carbon::now()], ['status', '!=', 'draft'],])->where('status', '!=', 'deactive');
    }

    public function allAds(){
        return $this->belongsTo(\App\Ad::class, 'ads_id');
    }

    public function clicks(){
        return $this->hasMany(\App\QuestionStats::class)->where('event_type', 'click');
    }


    // for get clicks on ads that attached to Questions 
    public function AdClicks(){
        return $this->hasMany(\App\AdStats::class, 'attached_question_id')->where('event_type', 'click');
    }

    


    public function QuesImpressions(){
        return $this->hasMany(\App\QuestionStats::class)->where('event_type', 'impression');
    }

    public function getquestionAuther()
    {

        return $this->belongsTo(\App\User::class, 'user_id');
    }
    public function answer()
    {

        return $this->hasMany(\App\Answer::class, 'question_id', 'id');
    }
    public function userAnswer()
    {

        return $this->hasMany(\App\UserAnswer::class, 'question_ID', 'id');
    }

}
