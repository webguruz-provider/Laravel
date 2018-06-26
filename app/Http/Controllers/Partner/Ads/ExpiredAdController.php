<?php

namespace App\Http\Controllers\Partner\Ads;
use DB;
use App\Ad;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;

class ExpiredAdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads =  Ad::expired()->where('partner_id', '=', auth()->user()->id)->get();

        /*


        $filter_text = Input::get('filter_text');
        if ($filter_text !== null && $filter_text != ''){
            $ads =  DB::table('ads')->where([['expire_at', '<', Carbon::now()], ['partner_id', '=', auth()->user()->id], ['status', '!=', 'draft'],])
            ->where('status', '!=', 'deactive')
            ->where('name', 'like', '%' . Input::get('filter_text') . '%')->get();

        }else{
           $ads =  DB::table('ads')->where([['expire_at', '<', Carbon::now()], ['partner_id', '=', auth()->user()->id], ['status', '!=', 'draft'],])->where('status', '!=', 'deactive')->get();
        }

        */


        $title= "Promotions";
        $view="expired";
        return view('admin.ads.index', compact('ads', 'title','view'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
