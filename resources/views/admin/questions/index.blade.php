@extends('layouts.admin')
@section('content')
    <header class="admin-content__header u-bg-white">
        <div class="admin-content__header-mast u-flex-center">
            <h2 class="admin-content__header-title">
                {{$title}}
            </h2>
            <div class="admin-content__header-actions">
                <div class="admin-content__date-group sch-group">
                    @if($view=="live")
                    <!-- <a href="?filter_days=7">Last 7 Days</a>
                    <a href="?filter_days=30">Last 30 Days</a>
                    <a href="?filter_days=180">Last 180 Days</a> -->
                    <select id="filter_days" name="filter_days" class="dropdown-button">
                      <option value="" <?=(!isset($_GET['filter_days']))?"selected":""?>>All</option>
                      <option value="7" <?=(isset($_GET['filter_days']) && $_GET['filter_days']=='7')?"selected":""?>>Last 7 Days</option>
                      <option value="30" <?=(isset($_GET['filter_days']) && $_GET['filter_days']=='30')?"selected":""?>>Last 30 Days</option>
                      <option value="180" <?=(isset($_GET['filter_days']) && $_GET['filter_days']=='180')?"selected":""?>>Last 180 Days</option>
                  </select>

                    @endif
                    <a href="{{ route('partnerQuestionCreate') }}" class="btn btn-green">Create a Question</a>
 <a data-modal-id="open-import" href="#" class="js-open-modal white-button2">Import</a>

									</div>
                
            </div>
        </div>
        <div class="admin-content__header-nav">
            <a class="admin-nav__header-nav-link {{ Request::is('partners/questions/live') ? 'admin-nav__header-nav--active' : '' }}" href="{{ route('partnerLiveQuestionIndex') }}">
                Live
            </a>
            <a class="admin-nav__header-nav-link {{ Request::is('partners/questions/scheduled') ? 'admin-nav__header-nav--active' : '' }}" href="{{ route('partnerScheduledQuestionIndex') }}">
                Scheduled
            </a>
            <a class="admin-nav__header-nav-link {{ Request::is('partners/questions/expired') ? 'admin-nav__header-nav--active' : '' }}" href="{{ route('partnerExpiredQuestionIndex') }}">
                Expired
            </a>
             <a class="admin-nav__header-nav-link {{ Request::is('partners/questions/draft') ? 'admin-nav__header-nav--active' : '' }}" href="{{ route('partnerDraftQuestionIndex') }}">
                Draft
            </a>
            <a class="admin-nav__header-nav-link {{ Request::is('partners/questions/deactivated') ? 'admin-nav__header-nav--active' : '' }}" href="{{ route('partnerDeactivatedQuestionIndex') }}">
                Deactivated
            </a>
        </div>
    </header>
<div id="open-import" class="modal-box">
  <header><a href="#" class="js-modal-close close">×</a>
    <h3>Import Questions</h3>
  </header>
  <div class="modal-body">
    <form method="POST" action="/partners/questions/importCsv" enctype="multipart/form-data">
	<p><input type="file" name="csv_file" accept=".xls,.xlsx,.csv" required></p>
	<p><input type="submit" name="submit" class="debate-btn"></p>
	<a href="{{ asset('csv/sample.csv') }}" name="sample" class="debate-btn" download>Download sample CSV</a>
	</form>
  </div>
