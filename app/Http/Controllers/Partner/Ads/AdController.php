<?php

namespace App\Http\Controllers\Partner\Ads;

use DB;
use App\Ad;
use App\User;
use App\AdStats;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Ads\AdsStore;
use App\Http\Requests\Admin\Ads\AdsUpdate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Exception;
use Session;
use App\Question;
use Illuminate\Support\Facades\Auth;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $day_filter = Input::get('filter_days');
            $sql        = Ad::liveAds();

            if($day_filter !== null){
                $sql->where('publish_at', '>=', Carbon::now()->subDays($day_filter));
            }

            $ads    = $sql->get();
            $title  = "Promotions";
            $view   = "live";
            return view('admin.ads.index', compact('ads', 'title','view'));
        }catch(Exception $e){
            $msg = $e->getMessage();
            return view('errors.404_admin', compact('msg'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $debate_category = DB::table('debate_category')->where([['status', '=', 'live'], ['partner_id', '=', Auth::user()->id],])->get();
       
        return view('admin.ads.create', compact('debate_category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(AdsStore $request)
    {    
        $input = $request->all();
        if( $request->hasFile('avatar_url') ) {
            $image = $request->file('avatar_url');
            $input['avatar_url'] = time().'.'.$image->getClientOriginalExtension();
           /* $destinationPath = public_path('/img-dist/ads/thumbnail');
            $thumb_img = Image::make($image->getRealPath())->resize(550, 150);
            $thumb_img->save($destinationPath.'/'.$input['avatar_url']);*/


            $destinationPath = public_path('/img-dist/ads');
            $image->move($destinationPath, $input['avatar_url']);
        }
        Ad::create([
            'partner_id' => $request->user_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'website_url' => $request->weburl,
            'image_url' => $input['avatar_url'],
            'advertisement_type' => $request->advertisement_type,
            'cpm' => $request->cpm,
            'status' => $request->status,
            'publish_at' => $request->publish_at,
            'expire_at' => $request->expire_at

        ]);
        Session::flash('message', "Ad successfully created. ");
        return redirect()->route('partnerAdIndex');
    }

     /**
     * Deactivate the specified Ad.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate(Request $request, $id)
    {
        $input = $request->all();
       
        DB::table('ads')
            ->where('id', $id)
            ->update(['status' => $request->status]); 
            Session::flash('message', "Ad successfully deactivated. ");
            return redirect()->route('partnerAdIndex');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $editad = Ad::where('partner_id', '=', auth()->user()->id)->where('id','=',$id)->first();
            $adAssociatedQuestions = Question::with('category')->where('user_id', auth()->user()->id)->where('ads_id',$id)->get();
            if($editad){
                $day_filter = Input::get('filter_days'); // or using a Request instance
                $sql        = Ad::liveAds()->where('id','!=', $id);

                if($day_filter !== null){
                    $sql->where('publish_at', '>=', Carbon::now()->subDays($day_filter));
                }
                $ads    = $sql->get();
            }else{
                throw new Exception("Invalid Ad Request", '1');
            }
            return view('admin.ads.view', compact('editad','ads','adAssociatedQuestions'));

        }catch(Exception $e){
            $msg = $e->getMessage();
            return view('errors.404_admin', compact('msg'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $debate_category = DB::table('debate_category')->where('status','live')->get();
        $title="Edit";
        $ads = DB::table('ads')->where('id', $id)->first();
        return view('admin.ads.edit', compact('debate_category','ads','title'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdsUpdate $request, $id)
    {

        $input = $request->all();
        if( $request->hasFile('avatar_url') ) {
            $image = $request->file('avatar_url');
            $input['avatar_url'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/img-dist/ads');
            $image->move($destinationPath, $input['avatar_url']);
            $imgname = $input['avatar_url'];
        }
        else
        {
            $imgname = $request->img_url;

        }
        Ad::where('id', $id)->update([
            'partner_id' => $request->user_id,
            'advertisement_type' => $request->advertisement_type,
            'cpm' => $request->cpm,
            'name' => $request->name,
            'website_url' => $request->weburl,
            'image_url' => $imgname,
            'status' => $request->status,
            'publish_at' => $request->publish_at,
            'expire_at' => $request->expire_at
        ]);
        Session::flash('message', "Ad successfully updated. ");
        return redirect()->route('partnerAdIndex');
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
