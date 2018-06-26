<div class="header2">
@extends('layouts.game')
</div>
@section('content')

<main class="game-wrapper">

	<div class="debate-preview u-background-white">
		<h2 class="title-head">Pick a Side</h2>
		<div class="dashboard-item">
			<div class="pick-sec">
				<img src="{{ asset('img-dist/category') }}/{{ $question->category->image_url }}" class="pick-image" alt=""> 
			</div>
	 		<div class="debate-preview__header text-center">
	        	<div class="debate-haeder-top">
	          		<h4 class="debate-preview__category text-center"> Submitted In <strong class="u-text-black"> {{ $question->category->name }}</strong></h4>
	          		<h5 class="debate-preview__category text-center"> Submitted By <strong class="u-text-black"> <a href="{{ route('publicPlayerShow', $question->getquestionAuther->handle ) }}">{{ $question->getquestionAuther->name }}</a></strong></h5>
	          	</div>
	          	<div>       
					<p class="debate-preview__question-text text-center">{{ $question->text }}</p>
				</div>
	          	<small class="debate-preview__question-source text-center <?=(empty($question->source))?'source-hidden':''?>"><i aria-hidden="true" class="fa fa-circle"></i> {{ $question->medium }} from <strong class="u-text-black">{{ $question->source }}</strong></small>
	        </div>
	 	</div>
	 	<form name="pickaside" method="post" action="{{ route('publicDebateStore') }}">
	 		<input type="hidden" name="question_id" value="{{ $question->id }}">
		 	<div class="dashboard-item">
		 		<div class="agree-btn-content text-center">
		 			<!--<input type="submit" class="agree-green" name="submit" value="Agree">
		  			<input type="submit" class="agree-blue" name="submit" value="Disagree">-->
                    <ul class="select-agree-btn">
					  <li>
					    <input type="radio" id="f-option" name="side" value="Agree">
					    <label for="f-option">Agree</label>    
					    <div class="check"></div>
					    <input type="hidden" name="fingerprint_string" id="fingerprint_string" value="">
					  </li>  
					  <li>
					    <input type="radio" id="t-option" name="side" value="Disagree">
					    <label for="t-option">Disagree</label>    
					    <div class="check"><div class="inside"></div></div>
					  </li>
					</ul>
					<div class="form-group{{ $errors->has('side') ? ' has-error' : '' }}">
						@if ($errors->has('side'))
	                    <span class="help-block">
	                        <strong>{{ $errors->first('side') }}</strong>
	                    </span>
	                	@endif
	                </div>


					<div class="select-agree-box">
						<div class="form-group{{ $errors->has('argument') ? ' has-error' : '' }}">

							
							<textarea id="debate-arg-textbox" name="argument" rows="8" placeholder="What do you think?">{{ old('argument') }}</textarea>
							
							@if ($errors->has('argument'))
                            <span class="help-block">
                                <strong>{{ $errors->first('argument') }}</strong>
                            </span>
                        	@endif

						</div>
						<input type="submit" class="agree-green" name="submit" value="Publish">
					</div>

		  			<!-- <p>Youʼll be able to explain why next.</p> -->
		 		</div>
		 	</div>
		 </form>
	</div>
</main>

@endsection