</div>

    <main class="admin-content__body">
        @if($view=="live")
        <section class="admin-content__section">
            <?php 
                $week_impressions = array();
                foreach($questions as $question){
                    if(isset($_GET['filter_days']) && $_GET['filter_days']!=''){
                        $collection = $question->impressions()->where('created_at','>=', Carbon\Carbon::now()->subDays($_GET['filter_days']))->get();

                    }else{
                        $collection = $question->impressions()->get();
                    }
                    
                    /*
                    echo "<pre>";
                    print_r(json_decode(json_encode($collection)));
                    echo "</pre>";
                    die;
                    */

                    $data = $collection->groupBy(function ($item) {
                          return $item->created_at->format('Y-m-d'); // given date is mutated to carbon by eloquent..
                          return (new \DateTime($item->created_at))->format('Y-m-d'); // ..othwerise
                        })->reduce(function ($result, $group) {
                          return $result->put($group->first()->created_at->format('D'), collect([
                            'total' => $group->count('id')
                          ]));
                        }, collect());
                        $week_impressions[] = $data;
                    }

                    $array = array();

                    $array['Sun'] = 0;
                    $array['Mon'] = 0;
                    $array['Tue'] = 0;
                    $array['Wed'] = 0;
                    $array['Thu'] = 0;
                    $array['Fri'] = 0;
                    $array['Sat'] = 0;

                    foreach ($week_impressions as $value) {
                        $array['Sun'] = isset($value['Sun'])?$array['Sun']+$value['Sun']['total']:$array['Sun'];
                        $array['Mon'] = isset($value['Mon'])?$array['Mon']+$value['Mon']['total']:$array['Mon'];
                        $array['Tue'] = isset($value['Tue'])?$array['Tue']+$value['Tue']['total']:$array['Tue'];
                        $array['Wed'] = isset($value['Wed'])?$array['Wed']+$value['Wed']['total']:$array['Wed'];
                        $array['Thu'] = isset($value['Thu'])?$array['Thu']+$value['Thu']['total']:$array['Thu'];
                        $array['Fri'] = isset($value['Fri'])?$array['Fri']+$value['Fri']['total']:$array['Fri'];
                        $array['Sat'] = isset($value['Sat'])?$array['Sat']+$value['Sat']['total']:$array['Sat'];   
                    }


                ?>
            <h3 class="admin-content__section-headline">Stat Totals</h3>
            <p class="admin-content__section-desc">
                Total statistics for all live questions <?=isset($_GET['filter_days'])?" over the last ".$_GET['filter_days']." days":''?>
            </p>
            <div class="admin-content__stats u-background-white">
                <div class="admin-content__stat">
                    <h4 class="admin-content__stat-label">
                        Impressions
                    </h4>
                    <span class="admin-content__stat-number">
                        {{ $quesImp }}

                    </span>
                </div><!-- /admin-content__stat-->
                <div class="admin-content__stat">
                    <h4 class="admin-content__stat-label">
                        Clicks
                    </h4>
                    <span class="admin-content__stat-number">
                        {{ $clicks }}
                    </span>
                </div><!-- /admin-content__stat-->
                <div class="admin-content__stat">
                    <h4 class="admin-content__stat-label">
                        User Engagement
                    </h4>
                    <span class="admin-content__stat-number" id="user-engagement">
                        0
                    </span>
                </div><!-- /admin-content__stat-->
                <div class="admin-content__stat">
                    <h4 class="admin-content__stat-label">
                        Ad Clicks
                    </h4>
                    <span class="admin-content__stat-number">
                        {{$adClicks}}
                    </span>
                </div><!-- /admin-content__stat-->
            </div>
        </section><!-- /section-->

        <section class="admin-content__section">
            <h3 class="admin-content__section-headline">Data Breakdown</h3>
            <p class="admin-content__section-desc">
                Explore data of all live questions <?=isset($_GET['filter_days'])?"over the last ".$_GET['filter_days']." days":''?>
            </p>
            <div class="admin-content__chart u-background-white">

                <question-chart :impressions="[<?php echo implode(",",$array) ?>]" :clicks="[120, 123, 87, 43, 50, 23, 10]" :engagement="[45, 88, 44, 67, 54, 66, 15]" :ads="[41, 29, 15, 34, 12, 5, 88]"></question-chart>

            </div>
        </section><!-- /section-->
        @endif
        
        <section class="admin-content__section">
            <div class="admin-content__section-header">
                    @if($view=="live")

                    <div class="ques-info">
                        <h3 class="admin-content__section-headline">Recently Added Questions</h3>
                        <p class="admin-content__section-desc">
                            Explore data of all live questions <?=isset($_GET['filter_days'])?" over the last ".$_GET['filter_days']." days":""?>
                        </p>
                    </div> 

                    @elseif($view=='expired')

                        <div class="ques-info">
                            <h3 class="admin-content__section-headline">Explore data of all Expired Questions <?=isset($_GET['filter_days'])?" over the last ".$_GET['filter_days']." days":""?></h3>

                            <p class="admin-content__section-desc">
                                
                            </p>


                        </div> 

                    @elseif($view=='draft')

                        <div class="ques-info">
                            <h3 class="admin-content__section-headline">Explore data of all Draft Questions <?=isset($_GET['filter_days'])?" over the last ".$_GET['filter_days']." days":""?></h3>

                            <p class="admin-content__section-desc">
                                
                            </p>


                        </div> 

                    @elseif($view=='deactivated')

                        <div class="ques-info">
                            <h3 class="admin-content__section-headline">Explore data of all Deactivated Questions <?=isset($_GET['filter_days'])?" over the last ".$_GET['filter_days']." days":""?></h3>

                            <p class="admin-content__section-desc">
                                
                            </p>


                        </div> 


                    
                    @endif

                </div>
                    <div class="tab-main">                   
