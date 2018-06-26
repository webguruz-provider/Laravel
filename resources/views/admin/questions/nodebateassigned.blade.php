@extends('layouts.admin')
@section('content')

<!--new=sec-->
<div class="admin-content__body u-background-light">
<div class="ques-info">
  <label for="text">Question Text</label>
  <p class="field-description">This is what users see when scrolling through the main feed</p>
</div>
<div class="admin-content-new">
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-10">
        <h3 class="admin-content-title">{{ $questions->text }}</h3>
      </div>
      <div class="col-md-2 admin-content-button">
        <p>
          <form method="POST" action="/partners/questions/{{$questions->id}}">
                        <input type="hidden" name="question_id" value="{{$questions->id}}">
                        <button type="submit" class="white-button">Modify Question</button>
                    </form>
        </p>
        <p>
          <form method="POST" action="/partners/questions/update/{{$questions->id}}">
                        <input type="hidden" name="question_id" value="{{$questions->id}}">
                        <button type="submit" name="question_status" value="deactive" class="white-button">Close Question</button>
                    </form>
        </p>
      </div>
    </div>
    <div class="col-md-12">
      <ul class="admin-content-inner">
        <li>
          <p>Created: {{ auth()->user()->name }}</p>
          <p>Category: {{ $questions->category->name }}</p>
        </li>
        <li>
          <p>Published: {{ \Carbon\Carbon::parse($questions->publish_at)->format('M d, Y') }}</p>
          <p>Ad attachment: {{ ($questions) ? ($questions->allAds) ?  $questions->allAds->name : 'No Ad Attached' : 'No Ad Attached'}}</p>
        </li>
        <li>
          <p>Expires: {{ \Carbon\Carbon::parse($questions->expire_at)->format('M d, Y') }}</p>
          <p>Time Remaining: 
               <?php  
               $created = new \Carbon\Carbon($questions->expire_at);
                  $now = \Carbon\Carbon::now();
               if($questions->status=="draft")
               { 
                  echo "Draft";
                }
                elseif ($questions->expire_at <= $now ) 
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
                    echo $created->diffInDays($now).' days';
                  }
}
?></p>
        </li>
        <li>
         <form method="POST" action="/partners/questions/update/{{$questions->id}}">
                        <input type="hidden" name="question_id" value="{{$questions->id}}">
                        <button type="submit" name="question_status" value="deactive"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
                    </form>
        </li>
      </ul>
    </div>
  </div>
</div>

<div class="admin-content__section-header sche-header quest-view1" style="margin-top:15px;">
  <div class="combine-main">
    <h3 class="admin-content__section-headline">Stat Totals</h3>
    <p class="admin-content__section-desc">Explore data this questions has collected by toggling on and off each data point</p>
  </div>
  <div class="combine-main">

    <p class="admin-content__section-desc  combine-button">
      <a data-modal-id="attachAdsPopUp" href="#" class="js-open-modal white-button">
       {{ ($questions) ? ($questions->allAds) ?  'Edit Ad' : 'Attach Ad' : 'Attach Ad'}}
      </a>
      @if(isset($questions) && isset($questions->allAds))
      <a href="{{ route('partnerQuestionUnattach',$questions->allAds->id) }}" class="js-open-modal white-button">
      Remove Ad
      </a>
      @endif
    </p>
  </div>
</div>

<div class="admin-content__stats u-background-white">
  <div class="admin-content__stat">
    <h4 class="admin-content__stat-label"> Impressions </h4>
    <span class="admin-content__stat-number"> N/A </span> </div>
  <!-- /admin-content__stat-->
  <div class="admin-content__stat">
    <h4 class="admin-content__stat-label"> Clicks </h4>
    <span class="admin-content__stat-number"> {{ $questions->clicks()->count() }} </span> </div>
  <!-- /admin-content__stat-->
  <div class="admin-content__stat">
    <h4 class="admin-content__stat-label"> User Engagement </h4>
    <span class="admin-content__stat-number"> N/A </span> </div>
  <!-- /admin-content__stat-->
  <div class="admin-content__stat">
    <h4 class="admin-content__stat-label"> Ad Clicks </h4>
    <span class="admin-content__stat-number"> N/A </span> </div>
  <!-- /admin-content__stat-->
  <div class="admin-content__stat stat-ad-banner" style="background-color:#f5f5f5;"> 
    <?php
        if(!empty($questions) && !empty($questions->allAds)){ ?>
             <img  class="placeholder_banner" src="{{ ($questions) ? ($questions->allAds) ? asset('img-dist/ads/'.$questions->allAds->image_url) : asset('img/ad-banner.jpg') : asset('img/ad-banner.jpg')}}" />
        <?php }else{ ?>
             <img class="placeholder_banner" src="{{ ($questions) ? ($questions->allAds) ? asset('img-dist/ads/'.$questions->allAds->image_url) : asset('img/ad-banner.jpg') : asset('img/ad-banner.jpg')}}" />
        <?php }
    ?>
   

  </div>
  <!-- /admin-content__stat--> 
</div>


<div class="row">
  <div class="col-md-12 activity">
    <div class="col-md-8">
      <div class="admin-content__section-header edit-title">
        <div>
          <h3 class="admin-content__section-headline">Data Breakdown</h3>
        </div>
        <div>
          <p class="admin-content__section-desc">Explore data this questions has collected by toggling on and off each data point</p>
        </div>
      </div>
      <div class="admin-content__chart u-background-white">
        <question-chart :impressions="[300, 403, 112, 400, 480, 442, 108]" :clicks="[120, 123, 87, 43, 50, 23, 10]" :engagement="[45, 88, 44, 67, 54, 66, 15]" :ads="[41, 29, 15, 34, 12, 5, 88]"></question-chart>
      </div>
    </div>
    <!--end-col-md-8-->
    <div class="col-md-4">
      <div class="admin-content__section-header sche-header edit-activity">
        <div>
          <h3 class="admin-content__section-headline">Recent Activity</h3>
          <p class="admin-content__section-desc">See how users are interacting with your question</p>
        </div>
      </div>
      
      <div class="active-list-box u-background-white">
        <ul class="activity-list">
          <li>There is no recent activity yet.</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="modal-box" id="attachAdsPopUp" role="dialog">
  <header> <a href="#" class="js-modal-close close">×</a>
    <h3>Attach Ad to this Question</h3>
  </header>

  <div class="modal-body">

    @if(count($ads))
      <p><small>Please select one of the Ads</small></p>
    @else
      <span class="no-ads"><span>There are no Ads in your account</span></span>
    @endif
    @if(count($ads))
      <form method="POST" action="{{ route('attachAdsToQues') }}">
        <select name="attached_ads_id" id="add-change" style="width: 100%;">
          @foreach($ads as $ad)
            <?php
              $class =''; 
              if($questions->ads_id == $ad->id){
                $class = 'active';
              }
            ?>
            <option  <?php if($questions->ads_id == $ad->id) { echo "selected"; }?> img-path="{{ $ad->image_url }}" value="{{$ad->id}}" class="{{ $class }}">{{$ad->name}} </option>
          @endforeach
        </select>
        <input type="hidden" name="question_id" value="{{$questions->id}}">

        
          <div class="add-img-preview">
            <small>Ad preview</small>
            <img  src="#" width="500" height="200">
          </div>
          <div class="attach-submit"><input type="submit" value="Attach Ad" ></div>
       
      </form>
    @endif

  </div>


</div>

@endsection