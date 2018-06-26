@extends('layouts.admin')

@section('content')

    <main class="game-wrapper">
        <aside class="game-sidebar game-sidebar__right profile-content">
            <div class="game-header">Your Profile</div>
            <div class="profile-image">
                <img width="200px" src="{{ asset('images') }}/{{ Auth::user()->avatar_url }}">
            </div>
            <div class="profile-content-inner">
                <p class="profile-name">{{ Auth::user()->name }}</p>
                <p class="profile-email">{{ Auth::user()->email }}</p>
            </div>
    </aside>
    

@if (Session::has('success') || Session::has( 'warning' ))
    <div class="message_editprofile">
        @if( Session::has( 'success' ))
             {{ Session::get( 'success' ) }}
        @elseif( Session::has( 'warning' ))
             {{ Session::get( 'warning' ) }} <!-- here to 'withWarning()' -->
        @endif
    </div>
@endif

    <div class="game-main debate-single update-profile">
        <div class="game-header">Update Your Profile Information</div>

            <form class="form-horizontal form login-form u-center-block" role="form" method="POST" action="{{ route('proprofile.update', Auth::user()->id) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Name</label>
                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required autofocus>

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                    <div class="col-md-8">
                        <input id="email" type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                    <label for="phone_number" class="col-md-4 control-label">Mobile Phone</label>

                    <div class="col-md-8">
                        <input id="phone_number" type="tel" class="form-control" name="phone_number" value="{{ Auth::user()->phone_number }}">

                        @if ($errors->has('phone_number'))
                            <span class="help-block">
                                <strong>{{ $errors->first('phone_number') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('handle') ? ' has-error' : '' }}">
                    <label for="handle" class="col-md-4 control-label">Handle</label>

                    <div class="col-md-8">
                        <input id="handle" type="tel" class="form-control" name="handle" value="{{ Auth::user()->handle }}">

                        @if ($errors->has('handle'))
                            <span class="help-block">
                                <strong>{{ $errors->first('handle') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('avatar_url') ? ' has-error' : '' }}">
                    <label for="avatar_url" class="col-md-4 control-label">Image Upload</label>

                    <div class="col-md-8 upload-btn">
                        <input id="avatar_url" type="file" class="form-control" name="avatar_url" value="{{ old('avatar_url') }}" accept='image/*' />

                        <img id="img-preview" />
                        
                        @if ($errors->has('avatar_url'))
                            <span class="help-block">
                                <strong>{{ $errors->first('avatar_url') }}</strong>
                            </span>
                        @endif
                        <span style="color: red;" class="img-size-err"></span>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('background_img') ? ' has-error' : '' }}">
                    <label for="background_img" class="col-md-4 control-label">Background image Upload</label>

                    <div class="col-md-8 upload-btn">
                        <input id="background_img" type="file" class="form-control" name="background_img" value="{{ old('background_img') }}" accept='image/*' />

                        <img id="background-img-preview" />
                        
                        @if ($errors->has('background_img'))
                            <span class="help-block">
                                <strong>{{ $errors->first('background_img') }}</strong>
                            </span>
                        @endif
                        <span style="color: red;" class="img-size-err"></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12" style="text-align:right;">
                        <button type="submit" class="debate-btn">
                            Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
		
        <!--aside class="game-sidebar game-sidebar__right">
            <div class="game-header">Activity Feed</div>
            <div class="u-background-white">
                
            </div>
        </aside-->
        
    </main>
    <aside class="game-sidebar profile-content">
        <div class="game-main debate-single update-profile profile-main">
            <div class="col-md-12">
                <div class="col-md-12 admin-content-button">
                    <a data-modal-id="attachAdsPopUp" href="#" class="js-open-modal white-button">
                        {{ (Auth::user()->ads_id) ? 'Edit Ad' : 'Attach Ad'}}
      		        </a>
                    @if(isset($user) && isset($user->pro_ads))
                        <a href="{{ route('romoveAdFromProProfile', $user->ads_id) }}" class="js-open-modal white-button">Remove Ad</a>
                    @endif
                </div>
            </div>
            <div class="col-md-12">
                <div class="profile-main-inner">
                    <div class="admin-content__stat stat-ad-banner" style="background-color:#f5f5f5;"> 
                        <?php
                            if(!empty(Auth::user()->ads_id)){ ?>
                                <img width="250" height="100" src="{{ asset('img-dist/ads/'.$user->pro_ads->image_url) }}" />
                            <?php }else{ ?>
                                <h4>There is no ad attached.</h4>
                            <?php }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </aside>
    <!-- Attached ads Popup -->
	<div class="modal-box" id="attachAdsPopUp" role="dialog">
  <header> <a href="#" class="js-modal-close close">×</a>
    <h3>Attach Ad to profile</h3>
  </header>

  <div class="modal-body">

    @if(count($ads))
      <p><small>Please select one of the Ads</small></p>
    @else
      <span class="no-ads"><span>There are no Ads in your account</span></span>
    @endif
    @if(count($ads))
      <form method="POST" action="{{ route('attachAdsToProfile') }}">
        <select name="attached_ads_id" id="add-change" style="width: 100%;">
          @foreach($ads as $ad)
            <?php
              $class =''; 
              if(Auth::user()->ads_id == $ad->id){
                $class = 'active';
              }
            ?>
            <option <?php if(Auth::user()->ads_id == $ad->id) { echo "selected"; }?> img-path="{{ $ad->image_url }}" value="{{$ad->id}}" class="{{ $class }}">{{$ad->name}} </option>
          @endforeach
        </select>
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

        
          <div class="add-img-preview">
            <small>Ad preview</small>
            <img  src="#" width="500" height="200">
          </div>
          <div class="attach-submit"><input type="submit" value="Attach Ad" ></div>
      </form>
    @endif

  </div>
  
@endsection
