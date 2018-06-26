@extends('layouts.admin')
@section('content')
<div class="admin-content__body u-background-light">
  <div class="admin-content__table-header">
    <h2 class="admin-content__table-title"> {{$title}} an Ad Unit </h2>
  </div>
  <div class="ques-info">
    <label for="text">Ad Creative</label>
    <p class="field-description">This is what users see when scrolling through the main feed</p>
  </div>
  <div class="admin-content__form">
    <form method="POST" action="/partners/ads/update/{{$ads->id}}" enctype="multipart/form-data">
      <div class="field field-err">
        <div class="field-inner">
          <input type="text" name="name" class="form-control ad-textbox" value="{{$ads->name}}">
          @if ($errors->has('name'))
            <span style="color: red;" class="validation_err">{{ $errors->first('name') }}</span>
          @endif
          <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
      </div>
      <div class="ranged"  style="border-bottom: 1px solid #ccc; margin-bottom: 20px;">
        <div class="field field__left field-err">
          <div class="upload-sec">
            <input type="file" name="avatar_url" id="avatar_url"/>
            
            <input type="hidden" name="img_url" value="{{$ads->image_url}}">
            <img id="img-preview" src="{{ asset('img-dist/ads').'/'.$ads->image_url }}" alt="" />
            <span></span> </div>
            @if ($errors->has('avatar_url'))
                    <span style="color: red;" class="validation_err">{{ $errors->first('avatar_url') }}</span>
                @endif  
			<span style="color: red;" class="img-size-err"></span>
          <label for="text">DESTINATION WEBSITE</label>
          <p class="field-description">Where this advertisement should send users on click</p>
          <!-- <input class="hide-bg" type="url" name="weburl" value="{{$ads->website_url}}" /> -->


          <input class="hide-bg" type="url" pattern="(http|https)?://.+" name="weburl" placeholder="Enter url..." value="{{$ads->website_url}}" />
          @if ($errors->has('weburl'))
                        <span style="color: red;" class="validation_err">{{ $errors->first('weburl') }}</span>
                    @endif
          <p class="field-description">eg. (http|https)://in.yahoo.com</p>
        </div>
        <div class="field field__right">
          <p class="field-description first-line"><strong>Uploading the Right Creative</strong></p>
          <p class="field-description">Sided uses IAB Standard Ad Units for display ads that appear in our question feed and details. </p>
          <p class="field-description">We currently support 320x50 Smartphone Banner in questions.</p>
          <p class="field-description"><a href="" id="open_adportfolio">https://www.iab.com/newadportfolio/</a></p>
        </div>
      </div>
      <div class="ranged">
        <div class="field field__left">
          <label for="text">Placement Information</label>
          <p class="field-description">Choose any placement options for the ad unit.</p>
        </div>
      </div>
      <div class="ranged">
        <!-- <div class="field field__left field-err">
          <label for="text">Choose a Category</label>
          <p class="field-description">Select all topics that apply.</p>
          <select name="category_id" class="form-control">
            
          @foreach($debate_category as $categories)
    
            <option @if($ads->category_id==$categories->id) selected @endif value="{{$categories->id}}">{{$categories->name}}</option>
            
          @endforeach
          
          </select>
          @if ($errors->has('category_id'))
              <span style="color: red;" class="validation_err">{{ $errors->first('category_id') }}</span>
          @endif
          <span class="validation is-danger" v-if="form.errors.has('category_id')" v-text="form.errors.get('category_id')"></span> </div>
        <div class="field field__right field-err">
          <label for="text">CHOOSE A PRO PROFILE</label>
          <p class="field-description">Select the profile you’d like this advertisement to post to</p>
          <select class="form-control" disabled>
            <option value="">Pick one</option>
          </select>
        </div> -->
        <div class="field field__left field-err">
						<label for="text">Choose type of advertisement</label>
						<select name="advertisement_type" class="form-control">
							<option value="">Pick one</option>
							<option @if($ads->advertisement_type==1) selected @endif value="1">Individual questions</option>
							<option @if($ads->advertisement_type==2) selected @endif value="2">Question categories</option>
							<option @if($ads->advertisement_type==3) selected @endif value="3">Pro account</option>
						</select>
						@if ($errors->has('advertisement_type'))
							<span style="color: red;" class="validation_err">{{ $errors->first('advertisement_type') }}</span>
						@endif
					</div>

					<div class="field field__right">
						<label for="text">CPM</label>
						<input name="cpm" placeholder="CPM Value..." value="{{ $ads->cpm }}" class="form-control hide-bg" type="text">
						@if ($errors->has('cpm'))
							<span style="color: red;" class="validation_err">{{ $errors->first('cpm') }}</span>
						@endif
					</div>
      </div>
      <div class="ranged">
        <div class="field field__left field-err">
          <label for="text">Publish Date</label>
          <p class="field-description">Select all topics that apply.</p>
          <input type="text" name="publish_at" class="form-control" data-calendar-start value="{{$ads->publish_at}}">
          @if ($errors->has('publish_at'))
                          <span style="color: red;" class="validation_err">{{ $errors->first('publish_at') }}</span>
                      @endif
           </div>
        <div class="field field__right">
          <label for="text">Expiration Date</label>
          <p class="field-description">Select all topics that apply.</p>
          <input type="text" name="expire_at" class="form-control" data-calendar-end value="{{$ads->expire_at}}">
          @if ($errors->has('expire_at'))
                          <span style="color: red;" class="validation_err">{{ $errors->first('expire_at') }}</span>
                      @endif
                       </div>
      </div>
      <div class="field-group">
        <button class="btn btn-green" type="submit" name="status" value="live">Update Ad</button>
      </div>
    </form>
  </div>
  
</div>
@endsection