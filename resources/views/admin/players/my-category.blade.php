@extends('layouts.game')
@section('content')
<main class="game-wrapper">
	<form method="POST" action="{{ route('my-category') }}">
    	{{ csrf_field() }}
	    @foreach ($categories as $category)
	    	<input <?php if(in_array($category->id, $catId)){ echo "checked"; } ?> class="my-category" type="checkbox" name="category[]" value="{{ $category->id }}">{{ $category->name }}
	    @endforeach
	</form>
</main>

@endsection