<div class="header2">
@extends('layouts.game')
</div>
@section('content')
<main class="game-wrapper">
	<div class="debate-preview u-background-white">
		<h2 class="title-head"></h2>
		<div class="dashboard-item">
			<div class="pick-sec">
				<img src="{{ asset('img-dist/category') }}/{{ $question->category->image_url }}" class="pick-image" alt=""> 
			</div>
	 		<div class="debate-preview__header text-center">
	        	<div class="debate-haeder-top">
	          		<h4 class="debate-preview__category text-center"> Submitted In <strong class="u-text-black"> {{ $question->category->name }}</strong></h4>
	          		<h5 class="debate-preview__category text-center"> Submitted By <strong class="u-text-black"> <a href="{{ route('publicPlayerShow', $question->getquestionAuther->handle ) }}">{{ $question->getquestionAuther->name }}</a></strong></h5>
	          	</div>
				
				<div class="multi-question-ads">
					@if($ads->ads_id >= 1)
						@if(isset($ads->ads))
						<a href="{{ $ads->ads->website_url }}"  target="_blank">
							<img src="{{ asset('/img-dist/ads/'.$ads->ads->image_url) }}">
						</a>
						@endif
					@else
						@if(isset($ads->category->ads))
							<a href="{{ $ads->ads->website_url }}"  target="_blank">
								<img src="{{ asset('/img-dist/ads/'.$ads->category->ads->image_url) }}">
							</a>
						@endif
					@endif
				</div>
				 
	          	<div>       
					<p class="debate-preview__question-text text-center">{{ $question->text }}</p>
				</div>
	          	<small class="debate-preview__question-source text-center <?=(empty($question->source))?'source-hidden':''?>"><i aria-hidden="true" class="fa fa-circle"></i> {{ $question->medium }} from <strong class="u-text-black">{{ $question->source }}</strong></small>
	        </div>
	 	</div>
	 	<form onsubmit="return checkServeyValidation()" name="pickaside" method="post" action="<?php if($question->answer_type == 1) {?> {{ route('multipleServeyAnswers') }} <?php }else{?> {{ route('singleServeyAnswers') }} <?php } ?>">
	 		<input type="hidden" name="question_id" value="{{ $question->id }}">
			<input type="hidden" name="servey_id" value="{{ $userServey->id }}">
			<input type="hidden" name="fingerprint_string" id="fingerprint_string" value="">
			 
		 	<div class="dashboard-item">
		 		<div class="agree-btn-content text-center">
					@if($question->answer_type == 1)
						<ul class="select-agree-btn survey-select-sec">
							@foreach($question->answer as $answer)
								<li>
									<input type="checkbox" id="t-option-{{$answer->id}}" class="servey-answers" name="answer_id[]" value="{{$answer->id}}">
									<label for="t-option-{{$answer->id}}">{{$answer->answer}}</label>    
									<div class="check"><div class="inside"></div></div>
								</li>
							@endforeach
							@if($question->allowed_other_answer == 1)
								<li>
									<input type="checkbox" id="option-other" name="other_answer" value="1">
									<label for="option-other">Other Answer</label>    
									<div class="check"><div class="inside"></div></div>
								</li>
								<input type="hidden" class="other-answer-text" name="other_answer_text">
							@endif
							<span style="color:red;" class="servey-form-error"></span>
						</ul>
					@else
						<ul class="select-agree-btn survey-select-sec2">
							@foreach($question->answer as $answer)
								<li>
									<input type="radio" id="t-option-{{$answer->id}}" class="servey-answers" name="answer_id" value="{{$answer->id}}">
									<label for="t-option-{{$answer->id}}">{{$answer->answer}}</label>    
									<div class="check"><div class="inside"></div></div>
								</li>
							@endforeach
							@if($question->allowed_other_answer == 1)
								<li>
									<input type="radio" id="option-other" name="other_answer" value="1">
									<label for="option-other">Other Answer</label>    
									<div class="check"><div class="inside"></div></div>
								</li>
								<input type="hidden" class="other-answer-text" name="other_answer_text">
							@endif
							<span style="color:red;" class="servey-form-error"></span>
						</ul>
					@endif
					<div class="select-agree-box">
						<input type="submit" class="agree-green" name="submit" value="Submit">
					</div>
		 		</div>
		 	</div>
		 </form>
	</div>
</main>

@endsection