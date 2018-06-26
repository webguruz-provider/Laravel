<div class="header2">
@extends('layouts.game')
</div>
@section('content')
<main class="game-wrapper">
	<div class="debate-preview u-background-white thx-content">
		<div class="dashboard-item">
	 		<div class="debate-preview__header text-center">
             <h2>Thank you for submitting  your choice.</h2>
	        </div>
			<div class="border-head thx-link">
			<a href="{{ url('feed') }}">Back to Feed</a>
			</div>
	 	</div>
	</div>
</main>

@endsection