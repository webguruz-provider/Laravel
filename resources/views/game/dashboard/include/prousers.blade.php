
<div class="debate-preview u-background-white">
	<div class="debate-preview__header">
			<h4 class="debate-preview__category">Active Now <strong class="u-text-black">({{ count($active_users_online) }})</strong></h4>
			<div class="active-main">
			<ul class="active-list ">
	  			@foreach($active_users as $active)
	          	<li @if($active->go_online=="true") class="pro_online" @else class="pro_offline" @endif>
	          		<a href="{{ route('publicPlayerShow', $active->handle ) }}">
	          			<img src="{{ asset('images') }}/{{ $active->avatar_url }}" alt="">
	          			<p>{{ $active->name }}</p>
	            		<span></span>
	            	</a>
	            </li>
	    		@endforeach

	    		@if(count($active_users) < 6 )
	    			@for($i=count($active_users); $i < 6; $i++)
	    				<li class="deactivate_proprofile">
		              		<img src="{{ asset('images') }}/demo_pro.jpg" alt="">
		                	<span></span>
		                </li>
		            @endfor
	    		@endif
			</ul>
			</div>
	</div>
</div>
