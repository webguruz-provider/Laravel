@foreach($serveyQuestions as $question)
@if($question->category->status=="live")
    <div class="dashboard-item">
	    <div class="debate-preview u-background-white">
	    	<div class="debate-preview__header">
	        	<div class="debate-haeder-top">
	          		<h4 class="debate-preview__category"> Submitted In <strong class="u-text-black">
	          		{{ $question->category->name }}
	          		</strong></h4>
	          		<h5 class="debate-preview__category"> Submitted By <strong class="u-text-black">
	          		<a href="{{ route('publicPlayerShow', $question->getquestionAuther->handle) }}">{{ $question->getquestionAuther->name }}</a>
	          		</strong></h5>

	          	</div>
				<p class="debate-preview__question-text">{{ $question->text }}</p>

	          	<small class="debate-preview__question-source <?=(empty($question->source))?'source-hidden':''?>">
	          		<i class="fa fa-circle" aria-hidden="true"></i> 
	          		{{ $question->medium }} from 
	          		<strong class="u-text-black">{{ $question->source }}</strong>
				  </small>
                  <div class="debate-btn-box">
						<a class="debate-btn" href="{{ route('pickServeyAnswer').'?question_id='.$question->id }}">Submit Answer</a>
					</div>
				<!-- @if($question->question_type == 1)
					<div class="debate-btn-box">
						<a class="debate-btn" href="{{ route('pickServeyAnswer').'?question_id='.$question->id }}">Start Servey</a>
					</div>
				@else
					<div class="debate-btn-box">
						<a class="debate-btn" href="{{ url('debates/pickaside') }}?question_id={{$question->id}}">Start Debate</a>
					</div>
				@endif      -->
	        </div>
	    </div>
	</div>
	@endif
@endforeach