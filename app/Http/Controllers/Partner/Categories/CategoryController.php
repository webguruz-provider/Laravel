<?php

namespace App\Http\Controllers\Partner\Categories;

use App\DebateCategory;
use App\Question;
use App\Partner;
use App\Ad;
use Auth;
use DB;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Category\CategoryStore;
use App\Http\Requests\Admin\Category\CategoryUpdate;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Support\Facades\Input;
//use Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $question_count = new DebateCategory;

        $sort = trim($request->input('sort'));
        $order = trim($request->input('order'));

        // if it is in the acceptable array use it, otherwise default to 'name'
        $sort   = in_array($sort, ['id', 'name']) ? $sort : 'name';
        $order  = in_array($order, ['asc', 'desc']) ? $order : 'desc';

        //$cities = City::orderBy($sort)->paginate(25);

        $debate_category =  $question_count->with('questions')
                                ->where('partner_id','=', auth()->user()->id)
                                ->where('status','live')
                                ->orderBy($sort, $order)
                                ->get();
       // echo "<pre>";
       // print_r(json_decode(json_encode($debate_category)));
       // die();


        $title= "Categories";
        return view('admin.categories.index', compact('debate_category', 'title'));
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
    public function store(CategoryStore $request)
    {
        $input = $request->all();
        
        if( $request->hasFile('avatar_url') ) {
            $image = $request->file('avatar_url');
            $input['avatar_url'] = time().'.'.$image->getClientOriginalExtension();
            // $destinationPath = public_path('/img-dist/category/thumbnail');
            // $thumb_img = Image::make($image->getRealPath())->resize(80, 80);
            // $thumb_img->save($destinationPath.'/'.$input['avatar_url']);

            $destinationPath = public_path('/img-dist/category');
            $image->move($destinationPath, $input['avatar_url']);
            $imgname = $input['avatar_url'];
        }
        else
        {
            $imgname = $request->avatar_url;
        }

        DebateCategory::create([
            'partner_id' => $request->user_id,
            'name' => $request->cat_name,
            'status' => $request->status,
            'image_url' => $imgname,
            'icon_url' => $imgname
        ]);
        Session::flash('message', "Category successfully created. ");
        return redirect()->route('partnerCategoryIndex');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(DebateCategory $category)
    {

        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //echo "kjkjkjk"; exit;
        $title="Edit a Category";
        $debate_category = DebateCategory::with('pro_ads')->where('id', $id)->first();
        $ads = Ad::where('partner_id', Auth::user()->id)->where('advertisement_type',2)->get();
        return view('admin.categories.edit', compact('debate_category', 'ads', 'title'));
    }

    /**
     * Update Category status the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatestatus(Request $request, $id)
    {
        DB::table('debate_category')->where('id', $id)->update(['status' => $request->status]); 
        Session::flash('message', "Category successfully updated. ");
            return redirect()->route('partnerCategoryIndex');
    }

    /**
     * Update Category the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdate $request, $id)
    {
        $input = $request->all();
        
        if( $request->hasFile('avatar_url') ) {
            $image = $request->file('avatar_url');
            $input['avatar_url'] = time().'.'.$image->getClientOriginalExtension();
            // $destinationPath = public_path('/img-dist/category/thumbnail');
            // $thumb_img = Image::make($image->getRealPath())->resize(80, 80);
            // $thumb_img->save($destinationPath.'/'.$input['avatar_url']);

            $destinationPath = public_path('/img-dist/category');
            $image->move($destinationPath, $input['avatar_url']);
            $imgname = $input['avatar_url'];
        }
        else
        {
            $imgname = $request->img_url;

        }

        DebateCategory::whereId($id)->update(['name' => $request->cat_name ,'status' => $request->status, 'image_url' => $imgname, 'icon_url' => $imgname]); 
        Session::flash('message', "Category successfully updated. ");
            return redirect()->route('partnerCategoryIndex');
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

    /**
     * Deactivated categories.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate()
    {

         $question_count = new DebateCategory;
        $debate_category =  $question_count->with('questions')->where([['partner_id','=', auth()->user()->id], ['status', '=', 'deactive']])
            ->orderBy('id', 'desc')
            ->get();

         /* echo "<pre>";
        print_r($debate_category);
        die(); */
        $title= "Categories";
        return view('admin.categories.deactivate', compact('debate_category', 'title'));
    }

    /**
     * Draft categories.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function draft()
    {

         $question_count = new DebateCategory;
        $debate_category =  $question_count->with('questions')->where([['partner_id','=', auth()->user()->id], ['status', '=', 'draft']])
            ->orderBy('id', 'desc')
            ->get();

         /* echo "<pre>";
        print_r($debate_category);
        die(); */
        $title= "Categories";
        return view('admin.categories.draft', compact('debate_category', 'title'));
    }

    public function attach_ads(){
        $attached_ads_id = Input::get('attached_ads_id');
        $category_id = Input::get('category_id');
        if(DebateCategory::where('id', $category_id)->update(['ads_id'=>$attached_ads_id])){
            Session::flash('message', "Ad attachment to category successfully."); 
        }else{
            Session::flash('message', "Error");
        }
        return redirect(url('/partners/categories/edit/'.$category_id));
    }
    public function unattach($id){
        DebateCategory::where('ads_id', $id)->update(['ads_id' => 0]); 
        Session::flash('message', "Ad successfully removed.");
        return redirect()->back();
    }
}
