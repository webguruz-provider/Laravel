<div class="header2">
@extends('layouts.game')
</div>
@section('content')
<main class="game-wrapper">
<form class="form category-form u-center-block u-container" role="form" method="POST" action="{{route('update-my-category')}}">
    {{ csrf_field() }}
    <h2 class="login-form-title u-text-center">Select Your Categories</h2>
    <section class="onboarding-categories u-container">

	    @foreach ($categories as $category)
	    	<div class="onboarding-category <?php if(!in_array($category->id, $catId)) { echo "is-selected"; }?>" style="background-image: url({{ asset('img-dist/category/'.$category->image_url) }});">
	    		<span class="onboarding-category__name">
	    			{{ $category->name }}
	    		</span>
	    		<input name="category[]" type="checkbox" <?php if(in_array($category->id, $catId)) { echo 'checked'; }?>   value="{{ $category->id}}" class="onboarding-category__checkbox">
	    		<div class="onboading-category__screen"></div>
	    	</div>
	    @endforeach
	</section>
    <div class="field text-center">
        <button type="submit" class="btn btn-green btn-block">
            Update
        </button>
    </div>
</form>
</main>

@endsection