<section id="first-tab-group" class="tabgroup">
                    <div class="table-main-scroll"><table class="admin-content__table"><thead><tr>
                        <th class="hide-col">                    
            </th><th class="">
                    Question
            </th><th class="">
                    Author
            </th><th class="">
                    Category
            </th><th class="">
                    Impressions
            </th><th class="">
                    Engagement
            </th><th class="">
                    Expires
            </th><!-- <th class="">
                    Status
            </th> -->
        <th class="hide-col">
            </th></tr></thead> <tbody>

            @foreach($questions as $latest) 

           

            <tr class="clickable-row">
                <td>
                    <form method="POST" action="{{ route('partnerQuestionUpdate' , $latest->id) }}">
                        <input type="hidden" name="question_id" value="{{$latest->id}}">
                        <button type="submit" name="question_status" value="deactive"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
                    </form>
                </td>
                <td><a href="/partners/questions/view/{{$latest->id}}" alt="view question">
                {{$latest->text}}</a>
            </td> <td>
                <a href="/partners/questions/view/{{$latest->id}}" alt="view question">
                {{ Auth::user()->name }}
            </a>
            </td> <td>
                <a href="/partners/questions/view/{{$latest->id}}" alt="view question">
                {{$latest->category->name}}
            </a>
            </td> <td class="admin-table__large-cell">
<a href="/partners/questions/view/{{$latest->id}}" alt="view question">
                <?php //echo $impressions[$latest->id];?>
                
                {{ $latest->QuesImpressions()->count() }}
            </a>

            </td> <td class="admin-table__large-cell user_engagements">
                <a href="/partners/questions/view/{{$latest->id}}" alt="view question">
                {{ count(array_unique($user_enganged[$latest->id])) }}
            </a>
            </td>
            <td>
                <a href="/partners/questions/view/{{$latest->id}}" alt="view question">
                <?php  
               $created = new \Carbon\Carbon($latest->expire_at);
                  $now = \Carbon\Carbon::now();
               if($latest->status=="draft")
               { 
                  echo "Draft";
                }
                elseif ($latest->expire_at <= $now ) 
                {
                  echo "Expired";
                }
                else
                {
                  if($created->diff($now)->days < 1)
                  {
                    echo 'today';
                  }
                  else
                  {
                    echo 'in '.$created->diffInDays($now).' days';
                  }
}
?>
                </a>
                </td>
            <!-- <td>
                {{$latest->status}}
                </td> -->
                <td>
                   <form method="POST" action="/partners/questions/view/{{$latest->id}}">
                        <input type="hidden" name="question_id" value="{{$latest->id}}">
                        <button type="submit"><i class="fa fa-caret-right" aria-hidden="true"></i></button>
                    </form>
                </td>
            
            </tr>
                @endforeach

                @if($questions->count() =='0')
                <tr>
                    <td colspan="8">
                        No record found.
                    </td>
                </tr>


                @endif
            </table></div>
            </section>
            </div>
            </section>
    </main>
	<script>
	$(function(){

var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");

	$('a[data-modal-id]').click(function(e) {
		e.preventDefault();
    $("body").append(appendthis);
    $(".modal-overlay").fadeTo(500, 0.7);
    //$(".js-modalbox").fadeIn(500);
		var modalBox = $(this).attr('data-modal-id');
		$('#'+modalBox).fadeIn($(this).data());
	});  
  
  
$(".js-modal-close, .modal-overlay").click(function() {
    $(".modal-box, .modal-overlay").fadeOut(500, function() {
        $(".modal-overlay").remove();
    });
 
});
 
$(window).resize(function() {
    $(".modal-box").css({
        top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
        left: ($(window).width() - $(".modal-box").outerWidth()) / 2
    });
});
 
$(window).resize();
 
});
</script>
@endsection