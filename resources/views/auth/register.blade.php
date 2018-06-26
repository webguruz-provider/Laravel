@extends('layouts.login')

@section('content')
    <form class="form-horizontal form login-form u-center-block" role="form" method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
           <!--<label for="name" class="col-md-4 control-label">Enter your name</label>-->

            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Enter your name">

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <!--<label for="email" class="col-md-4 control-label">Enter your email address</label>-->

            <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Enter your email address">

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <!--<label for="password" class="col-md-4 control-label">Enter your password</label>-->

            <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required placeholder="Enter your password">

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <!--<label for="password-confirm" class="col-md-4 control-label">Confirm your password</label>-->

            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Please confirm your password">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Register
                </button>
            </div>
        </div>
        <p class="field-description">Already have an account?  <a href="{{ route('login') }}">Sign in.</a></p>
    </form>

               
@endsection
