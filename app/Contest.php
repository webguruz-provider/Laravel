<?php

namespace App;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contest extends Model
{
    protected $table = 'contests';
    protected $fillable = ['partner_id', 'category_id', 'name','website_url','image_url','status','created_at', 'updated_at','publish_at','expire_at','description'];



    public function clicks(){
        return $this->hasMany(\App\ContestStats::class)->where('event_type', 'click');
    }

    public function impressions(){
        return $this->hasMany(\App\ContestStats::class)->where('event_type', 'impression');
    }

    public function scopePublished($query){
        return $query->where('publish_at', '<=', Carbon::now())->where([['expire_at', '>=', Carbon::now()], ['partner_id', '=', auth()->user()->id], ['status', '!=', 'draft'],])->where('status', '!=', 'deactive');
    }

    

    public function scopeScheduled($query)
    {
        return $query->where([['publish_at', '>', Carbon::now()], ['partner_id', '=', auth()->user()->id], ['status', '!=', 'draft'],])->where('status', '!=', 'deactive');
    }


    public function scopeExpired($query)
    {
        return $query->where([['expire_at', '<', Carbon::now()], ['partner_id', '=', auth()->user()->id], ['status', '!=', 'draft'],])->where('status', '!=', 'deactive');
    }

}

