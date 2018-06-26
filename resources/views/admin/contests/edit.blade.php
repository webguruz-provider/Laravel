@extends('layouts.admin')
@section('content')
<div class="admin-content__body u-background-light">
  <div class="admin-content__table-header">
    <h2 class="admin-content__table-title"> {{$title}} Contest </h2>
  </div>
  <div class="ques-info">
    <label for="text">Contest Creative</label>
    <p class="field-description">This is what users see when scrolling through the main feed</p>
  </div>
  <div class="admin-content__form">
    <form method="POST" action="/partners/contests/update/{{$contests->id}}" enctype="multipart/form-data">
      <div class="field field-err">
        <div class="field-inner">
          <input type="text" name="name" class="form-control ad-textbox" value="{{$contests->name}}">
          <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
          @if ($errors->has('name'))
                  <span style="color: red;" class="validation_err">{{ $errors->first('name') }}</span>
              @endif 
        </div>
      </div>
      <div class="ranged"  style="border-bottom: 1px solid #ccc; margin-bottom: 20px;">
        <div class="field field__left field-err">
          <div class="upload-sec">
            <input type="file" name="avatar_url" id="avatar_url"/>
            
            <input type="hidden" name="img_url" value="{{$contests->image_url}}">
            <img id="img-preview" src="{{ asset('img-dist/contests').'/'.$contests->image_url }}" alt="" />
            <span></span> </div>
            @if ($errors->has('avatar_url'))
              <span style="color: red;" class="validation_err">{{ $errors->first('avatar_url') }}</span>
          @endif
			<span style="color: red;" class="img-size-err"></span>
          <label for="text">DESTINATION WEBSITE</label>
          <p class="field-description">Where this contest should send users on click</p>
          <input class="hide-bg" type="url" name="weburl" value="{{$contests->website_url}}" pattern="(http|https)?://.+" />
          <p class="field-description">eg. (http|https)://in.yahoo.com/</p>
          @if ($errors->has('weburl'))
                <span style="color: red;" class="validation_err">{{ $errors->first('weburl') }}</span>
            @endif
        </div>
        <div class="field field__right">
                <p class="field-description first-line"><strong>About Contests</strong></p>
                <p class="field-description">Many stations and podcasts run contests. USe this section to integrate you current contests into your pro profile to help listeners find and participate in these rewards. </p>

                </div>
      </div>
       <div class="ranged">
 <div class="field field-err">
            <label for="text">Describe the contest</label>
          <p class="field-description">Enter the description from your website</p>
          <textarea name="contest_description">{{$contests->description}}</textarea>
          @if ($errors->has('contest_description'))
            <span style="color: red;" class="validation_err">{{ $errors->first('contest_description') }}</span>
        @endif
</div>
</div>
      <div class="ranged">
        <div class="field field__left">
          <label for="text">Contest Information</label>
          <p class="field-description">Choose any placement options for the contest unit.</p>
        </div>
      </div>
      <div class="ranged">
        <div class="field field__left field-err">
          <label for="text">Choose a Category</label>
          <p class="field-description">Select all topics that apply.</p>
          <select name="category_id" class="form-control">
            
					@foreach($debate_category as $categories)
		
            <option @if($contests->category_id==$categories->id) selected @endif value="{{$categories->id}}">{{$categories->name}}</option>
            
					@endforeach
					
          </select>
          @if ($errors->has('category_id'))
                <span style="color: red;" class="validation_err">{{ $errors->first('category_id') }}</span>
            @endif
             </div>
        <div class="field field__right">
          <label for="text">CHOOSE A PRO PROFILE</label>
          <p class="field-description">Select the profile you’d like this contest to post to</p>
          <select class="form-control" disabled>
            <option value="">Pick one</option>
          </select>
        </div>
      </div>
      <div class="ranged">
        <div class="field field__left field-err">
          <label for="text">Publish Date</label>
          <p class="field-description">Select all topics that apply.</p>
          <input type="text" name="publish_at" class="form-control" data-calendar-start value="{{$contests->publish_at}}">
          @if ($errors->has('publish_at'))
                  <span style="color: red;" class="validation_err">{{ $errors->first('publish_at') }}</span>
              @endif
          </div>
        <div class="field field__right field-err">
          <label for="text">Expiration Date</label>
          <p class="field-description">Select all topics that apply.</p>
          <input type="text" name="expire_at" class="form-control" data-calendar-end value="{{$contests->expire_at}}">
          @if ($errors->has('expire_at'))
                  <span style="color: red;" class="validation_err">{{ $errors->first('expire_at') }}</span>
              @endif
           </div>
      </div>
      <div class="field-group">
        <button class="btn btn-green" type="submit" name="status" value="live">Update Contest</button>
      </div>
    </form>
  </div>
  
</div>
@endsection