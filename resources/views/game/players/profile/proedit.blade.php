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

            <form class="form-horizontal form login-form u-center-block" role="form" method="POST" action="{{ route('profile.update', Auth::user()->id) }}" enctype="multipart/form-data">
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
                    <label for="phone_number" class="col-md-4 control-label">Phone Number</label>

                    <div class="col-md-8">
                        <input id="phone_number" type="tel" class="form-control" name="phone_number" value="{{ Auth::user()->phone_number }}" required>

                        @if ($errors->has('phone_number'))
                            <span class="help-block">
                                <strong>{{ $errors->first('phone_number') }}</strong>
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
@endsection
