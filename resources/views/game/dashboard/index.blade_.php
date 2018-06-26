<div class="header2">
@extends('layouts.game')
</div>
@section('content')

 @if (Session::has('message'))
    <div class="flash-msg">{{ Session::get('message') }}</div>
  @endif
   	<main class="game-wrapper voter-img">

   		@if (!Session::has('sharebox'))

   		<div class="marginb game-wrapper new-share-main">
			<div class="new-share-sec">
	   			<div class="share-head">
	   				<h4 class="u-white-text">Welcome to Sided</h4>
		   			<a href="#" class="share-close"><i class="fa fa-times" aria-hidden="true"></i></a>
		   		</div>
		   		<p class="debate-preview__question-text">
		   			Every Story has two sides.<br>
			   		Pick a question, take a side, and win stuff.
			   </p>
		   		<span>Learn more about points and status.</span>
			</div>
		</div>
		@endif

		<!-- prousers list -->
		<div class="dashboard-item">
			@include('game.dashboard.include.prousers')
		</div>
		<!-- prousers list end-->

		<!-- suggested questions -->
	    @if($questions->count() > 0 )
	    	@include('game.dashboard.include.suggested_ques')
	    @endif
	    <!-- / suggested questions -->

	    
	    <div class="game-main debate-single">
			<?php $num_debates = $debates->count(); ?>
			@if($debates->count() > 0)
		
				<?php $i=0; ?>
				@foreach ($debates as $debate)
					

					@if($debate->status == 'needs_opponent' || $debate->status == 'active')
				    <div class="dashboard-item user-detial-bottom" data-debate="{{$debate->id}}">
				    	@include('game.debates.partials._debate-'.$debate->status)
				    </div>
				    @endif
				    
				    @if($i == 2)
			        	@include('game.dashboard.include.invite')
			        	<div class="upper-ad-box">
			        		@include('game.dashboard.include.ads-slider')
			        	</div>
				    @endif


				    @if($i == 6)
				    	@include('game.dashboard.include.category-box')

				    	<div class="lower-ad-box">
					    	@include('game.dashboard.include.ads-slider')
					    </div>

				    @endif

				    <?php $i++; ?>
				@endforeach
			@endif
		</div>



		@if($num_debates < 3)
			@include('game.dashboard.include.invite')
			<div class="upper-ad-box">
				@include('game.dashboard.include.ads-slider')
			</div>
	    @endif



	    @if($num_debates < 7)
			@include('game.dashboard.include.category-box')
		    <div class="lower-ad-box">
		    	@include('game.dashboard.include.ads-slider')
		    </div>
	    @endif



		<div class="dashboard-item">
		      <div class="debate-preview u-background-white">
		      	@include('game.dashboard.include.follow-suggestion-box')
		    </div>
      	</div>
		
	</main>
    
@endsection
