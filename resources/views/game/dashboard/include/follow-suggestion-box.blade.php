<div class="debate-preview__header">
	<div class="debate-haeder-top">
			<h4 class="debate-preview__category">Other Siders to Follow</h4>
			<div class="loader-bgg" style="display:none">
        <div class="loader"></div>
    </div>
			
		</div>       
</div>
<div class="follow-player-sec">	
	@foreach($follow_suggestions as $suggestion)
	@if(!empty($suggestion->handle) && $suggestion->is_admin==0)	
	<div class="debate-preview__players follow-players">
		<div class="debate-follow-img"><img src="{{ asset('images') }}/{{ $suggestion->avatar_url }}" width="128" height="128" alt=""></div>
			<div class="debate-follow-name">
				<h4 class="debate-preview__player-name"><a href="{{ route('publicPlayerShow', $suggestion->handle ) }}" class="u-link-black">{{ $suggestion->name }}</a></h4>
  			<small> {{ $suggestion->handle }} </small>
  		</div>
   		<div class="debate-follow-btn">
				<button class="follow-btn" value="{{ $suggestion->id }}">Follow</button>
			</div>
		</div>
		@endif
	@endforeach
	@if(empty($follow_suggestions))
		<h4 class="text-center">There are no more users to follow.</h4>
	<div class="debate-preview__players follow-players">
		<a href="#" class="primary-nav__dropdown-link u-link-black" data-toggle="modal" data-target="#inviteFriends">
                                    Invite Friends
                                </a>
                            </div>
	@endif

	<!-- <div class="load-more">
		<button onclick="load_more_suggestions()">Load more</button>
	</div> -->

	
</div>