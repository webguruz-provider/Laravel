<?php

namespace App\Http\Controllers\Partner\Advertisers;

use Auth;
use Session;
use App\Advertiser;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Advertisers\AdvertiserStore;
use App\Http\Requests\Admin\Advertisers\AdvertiserUpdate;
use App\Http\Controllers\Controller;
class AdvertiserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advertisers = Advertiser::where('user_id',Auth::user()->id)->where('status',1)->orderBy('id','DESC')->get();
        return view('admin.advertisers.index',compact('advertisers'));
    }
    public function create(){
        $advertisers = Advertiser::where('user_id',Auth::user()->id)->where('status',1)->get();
        return view('admin.advertisers.create', compact('advertisers'));
    }
    public function store(AdvertiserStore $request){
       $advertiser = Advertiser::create([
            'company_name' => $request->get('company_name'),
            'user_id' => Auth::user()->id,
            'contact_name' => $request->get('contact_name'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'agreement' => $request->get('agreement'),
            'status' => 1
       ]);
       if($advertiser){
            Session::flash('message', "Advertisers successfully created.");
            return redirect()->route('partnerAdvertiserIndex');
       }else{
            Session::flash('message', "Error!. Please try again.");
            return redirect()->back();
       }
    }
    public function edit($advertiser_id){
        $advertiser = Advertiser::findOrFail($advertiser_id);
        if($advertiser){
            return view('admin.advertisers.edit',compact('advertiser'));
        }else{
           //error message
        }
    }
    public function update(AdvertiserUpdate $request){
        $id = $request->get('advertiser_id');
        $advertiser =  Advertiser::findOrFail($id);
        $advertiser->company_name = $request->get('company_name');
        $advertiser->contact_name = $request->get('contact_name');
        $advertiser->phone = $request->get('phone');
        $advertiser->email = $request->get('email');
        if($advertiser->save()){
            Session::flash('message', "Advertisers successfully updated.");
            return redirect()->route('partnerAdvertiserIndex');
        }else{
            Session::flash('message', "Error!. Please try again.");
            return redirect()->back();
        }
    }
    public function inactive(){
        $advertisers = Advertiser::where('user_id',Auth::user()->id)->where('status',0)->get();
        return view('admin.advertisers.inactive',compact('advertisers'));
    }
    public function deativate($id){
        $isDeactivated = Advertiser::where('user_id',Auth::user()->id)->where('id', $id)->update(['status' => 0]);
        if($isDeactivated){
            Session::flash('message', "Advertisers successfully deactivated.");
            return redirect()->back();
        }else{
            Session::flash('message', "Error!. Please try again.");
            return redirect()->back();
        }
    }
    public function activate($id){
        $isActivated = Advertiser::where('id', $id)->update(['status' => 1]);
        if($isActivated){
            Session::flash('message', "Advertisers successfully activated.");
            return redirect()->back();
        }else{
            Session::flash('message', "Error!. Please try again.");
            return redirect()->back();
        }
    }
}
