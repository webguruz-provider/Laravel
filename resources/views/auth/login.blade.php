@extends('layouts.login')

@section('content')

<form class="form login-form u-center-block" role="form" method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}

    <div class="field">
        <input id="email" type="email" class="form-control" name="email" placeholder="Enter Your Email" value="{{ old('email') }}" required autofocus>
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>

    <div class="field">
        <input id="password" type="password" class="form-control" placeholder="Enter Your Password"  name="password" required>
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>

    <input type="hidden" name="remember" checked>

    <div class="field">
        <button type="submit" class="btn btn-green btn-block">
            Login
        </button>
        <p class="field-description">
            Forgot your login details?
            <a href="{{ route('password.request') }}">
                Get help signing in
            </a>
        </p>
    </div>


    <a href="/facebook/redirect" class="btn btn-facebook btn-social btn-block">
        Login with Facebook
    </a>
    <!-- <a href="/twitter/redirect" class="btn btn-twitter btn-social btn-block">
        Login with Twitter
    </a>
    <a href="/google/redirect" class="btn btn-google btn-social btn-block">
        Login with Google
    </a> -->

</form>

<p class="field-description">
    Don’t have an account? 
    <a href="{{ route('register') }}">
        Sign up.
    </a>
</p>






@endsection
