@if(count($ads) > 0)
		<div class="flexslider">
		  <ul class="slides">

		    @foreach($ads as $ad)
		    @if($ad->status=='live')            
		    <li>
		      <!-- <a href="{{ route('publicAdsClick', $ad->id) }}" target="_blank"><img class="lazy" data-original="{{ route('publicAdsImpression', $ad->id) }}" /></a> -->
		       <a href="{{ route('publicAdsClick', $ad->id) }}" target="_blank"><img src="{{ asset('img-dist/ads') }}/{{$ad->image_url}}" /></a>
		    </li>
		    @endif
		    @endforeach
		  </ul>
		</div>
@endif