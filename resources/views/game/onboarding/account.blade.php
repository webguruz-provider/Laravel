@extends('layouts.login')

@section('content')

<form class="form login-form u-center-block" role="form" method="POST" action="{{ route('onboardingAccountStore') }}">
    {{ csrf_field() }}

    <h2 class="login-form-title u-text-center">
    	Finish Creating Your Account
    </h2>

    <div class="field">
		<input type="text" class="form-control" name="handle" placeholder="Choose a Handle" value="{{ old('handle', $user->handle) }}" required autofocus>
        @if ($errors->has('handle'))
            <span class="help-block">
                <strong>{{ $errors->first('handle') }}</strong>
            </span>
        @endif
    </div>

    <div class="field">
        <input type="email" class="form-control" name="email" placeholder="Enter your email address" value="{{ old('email', $user->email) }}" required>
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>

    <div class="field">
		<input type="tel" class="form-control" name="pn" placeholder="Add your mobile phone (Optional)" value="{{ old('pn', $user->phone_number) }}" data-format="phone">
        @if ($errors->has('pn'))
            <span class="help-block">
                <strong>{{ $errors->first('pn') }}</strong>
            </span>
        @endif
    </div>

    <div class="field">
        <button type="submit" class="btn btn-green btn-block">
            Create Your Account
        </button>

        <p class="field-description">
            <a href="{{ route('login') }}">
                Already have an account? Try signing in again.
            </a>
        </p>
       <!-- 
        <p class="field-description">
            <a href="{{ route('login') }}" onclick="event.preventDefault();
            	document.getElementById('logout-form').submit();">
                Already have an account? Try signing in again.
            </a>
        </p> -->
    </div>
</form>

<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>

@endsection
