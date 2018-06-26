@extends('layouts.login')
@section('content')
<div class="create-account">
<form class="form category-form u-center-block u-container" role="form" method="POST" action="{{ route('onboardingCategoryCreate') }}">
    {{ csrf_field() }}

    <h2 class="login-form-title u-text-center">
    	Now Select Your Categories
    </h2>
    <p class="login-form-desc u-text-center">
    	Tell us what you're interested in
    </p>

    <section class="onboarding-categories u-container">
	    @foreach ($categories as $category)
	    	<div class="onboarding-category" style="background-image: url({{ asset('img-dist/category/'.$category->image_url) }});">
	    		<span class="onboarding-category__name">
	    			{{ $category->name }}
	    		</span>
	    		<input name="category[]" type="checkbox" value="{{ $category->id}}" class="onboarding-category__checkbox">
	    		<div class="onboading-category__screen"></div>
	    	</div>
	    @endforeach
	</section>
    
    <div class="field">
        <button type="submit" class="btn btn-green btn-block">
            Create Your Account
        </button>
    </div>
</form>
</div>
<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
@endsection

