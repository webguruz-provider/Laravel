<?php

namespace App\Http\Controllers\Game\Ads;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Ad;
use App\AdStats;
use File;
use Carbon;
use Exception;

use Illuminate\Support\Facades\Auth;

class AdsController extends Controller
{
    //




  	// increment contest clicks 
    // only unique user 
    // one user / one click / one contest / one event type
    public function AdsClick($adID){
        $ads_detail = Ad::findOrFail($adID);
        if($ads_detail){
            $adStats = AdStats::where('ad_id', '=', $adID)
                                    ->where('visitor_id','=',Auth::user()->id)
                                    ->where('event_type','=','click')
                                    ->orderBy('created_at', 'desc')
                                    ->first();

            if($adStats){
                $to = \Carbon\Carbon::now();
                $from = $adStats->created_at;
                $diff_in_minutes = $to->diffInMinutes($from);

                if($diff_in_minutes > 5){
                    // insert new click entry 
                    AdStats::insert(array('visitor_id' => Auth::user()->id,
                        'ad_id'=> $adID,
                        'event_type' => 'click',
                        'created_at' => Carbon\Carbon::now()
                    ));
                }

            }else{
                // insert new click entry 
                AdStats::insert(array('visitor_id' => Auth::user()->id,
                    'ad_id'=> $adID,
                    'event_type' => 'click',
                    'created_at' => Carbon\Carbon::now()
                ));
            }

            return redirect()->away($ads_detail->website_url);
            
        }
    }

    // increment contest clicks 
    // only unique user 
    // one user / one click / one contest / one event type
    public function QuesAdsClick($adID, $quesID){
        $ads_detail = Ad::findOrFail($adID);
        if($ads_detail){

            if (Auth::check()) {
                $adStats = AdStats::where('ad_id', '=', $adID)
                                        ->where('attached_question_id', $quesID)
                                        ->where('visitor_id','=',Auth::user()->id)
                                        ->where('event_type','=','click')
                                        ->orderBy('created_at', 'desc')
                                        ->first();

                if($adStats){
                    $to = \Carbon\Carbon::now();
                    $from = $adStats->created_at;
                    $diff_in_minutes = $to->diffInMinutes($from);

                    if($diff_in_minutes > 5){
                        // insert new click entry 
                        AdStats::insert(array(
                            'attached_question_id'=>$quesID,
                            'visitor_id' => Auth::user()->id,
                            'ad_id'=> $adID,
                            'event_type' => 'click',
                            'created_at' => Carbon\Carbon::now()
                        ));
                    }

                }else{
                    // insert new click entry 
                    AdStats::insert(array(
                        'attached_question_id'=>$quesID,
                        'visitor_id' => Auth::user()->id,
                        'ad_id'=> $adID,
                        'event_type' => 'click',
                        'created_at' => Carbon\Carbon::now()
                    ));
                }
            }

            return redirect()->away($ads_detail->website_url);
            
        }
    }



    // ads impression save
    public function QuesAdsImpression($adID, $quesID, $fID=null){

        try{

            $ads_detail = Ad::findOrFail($adID);
            if($ads_detail){
                if($fID){
                    
                    $adStats = AdStats::where('ad_id', '=', $adID)
                                        ->where('attached_question_id','=',$quesID)
                                        ->where('visitor_id','=', NULL)
                                        ->where('fingerprint_string', '=', $fID)
                                        ->where('event_type','=','impression')
                                        ->first();
                    if(!$adStats){
                        // insert new click entry 
                        AdStats::insert(array('fingerprint_string' => $fID,
                            'ad_id'=> $adID,
                            'attached_question_id' => $quesID,
                            'event_type' => 'impression',
                            'created_at' => Carbon\Carbon::now()
                        ));
                    }

                }else{
                    $adStats = AdStats::where('ad_id', '=', $adID)
                                        ->where('attached_question_id','=',$quesID)
                                        ->where('visitor_id','=',Auth::user()->id)
                                        ->where('event_type','=','impression')
                                        ->first();
                    if(!$adStats){
                        // insert new click entry 
                        AdStats::insert(array('visitor_id' => Auth::user()->id,
                            'ad_id'=> $adID,
                            'attached_question_id' => $quesID,
                            'event_type' => 'impression',
                            'created_at' => Carbon\Carbon::now()
                        ));
                    }
                }
                $image = File::get('img-dist/ads/'.$ads_detail->image_url);
                return response()->make($image, 200, ['content-type' => 'image/*']);
            }

        }catch(Exception $e){
            echo $e->getMessage();
            echo "<br>";
            die('fdsfdas');
        }
    }




    // ads impression save
    public function AdsImpression($adID){
        try{
            $ads_detail = Ad::findOrFail($adID);
            if($ads_detail){
                $adStats = AdStats::where('ad_id', '=', $adID)
                                    ->where('visitor_id','=',Auth::user()->id)
                                    ->where('event_type','=','impression')
                                    ->first();
                if(!$adStats){
                    // insert new click entry 
                    AdStats::insert(array('visitor_id' => Auth::user()->id,
                        'ad_id'=> $adID,
                        'event_type' => 'impression',
                        'created_at' => Carbon\Carbon::now()
                    ));
                }
                $image = File::get('img-dist/ads/'.$ads_detail->image_url);

                return response()->make($image, 200, ['content-type' => 'image/*']);
            }

        }catch(Exception $e){
            echo $e->getMessage();
            die('fdsfdas');
        }
    }



}
