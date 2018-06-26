@extends('layouts.game')
<script>
  
  


</script>
@section('content')


<main class="game-wrapper contest-sec-new">
  <section class="player-profile">
    <ul>
      @if(count($contests) > 0)
        @foreach($contests as $contest)
        <li>
            <span><a href="{{ $contest->website_url }}" target="_blank"><img src="{{ asset('img-dist/contests/'.$contest->image_url)}}"></a></span>
            <span><a href="{{ $contest->website_url }}" target="_blank">{{ $contest->name }}</a></span>
            <span>

              @if(strlen($contest->description) > 200 )
                
                <div class="show-more">
                  {{ substr($contest->description ,0, 200) }}
                  <a href="#" class="show-more-link">...Show more</a>
                </div>


                <div class="show-less"  style="display: none">
                  {{ $contest->description }}
                  <a href="#" class="show-more-link">Show less</a>
                </div>
                
              @else
                {{ $contest->description }}

              @endif
            </span>
        </li>
        @endforeach

        @else
        <li><h1>No contest right now.</h1></li>
        @endif
    </ul>
  </section>
</main>

@endsection