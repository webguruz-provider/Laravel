<?php

namespace App\Http\Controllers\Partner\Questions;

use Auth;

use App\Question;
use App\DebateCategory;
use App\DebateCategoryUser;
use App\Debate;
use App\DebateUser;
use App\DebateArgument;
use App\DebateComment;
use App\User;
use App\UserPoint;
use App\Impression;
use App\UserServey;
use App\UserAnswer;
use App\Answer;
use App\Ad;
use Session;
use Carbon\Carbon;

use Exception;

use DB;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Questions\QuestionStore;
use App\Http\Requests\Admin\Questions\QuestionUpdatequestion;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $debate_category= DB::table('debate_category')->where([['status', '=', 'live'], ['partner_id', '=', Auth::user()->id],])->get();

        $questions      = Question::Published()->with('category')
                            ->where('questions.user_id', '=', auth()->user()->id)
                            ->orderby('id', 'desc')
                            ->get();


        $user_enganged  = array();
        $impressions    = array();
        

        foreach($questions as $question){
            $user_enganged[$question->id] = array();
            //$impressions[$question->id] = array();
            foreach($question->debates as $debate){
                //$particepent_users = json_decode(json_encode($debate->users));

                foreach($debate->users as $user){
                    $user_enganged[$question->id][] = $user->id;
                }

                if(is_object($debate->comments)){
                    foreach($debate->comments as $user){
                        $user_enganged[$question->id][] = $user->user_id;
                    }
                }

                if(is_object($debate->votes)){
                    foreach($debate->votes as $vote){
                        //print_r($vote);

                        $user_enganged[$question->id][] = $vote->voter_id;
                    }
                }

                

                //$impressions[$question->id][] = UserPoint::where('event_id', $debate->id)->where('event_type','debate_view')->count();
            }
            $impressions[$question->id] = Impression::where('question_id',$question->id)->count();

        }

        //echo "<pre>";
         //       print_r(json_decode(json_encode($user_enganged)));
         //       echo "</pre>";
        //        die;



        $total_impressions = $this->array_sum_recursive($impressions);
       /* echo "<pre>";
        print_r($user_enganged);
        die;*/
        //return view('admin.questions.create', compact('debate_category','questions'));

        return view('admin.questions.create', compact('questions','debate_category', 'user_enganged','impressions', 'total_impressions'));

    }

    function array_sum_recursive($array)
    {
        $sum = 0;

        array_walk_recursive($array, function($item) use (&$sum) {
            $sum += $item;
        });

        return $sum;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionStore $request)
    {   
        $request->validate([
            'text' => 'required',
            'category_id' => 'required',
            'publish_at' => 'required',
            'expire_at' => 'required'
        ]);
        if($request->has('question_type')){
            $questionType = 1;
            $has_multiple_ans = 1;
        }else{
            $questionType = 0;
            $has_multiple_ans = 0;
        }
        try{
        
            Question::create([
                'user_id' => $request->user_id,
                'partner_id' => $request->user_id,
                'category_id' => $request->category_id,
                'name' => $request->text,
                'text' => $request->text,
                'publish_at' => $request->publish_at,
                'expire_at' => $request->expire_at,
                'status' => $request->status,
                'question_type' => $questionType,
                'has_multiple_ans' => $has_multiple_ans
            ]);

            //return view('admin.questions.index');
            Session::flash('message', "Question successfully created.");
            return redirect()->route('partnerLiveQuestionIndex');
        }catch(Exception $e){
            //echo $e->getMessage();
            //die('here');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $debates = $question->debates()->get();
        $users = $debates->users()->get();
        //dd($users);
        return view('admin.questions.show', compact('question'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hasQuesAuthorCount = Question::whereId($id)->where('user_id', Auth::user()->id)->count();
        $debate_category = DB::table('debate_category')->where([['status', '=', 'live'], ['partner_id', '=', Auth::user()->id],])->get();

        $questions = Question::with('category')->where('questions.id', '=', $id)->orderby('id', 'desc')->first();
        if($hasQuesAuthorCount == 1){
            return view('admin.questions.edit', compact('debate_category','questions'));
        }else{
            return view('errors.pro-404');
        }
    }

    /**
     * Show the form for overall activities.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activity()
    {
        $latestquestions = new Question;
        $questions = Question::Published()->with('category')
                        ->where('questions.user_id', '=', auth()->user()->id)
                        ->orderby('id', 'desc')
                        ->get();
        return view('admin.questions.activity', compact('questions')); 
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

        DB::table('questions')
            ->where('id', $id)
            ->update(['status' => $request->question_status]); 
            Session::flash('message', "Question successfully deactivated. ");
            return redirect()->back();
    }



    

    public function updatequestion(QuestionStore $request)
    {
        /* echo "<pre>";
        print_r($request->all());
        exit;*/
        $request->validate([
            'text' => 'required',
            'category_id' => 'required',
            'expire_at' => 'required'
        ]);
        if ($request->has('publish_at'))
        {
            $question_id = $request->question_id;
            $question_status = $request->status;
            $question_text = $request->text;
            $category_id = $request->category_id;
            $publish_at = $request->publish_at;
            $expire_at = $request->expire_at;
            Question::where('id', $question_id)->update(['status' => $question_status, 'text' => $question_text, 'name' => $question_text, 'category_id' => $category_id, 'publish_at' => $publish_at,'expire_at' => $expire_at,]); 
        }
        else
        {
            $question_id = $request->question_id;
            $question_status = $request->status;
            $question_text = $request->text;
            $category_id = $request->category_id;
            $expire_at = $request->expire_at;
            Question::where('id', $question_id)->update(['status' => $question_status, 'text' => $question_text, 'name' => $question_text, 'category_id' => $category_id, 'expire_at' => $expire_at,]); 
            Debate::where('question_id', $question_id)->update(['ends_at' => $expire_at, 'updated_at' => $expire_at,]); 
        }
        //return ['message' => 'updated'];

        Session::flash('message', "Questions successfully updated. ");
            return redirect()->route('partnerLiveQuestionIndex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $question = App\Question::find($id);
       $question->delete();
       Session::flash('message', "Questions destroy successfully. ");
       return redirect()->route('partnerLiveQuestionIndex');
    }

    /**
     * Remove argument specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyargument($id)
    {
       DebateArgument::where('id', $id)->update(['status'=>'deactivate']);
       return redirect()->back();
    }

    /**
     * Remove comments specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroycomment($id)
    {
       DebateComment::where('id', $id)->update(['status'=>'deactivate']);
       return redirect()->back();
    }

    /**
     * View the specified question.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function preview($id)
    {
        //die('here');
        $hasQuesAuthorCount = Question::whereId($id)->where('user_id', Auth::user()->id)->count();
        $questions = Question::with('category','allAds')->where('questions.id', '=', $id)->orderby('id', 'desc')->first();
        $ads = Ad::where('partner_id', Auth::user()->id)->where('advertisement_type',1)->get();
        /*echo "<pre>";
        print_r($questions);
        exit;*/
        //$debate_id = DB::table('debates')->where('question_id', $id)->get();


        $filter = Input::get('filter_days'); // or using a Request instance
        if ($filter !== null)
        {
            $debate_id = DB::table('debates')->where('question_id', $id)->where('starts_at', '>=', Carbon::now()->subDays($filter))->get();


            $questions1 = Question::with('author', 'category', 'debates', 'debates.users', 'debates.argumentPro','debates.commentPro', 'debates.votes')->where('questions.id', '=', $id)->get();
            

            $debates = Debate::with(['users','argumentPro','commentPro'])->where('question_id',$id)->where('starts_at', '>=', Carbon::now()->subDays($filter))->get();



        }else{
            $debate_id = DB::table('debates')->where('question_id', $id)->get();
            $questions1 = Question::with('author', 'category', 'debates', 'debates.users', 'debates.argumentPro','debates.commentPro', 'debates.votes')->where('questions.id', '=', $id)->get();
            $debates = Debate::with(['users','argumentPro','commentPro'])->where('question_id',$id)->get();
        }



        


        $user_enganged  = array();

        foreach($questions1 as $question){
            $user_enganged[$question->id] = array();

            foreach($question->debates as $debate){

                foreach($debate->users as $user){
                    $user_enganged[$question->id][] = $user->id;
                }

                if(is_object($debate->comments)){
                    foreach($debate->comments as $user){
                        $user_enganged[$question->id][] = $user->user_id;
                    }
                }

                if(is_object($debate->votes)){
                    foreach($debate->votes as $vote){
                        $user_enganged[$question->id][] = $vote->voter_id;
                    }
                }
            }
        }
        $dbt_id = "";
        $dbt_id = array();
        foreach($debate_id as $debates_id)
        {
            $dbt_id[] = $debates_id->id;
        }
       
        if(!empty($dbt_id))
        {

            $recent_arguments   = Debate::with(['argumentPro','argumentPro.user'])->find($dbt_id);
            $recent_comments    = Debate::with(['commentPro','commentPro.user'])->find($dbt_id);
            $side               = DB::table('debate_user')->where('debate_id', $debate_id[0]->id)->get();
        }

       //$debate_new = new Debate();

            //$debate_users = $debate_new->with('users','argumentPro','commentPro','votes')->find($dbt_id);

       /*
        $agree_users = $debate_new->with('users','argumentPro','commentPro')
        ->join('debate_user', 'debate_user.debate_id', '=', 'debates.id')
        ->join('users', 'users.id', '=', 'debate_user.user_id')
        ->select('debates.*', 'debate_user.*', 'users.*')
        ->where('debate_user.side','Agree')
        ->find($dbt_id);

         $disagree_users = $debate_new->with('users','argumentPro','commentPro','votes')
        ->join('debate_user', 'debate_user.debate_id', '=', 'debates.id')
        ->join('users', 'users.id', '=', 'debate_user.user_id')
        ->select('debates.*', 'debate_user.*', 'users.*')
        ->where('debate_user.side','Disagree')
        ->find($dbt_id);
    
        */
        if($hasQuesAuthorCount == 1){
            if($questions->question_type == 1){
                $user_enganged = UserAnswer::with('user.categories')->where('question_id',$id)->distinct()->get(['user_id']);
                return view('admin.questions.multi-choice-question', compact('questions', 'ads', 'user_enganged'));
            }else{
                if(!empty($dbt_id))
                {
                return view('admin.questions.preview', compact('questions', 'ads', 'recent_arguments','recent_comments','side','user_enganged','debates'));
                }
                else
                {
                    return view('admin.questions.nodebateassigned', compact('questions', 'ads', 'user_enganged'));
                }
            }
        }else{
            return view('errors.pro-404');
        }
    }








    public function support()
    {
       return view('admin.support.show');
    }


    public function attach_ads(){
        $attached_ads_id = Input::get('attached_ads_id'); // or using a Request instance
        $question_id = Input::get('question_id');

        if(Question::where('id', $question_id)->update(['ads_id'=>$attached_ads_id])){
            Session::flash('message', "Ad attachment to question successfully."); 
        }else{
            Session::flash('message', "Error");
        }
        return redirect(url('/partners/questions/view/'.$question_id));
    }

    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }

    public function importCsv(Request $request)
    {
		try
			{
        if( $request->hasFile('csv_file') ) {
            $csv = $request->file('csv_file');
            if($csv->getClientOriginalExtension()=='csv' || $csv->getClientOriginalExtension()=='xls' || $csv->getClientOriginalExtension()=='xlsx')
            {
            $input['csv_file'] = time().'.'.$csv->getClientOriginalExtension();
            $destinationPath = public_path('/csv');
            $csv->move($destinationPath, $input['csv_file']);

            $file = public_path('csv/'.$input['csv_file']);

        $customerArr = $this->csvToArray($file);

		/*echo "<pre>";
        print_r($customerArr);*/
		$i=0;
        foreach ($customerArr as $question_data)
        {
            
				$cat_name = trim($question_data['category_name']);
            $debate_categoryID = DB::table('debate_category')->select('id')->where('name','=',$cat_name)->first();
            //echo $debate_categoryID->id;
            Question::insert(array('user_id' => auth()->user()->id,
                        'category_id'=> $debate_categoryID->id,
                        'name' => $question_data['question_text'],
                        'text' => $question_data['question_text'],
                        'publish_at' => Carbon::parse($question_data['publish_at'])->format('Y-m-d H:i:s'),
                        'expire_at' => Carbon::parse($question_data['expire_at'])->format('Y-m-d H:i:s'),
						'status' => 'publish')
                    );
           //Question::firstOrCreate($customerArr[$i]);
		   $i++;
        }
        Session::flash('message', "Questions inserted ".count($customerArr));
        return redirect()->route('partnerLiveQuestionIndex');
		
        }
        else
        {
            Session::flash('errorcsv', "Invalid format.");
            return redirect()->route('partnerLiveQuestionIndex');
        }
		}
    }catch(\Exception $e){
            DB::rollback();

            //echo $e->getMessage().' on line number in store debate '.$e->getLine();
            //die($e->getMessage());
			Session::flash('errorcsv', "Questions inserted ".$i. ' out of '.count($customerArr) );
			return redirect()->route('partnerLiveQuestionIndex');
        }
  
    }

    /*
        remove ad from question
    */

        public function unattach($id)
        {
            
            DB::table('questions')
            ->where('ads_id', $id)
            ->update(['ads_id' => 0]); 
            Session::flash('message', "Ad successfully removed. ");
            return redirect()->back();
        }
    /*
        Multiple choice question settings
    */
    public function multiChoiceSetting(Request $request){
        $id = $request->get('question_id');
        $answer_type = 0;
        $instant_result = 0;
        $allowed_other_answer = 0;
        if($request->has('answer_type')){
          $answer_type = 1;  
        }
        if($request->has('instant_result')){
            $instant_result = 1;  
        }
        if($request->has('allowed_other_answer')){
            $allowed_other_answer = 1;  
        }
        $question = Question::findOrFail($id);
        if($question){
            $question->answer_type = $answer_type;
            $question->instant_result = $instant_result;
            $question->allowed_other_answer = $allowed_other_answer;
            if($question->save()){
                Session::flash('message', "Multiple choice question setting successfully Updated. ");
                return redirect()->back();
            }else{
                Session::flash('message', "Error while uploading. ");
                return redirect()->back();
            }
        }else{
            Session::flash('message', "No such qustion is available. ");
            return redirect()->back();
        }
    }
    public function serveyResult($question_id){
        //$colorArrays = ['#28a745', '#5873fe', '#e7b63a', '#323232', '#004bbc', '#41cac0', '#9972b5', '#ff6c60', '#57c8f2', '#343957', '#82b440', '#dddddd'];
        $colorArrays = ['#28a745', '#5873fe', '#e7b63a', '#323232', '#004bbc', '#41cac0', '#9972b5', '#ff6c60', '#57c8f2', '#343957', '#82b440', '#dddddd', '#00bfff', '#804000'];
        $questionDetails = Question::find($question_id);
        $hasQuesAuthorCount = Question::whereId($question_id)->where('user_id', Auth::user()->id)->count();
        $otherAnswersCount = UserAnswer::where('question_id',$question_id)->where('answer_id',NULL)->count();
        $answered = UserServey::where('question_id',$question_id)->where('status',1)->count();
        $skipped = UserServey::where('question_id',$question_id)->where('status',0)->count();
        $serveyResults = Answer::with('serveyAnswers')->where('question_id',$question_id)->get();
        $hasServeyAns = UserAnswer::where('question_id',$question_id)->count();
        if($hasQuesAuthorCount == 1){
            return view('admin.questions.servey-result', compact('colorArrays', 'answered', 'skipped', 'serveyResults', 'otherAnswersCount', 'questionDetails', 'hasServeyAns')); 
        }else{
            return view('errors.pro-404');
        }
            // return view('admin.questions.servey-result', compact('colorArrays', 'answered', 'skipped', 'serveyResults')); 
    }
}
