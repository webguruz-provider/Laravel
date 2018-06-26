<?php

namespace App;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ad extends Model
{
    protected $table = 'ads';
    protected $fillable = ['partner_id', 'category_id', 'name','website_url','image_url', 'advertisement_type', 'cpm', 'status','created_at', 'updated_at','publish_at','expire_at'];


    public function scopePublished($query)
    {
        return $query->where('publish_at', '<=', Carbon::now())->where([['expire_at', '>=', Carbon::now()], ['status', '!=', 'draft']]);
    }

    // expired ads 
    public function scopeExpired($query)
    {
        return $query->where([['expire_at', '<', Carbon::now()], ['status', '!=', 'draft'],['status', '!=', 'deactive'] ]);
    }





    // my live ads 
    public function scopeliveAds($query){
    	return $query->where('publish_at', '<=', Carbon::now())->where([['expire_at', '>=', Carbon::now()],['partner_id', '=', auth()->user()->id], ['status', '!=', 'draft'],['status', '!=', 'deactive']]);
    }


    
    public function scopeDashboardAds($query){
        return $query->select('ads.*')->leftJoin('questions', 'ads.id', '=', 'questions.ads_id')
                    ->where('questions.ads_id', NULL)
                    ->leftJoin('users', 'ads.id', '=', 'users.ads_id')
                    ->where('users.ads_id', NULL)
                    ->leftJoin('debate_category', 'ads.id', '=', 'debate_category.ads_id')
                    ->where('debate_category.ads_id', NULL)
                    ->where('ads.publish_at', '<=', Carbon::now())->where([['ads.expire_at', '>=', Carbon::now()], ['ads.status', '!=', 'draft'],]);
    }
    



    // ads click count / entry
    public function clicks(){
        return $this->hasMany(\App\AdStats::class)->where('event_type', 'click');
    }

    // impressions click and count entry
    public function impressions(){
        return $this->hasMany(\App\AdStats::class)->where('event_type', 'impression');
    }



}
