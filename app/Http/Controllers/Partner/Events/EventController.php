<?php

namespace App\Http\Controllers\Partner\Events;

use DB;
use App\Event;
use App\EventStats;
use Auth;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Event\EventStore;
use App\Http\Requests\Admin\Event\EventUpdate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title      = "Events";
        $view       = "live";
        $day_filter = Input::get('filter_days');


        $query = Event::published();
        if($day_filter !== null){
            $query->where('publish_at', '>=', Carbon::now()->subDays($day_filter));
        }
        $events = $query->get();
        //echo "<pre>";
        //print_r(json_decode(json_encode($events)));
        //die;

        return view('admin.events.index', compact('events', 'title','view'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $debate_category = DB::table('debate_category')->where([['status', '=', 'live'], ['partner_id', '=', Auth::user()->id],])->get();
       
        return view('admin.events.create', compact('debate_category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventStore $request)
    {   

        try{    
            $input = $request->all();
            $input['avatar_url']  = isset($input['avatar_url'])?$input['avatar_url']:'';
            if( $request->hasFile('avatar_url') ) {
                $image = $request->file('avatar_url');
                $input['avatar_url'] = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('img-dist/events');
                $image->move($destinationPath, $input['avatar_url']);
            }
            Event::create([
                'partner_id' => $request->user_id,
                'category_id' => $request->category_id,
                'name' => $request->name,
                'website_url' => $request->weburl,
                'description' => $request->event_description,
                'image_url' => $input['avatar_url'],
                'status' => $request->status,
                'publish_at' => $request->publish_at,
                'expire_at' => $request->expire_at

            ]);
            Session::flash('message', "Event successfully created. ");
            return redirect()->route('partnerEventIndex');
        }catch(\Exception $e){
            echo $e->getMessage();
            
            die('here');
        }
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
       
        DB::table('events')
            ->where('id', $id)
            ->update(['status' => $request->status]); 
            Session::flash('message', "Event successfully deactivated. ");
            return redirect()->route('partnerEventIndex');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */





    public function show_org($id)
    {
        $editad = DB::table('events')->where('id', $id)->first();

        $filter = Input::get('filter_days'); // or using a Request instance

        if ($filter !== null)
        {
            // do something with my eloquent query builder that might involve the key
            // $model->where('someImportantFilter', '=', $filter); // like this

            
            $filter_text = Input::get('filter_text');
            if ($filter_text !== null && $filter_text != ''){

                $events =  DB::table('events')
                    ->where('publish_at', '<=', Carbon::now())
                    ->where([['expire_at', '>=', Carbon::now()], ['partner_id', '=', auth()->user()->id], ['status', '!=', 'draft'],])->where('status', '!=', 'deactive')
                    ->where('name', 'like', '%' . Input::get('filter_text') . '%')
                     ->where('publish_at', '>=', Carbon::now()->subDays($filter))
                    ->get();                            
            }else{
                $events =  DB::table('events')
                        ->where('publish_at', '<=', Carbon::now())
                        ->where([['expire_at', '>=', Carbon::now()], ['partner_id', '=', auth()->user()->id], ['status', '!=', 'draft'],])
                        ->where('status', '!=', 'deactive')
                        ->where('publish_at', '>=', Carbon::now()->subDays($filter))
                        ->get();

            }
            

        }else{
            $events =  DB::table('events')->where('publish_at', '<=', Carbon::now())->where([['expire_at', '>=', Carbon::now()], ['partner_id', '=', auth()->user()->id], ['status', '!=', 'draft'],])->where('status', '!=', 'deactive')->get();
        }
         
        return view('admin.events.view', compact('editad','events'));
    }




    public function show($id)
    {
        $editad = Event::findOrFail($id);

        $day_filter = Input::get('filter_days');

        $query = Event::published();
        if($day_filter !== null){
            $query->where('publish_at', '>=', Carbon::now()->subDays($day_filter));
        }
        $events = $query->where('id','!=',$id)->get();
        
        return view('admin.events.view', compact('editad','events'));
    }












    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $debate_category = DB::table('debate_category')->where([['status', '=', 'live'], ['partner_id', '=', Auth::user()->id],])->get();
        $title="Edit";

        $events = DB::table('events')->where('id', $id)->first();


        return view('admin.events.edit', compact('debate_category','events','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventUpdate $request, $id)
    {
        /*echo "<pre>";
        print_r($request->all());
        exit;*/
        $input = $request->all();
        
        if( $request->hasFile('avatar_url') ) {
            $image = $request->file('avatar_url');
            $input['avatar_url'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/img-dist/events');
            $image->move($destinationPath, $input['avatar_url']);
            $imgname = $input['avatar_url'];
        }
        else
        {
            $imgname = $request->img_url;

        }

        DB::table('events')
            ->where('id', $id)
            ->update(['partner_id' => $request->user_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'website_url' => $request->weburl,
            'image_url' => $imgname,
            'status' => $request->status,
            'publish_at' => $request->publish_at,
            'expire_at' => $request->expire_at,
            'description' => $request->event_description]); 
            Session::flash('message', "Event successfully updated. ");
            return redirect()->route('partnerEventIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
