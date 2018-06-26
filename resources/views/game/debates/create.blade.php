@extends('layouts.debate')

@section('content')
<main class="game-wrapper">
    <h2 class="title-head">Pick a Question</h2>
    <p class="title-caption">Select one question youʼd like to debate and then hit next.</p>
    
    <form name="select_question" method="get" action="{{ route('pickaside') }}">

    <div class="tab-section">
      <ul class="nav nav-tabs" id="nav-tabs">
          <li class="active"><a data-toggle="tab" href="#recent_container" onclick="window.location.hash = ''">Most Recent</a></li>
          <li><a data-toggle="tab" href="#category_container" id="cat-tab">By Category</a></li>
      </ul>

      <div class="tab-content">
          <input type="hidden" name="question_id" id="question_id">

          <!-- tab 1 (Recent questions)-->
          <div id="recent_container" class="tab-pane fade in active">

            <!-- one row -->
            @foreach($questions as $question)
			@if($question->category->status == 'live')
            <div class="dashboard-item questions">
              <div class="question_id" ques-id="{{ $question->id }}"></div>
              <div class="debate-preview u-background-white">
                <div class="debate-preview__header">

                  <div class="debate-haeder-top">
                    <h4 class="debate-preview__category"> Submitted In <strong class="u-text-black">{{ $question->category->name }}</strong></h4>
					<h5 class="debate-preview__category"> Submitted By <strong class="u-text-black"><a href="{{ route('publicPlayerShow', $question->getquestionAuther->handle) }}">{{ $question->getquestionAuther->name }}</a></strong></h5>
                  </div>

                  <p class="debate-preview__question-text">
                    {{ $question->text }}
                  </p>
                  <small class="debate-preview__question-source <?=(empty($question->source))?'source-hidden':''?>">
                    Source from <strong class="u-text-black"><a href="{{ $question->source_url }}" target="_blank">{{ $question->source }}</a></strong>
                  </small>
                </div>

                <div class="debate-btn-box"></div>
                
              </div>
            </div>
            <!-- one row -->
			@endif
            @endforeach

          </div>

          <!-- tab 2 (By Category)-->
          <div id="category_container" class="tab-pane fade">
            <section class="onboarding-categories u-container" id="category-listing">
              
              @foreach($categories as $category)
              <div style="background-image: url(&quot;{{ asset('img-dist/category/'.$category->image_url) }}&quot;);" class="onboarding-category">
                  <span class="onboarding-category__name" data-cat-id="{{ $category->id }}">{{ $category->name }}</span>
                  <!-- <input type="hidden"  value="{{ $category->id }}" name="category_name"  class="category_name"> -->
                  <div class="onboading-category__screen"></div>
              </div>
              @endforeach
            </section>
            <div id="category-ads">

            </div>
            <section id="category-wise-questions">
            </section>
          </div>

          <!-- <div class="nxt-btn"><input class="debate-btn disabled" type="submit" Value ="Next" disabled="disabled"></div> -->
          
        </div>
      </div>
    </form>
</main>
@endsection