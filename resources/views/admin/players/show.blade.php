@extends('layouts.game')
@section('content')

@if($errors->any())
	<div class="flash-msg">
		<h4>{{ $errors->first() }}</h4>
	</div>	
@endif

<main class="game-wrapper">
	<section class="player-profile">
		<header class="player-profile__header u-text-center" >

			

			<div class="pick-sec">
				<div class="following-sec">
					<input type="hidden" name="event_type" id="event_type" value="profile_view">
                    <input type="hidden" name="event_id" id="event_id" value="{{ $user->id }}">

		  			@if(!empty(auth()->user()->name) && auth()->user()->id != $user->id)
						<form method="POST" action="{{ $action }}">
							@if($method == 'PUT')
		                        {{ method_field('PUT') }}
		                    @endif
							<input type="hidden" name="user_id" value="{{ $user->id }}">
							<input type="hidden" name="status" value="{{ $status }}">
							<button name="follow" value="follow" class="following-btn" type="submit" style="height: 26px; width: 26%;">{{ $btn_text }}</button>
						</form>

						<div class="challenge-sec">
						   <button class="challenge-btn" type="button" data-toggle="modal" data-target="#myModal">Challenge</button>    
						</div>
					@endif

					@if(!empty(auth()->user()->name) && auth()->user()->id == $user->id)
						<!-- <div class="following-sec"> -->
						   <div>
						   	<a class="challenge-btn" href="{{ route('profile.edit', auth()->user()->id ) }}">Update Profile</a>
						   </div>
						   <a class="challenge-btn" href="{{ route('my-category') }}">Update Category</a>
						<!-- </div> -->

					@endif
					@if($user->is_admin==1)
					


					<div class="feedback-sec"><button class="challenge-btn" type="button" data-toggle="modal" data-target="#openPopUp">Feedback</button> </div>
					<!-- <div class="contest-sec">
						<a href="{{ route('publicPlayerContest', $user->id) }}">View Contest</a>
					</div> -->

					


					@endif
  				</div>


  					
<div class="make-main">
   				@if(!empty(auth()->user()->name) && auth()->user()->id != $user->id)
   				<div class="make-favorite" title="" data-user="{{ $user->id }}">
   					@if($is_favourite == '1')
		  				<img src="/img/favorite-heart-button-red.svg" class="fav-active">
		   			@else
   						<img src="/img/favorite-heart-button.svg" class="fav-active">
   					@endif	   				
   				</div>
   				@endif
   			


	  			@if($user->avatar_url =='')
					<img class="player-profile__header-avatar pick-image" src="{{ asset('images') }}/user_icon.png" alt="{{ $user->name}}" height="200px">
				@else
					<img class="player-profile__header-avatar pick-image" src="{{ asset('images') }}/{{ $user->avatar_url }}" alt="{{ $user->name}}" height="200px">
				@endif
</div>


				<div class="dropdown profile-name">
					<h2 class="player-profile__header-name">{{ $user->name }}</h2>
				</div>
			</div>
			<span class="player-profile__header-meta title-caption">
				{{ $user->handle }}
				|
				{{ $user->rank }}

				<?php 
				/*$fingerprints = $user->fingerprints()->get();

				foreach($fingerprints as $fingerprint){
					$obj_fingerprint = new App\Fingerprint;
					$user_points = $obj_fingerprint->user_points()->get();

					print_r(json_decode(json_encode($user_points)));
				}
				*/

				//$total_point = "0";

				/*
				$points = $user->points()->get();
				//echo "<pre>";
				//print_r(json_decode(json_encode($points)));
				//echo "</pre>";

				$total_point = "0";
				foreach($points as $point){
					//$point->points = $point->points + $point->points;
					 $total_point = $total_point+$point->points;
					//echo "<pre>";
					//print_r(json_decode(json_encode($point)));
					//echo "</pre>";					
				}
				*/
				?>

			</span>


			<div class="player-profile__header-stats">
				<div class="profile-detial">
					<ul>
						<li>		
	
						<div class="player-profile__header-stat">
							<p><div class="header-stat__number">{{ $follower_count }}</div></p>
						<h4><div class="header-stat__label">Followers</div></h4>
						</div><!-- /header-stat-->
						</li>
						<li>
						<div class="player-profile__header-stat">
							<p><div class="header-stat__number">{{ $total_points }}</div></p>
						<h4><div class="header-stat__label">Points</div></h4>
						</div><!-- /header-stat-->
						</li>
						<li>
						<div class="player-profile__header-stat">
							<p><div class="header-stat__number">{{ $user->categories()->count() }}</div></p>
						<h4><div class="header-stat__label">Categories</div></h4>
						</div><!-- /header-stat-->
						</li>
					</ul>
				</div>
				
			</div>
		</header>

		<div class="profile-tab">
 			<ul class="player-profile__tabs nav nav-tabs">
				<li class="player-profile__tab active">
					<a data-toggle="tab" href="#tab1">
						<svg width="11" height="18" viewBox="0 0 11 18" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><path id="a" d="M0 17.088V.208h10.995v16.88z"/></defs><g fill="none" fill-rule="evenodd"><mask id="b" fill="#fff"><use xlink:href="#a"/></mask><path d="M3.945 7.442l1.77-6.45S5.886.38 5.38.233c-.444-.127-.674.264-.725.369l-4.56 9.26c-.104.237-.37 1.029.934.969l5.658-.263-2.059 5.811c0-.003-.106.372.289.627.396.251.8-.156.804-.161l5.065-8.613c.623-1.058-.31-1.102-.554-1.094l-6.286.304z" id="changecolor" fill="#8E8E93" mask="url(#b)"/></g></svg>
					</a>
				</li>
				<li class="player-profile__tab">
					<a data-toggle="tab" href="#tab2">
						<svg width="18" height="15" viewBox="0 0 18 15" xmlns="http://www.w3.org/2000/svg"><path d="M14.059 1l2.831 1.923c-1.656 2.261-2.51 4.7-2.564 7.317v3.631H9.412v-3.097c0-1.816.432-3.613 1.296-5.394.863-1.78 1.98-3.24 3.35-4.38zM5.647 1l2.83 1.923c-1.655 2.261-2.51 4.7-2.563 7.317v3.631H1v-3.097c0-1.816.432-3.613 1.295-5.394C3.159 3.6 4.275 2.14 5.647 1z" stroke="#8E8E93" id="changecolor" stroke-width="1.14" fill="none"/></svg>
					</a>
				</li>
				<li class="player-profile__tab">
					<a data-toggle="tab" href="#tab3">
						<svg width="20" height="15" viewBox="0 0 20 15" xmlns="http://www.w3.org/2000/svg"><path d="M0 14.276h4.112v-9.13H0v9.13zm1.034-1.035h2.043V6.155H1.034v7.086zm4.086 1.035h4.112V0H5.121v14.276zm1.035-1.035h2.043V1.034H6.155V13.24zm4.113 1.035h4.111V4.112h-4.111v10.164zm1.033-1.008h2.044V5.147H11.3v8.12zm4.087 1.008H19.5V2.069h-4.112v12.207zm1.034-1.035h2.044V3.078h-2.044V13.24z" id="changecolor" fill="#8E8E93" fill-rule="evenodd"/></svg>
					</a>
				</li>

				@if($user->is_admin == 1)
				<li class="player-profile__tab">
					<a data-toggle="tab" href="#tab4">
						<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="20px" height="20px" viewBox="0 0 11 11" enable-background="new 0 0 11 11" xml:space="preserve">
<g>
	<path fill="#8E8E93" id="changecolor" d="M5.667,5.705c-1.028,0-1.865,0.836-1.865,1.864c0,1.029,0.836,1.865,1.865,1.865
		c1.029,0,1.865-0.837,1.865-1.865S6.695,5.705,5.667,5.705z M5.667,8.707c-0.627,0-1.137-0.511-1.137-1.138s0.51-1.138,1.137-1.138
		c0.627,0,1.137,0.511,1.137,1.138S6.294,8.707,5.667,8.707z"/>
	<path fill="#8E8E93" id="changecolor" d="M10.708,0.195C10.646,0.075,10.521,0,10.386,0H7.468c-0.119,0-0.23,0.059-0.299,0.156L5.667,2.321
		L4.164,0.156C4.096,0.059,3.984,0,3.865,0H0.948c-0.135,0-0.26,0.075-0.322,0.195C0.563,0.315,0.572,0.46,0.649,0.571l2.54,3.659
		C3.056,4.285,2.962,4.415,2.962,4.567c0,0.201,0.163,0.364,0.364,0.364h0.253C2.8,5.549,2.3,6.502,2.3,7.569
		c0,1.856,1.51,3.366,3.366,3.366s3.367-1.51,3.367-3.366c0-1.067-0.5-2.021-1.278-2.638h0.253c0.201,0,0.363-0.163,0.363-0.364
		c0-0.152-0.094-0.283-0.227-0.337l2.54-3.659C10.762,0.46,10.771,0.315,10.708,0.195z M3.675,0.728l1.549,2.231L4.36,4.204H4.056
		L1.644,0.728H3.675z M8.305,7.569c0,1.455-1.184,2.639-2.638,2.639S3.028,9.024,3.028,7.569c0-1.454,1.184-2.638,2.638-2.638
		S8.305,6.115,8.305,7.569z M7.277,4.204H5.246l2.412-3.476H9.69L7.277,4.204z"/>
</g>
</svg>
						<!-- <svg width="20" height="15" viewBox="0 0 20 15" xmlns="http://www.w3.org/2000/svg"><path d="M0 14.276h4.112v-9.13H0v9.13zm1.034-1.035h2.043V6.155H1.034v7.086zm4.086 1.035h4.112V0H5.121v14.276zm1.035-1.035h2.043V1.034H6.155V13.24zm4.113 1.035h4.111V4.112h-4.111v10.164zm1.033-1.008h2.044V5.147H11.3v8.12zm4.087 1.008H19.5V2.069h-4.112v12.207zm1.034-1.035h2.044V3.078h-2.044V13.24z" id="changecolor" fill="#8E8E93" fill-rule="evenodd"/></svg> -->
					</a>
				</li>
				@endif


			</ul>
		  	

		  	<div class="tab-content"> 
				<div id="tab1" class="tab-pane fade in active player-profile__tab-content">
					<?php $i=0;?>
					@if(is_object($debates) && !empty($debates))
						@foreach($debates as $debate)
							@if($debate->status=="active")
								<div class="dashboard-item user-detial-bottom" data-debate="{{$debate->id}}">
									@include('game.debates.partials._debate-' . $debate->status)
								</div>
								<?php $i++; ?>
							@endif

						@endforeach
					@endif

					@if($i=='0')
						<h3 class="h3-title empty-title"><span>There are no Live Debates.<span></h3>
					@endif
					<?php unset($i); ?>
				</div>


				<div id="tab2" class="tab-pane fade in player-profile__tab-content">
					<?php $i=0;?>
					@if(is_object($debates) && !empty($debates))
						@foreach($debates as $debate)
							<div class="dashboard-item" data-debate="{{$debate->id}}">
						    	@include('game.debates.partials._debate-'.$debate->status)
						    	<?php $i++; ?>
						    </div>
						@endforeach					
					@endif
					@if($i=='0')
						<h3 class="h3-title empty-title"><span>There are no Past Debates.</span></h3>
					@endif
					<?php unset($i); ?>

				</div>



				<div id="tab3" class="tab-pane fade in player-profile__tab-content new-cat-tab">
					<div class="point-sec">

						@if(isset($userpoints) && count($userpoints)>0)
						<h3 class="h3-title">Points Breakdown</h3>
						<ul>							
							@foreach($userpoints as $static_points)
							
								<li><span>{{ date('F', mktime(0, 0, 0, $static_points->m, 10)) }} {{ $static_points->y }}</span><span>{{ $static_points->p }} points </span></li>
							@endforeach
						</ul>
						@else
							<h3 class="h3-title empty-title"><span>No Points recorded yet.</span></h3>
							

						@endif	

					</div>
				</div>

				@if($user->is_admin == 1)
				<div id="tab4" class="tab-pane fade in player-profile__tab-content">
					<div class="point-sec">
						

						
					      @if(count($contests) > 0)
					      	
					      	<ul>
						        @foreach($contests as $contest)
						        <li>
						            <span><a href="{{ $contest->website_url }}" target="_blank"><img src="{{ asset('img-dist/contests/'.$contest->image_url)}}"></a></span>
						            <span>

						            	<!-- <a href="{{ $contest->website_url }}" target="_blank">{{ $contest->name }}</a> -->
						            	
						            	<a href="{{ route('publicContestClick', $contest->id) }}" target="_blank">{{ $contest->name }}</a>


						            </span>
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
					    	</ul>
					        @else
					        
					        	<h3 class="h3-title empty-title"><span>There are no Contests.</span></h3>

					        @endif
					</div>
				</div>
				@endif



			</div>
		</div>

		<!-- POPUP option -->

		<div class="modal fade" id="openPopUp" role="dialog">
	
          <div class="modal-dialog">    
				<div class="modal-header">
				<button type="button" data-dismiss="modal" class="btn-default"><i aria-hidden="true" class="fa fa-times"></i></button>
				</div>
                <div class="modal-content question-form tab-section">
				       <h4 class="modal-title" style="text-align:center;">Got a question or feedback</h4>
          <p style="text-align:center;">If you have feedback on the show or a question you'd like to see debated, tell us below</p>
						   <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#suggest-tab1">Propose a Question</a></li>
          <li><a data-toggle="tab" href="#suggest-tab2">Offer Feedback</a></li>
        </ul>
		<div class="tab-content">
		 <div id="suggest-tab1" class="tab-pane fade in active">
          <div class="sided-net-content">
             <h4 class="modal-title">Offer Scott & BR Feedback</h4>
              <div class="email-address-form">
                <form name="invite_email" action="/players/proposequestionemail/{{$user->email}}" method="post">
                  <div class="dashboard-item">
                    <!-- <input type="text" placeholder="The Scott & BR Show" name="email[]"> -->
                    <input type="text" placeholder="Question Category" name="category">
                    <input type="hidden" name="pro_email" value="{{$user->email}}">
					<input type="hidden" name="pro_user" value="{{$user->name}}">
					<input type="hidden" name="user_name" value="{{ auth()->user()->name }}">
                    <textarea placeholder="Enter your Question..." name="question_text"></textarea>
                  </div>
                
				<div class="modal-footer">
                    <input type="submit" value="Send Feedback" class="green-btn">
                    <div>
                      <p data-dismiss="modal" class="inner-cancel">or Cancel</p>
                    </div>
                  </div>
				  </form>
              </div> 
            </div>
              </div>
 <div id="suggest-tab2" class="tab-pane fade">
          <div class="sided-net-content">
              <h4 class="modal-title">Offer Scott & BR Feedback</h4>
              <div class="email-address-form">
                <form name="invite_email" action="/players/offerfeedbackemail/{{$user->email}}" method="post">
                  <div class="dashboard-item">
                  <input type="text" value="{{ auth()->user()->name }}" name="user_name">
                  <input type="hidden" name="pro_email" value="{{$user->email}}">
				  <input type="hidden" name="user_name" value="{{ auth()->user()->name }}">
				  <input type="hidden" name="pro_user" value="{{$user->name}}">
                    <input type="text" placeholder="Subject" name="subject">
                    <textarea placeholder="Enter your feedback..." name="feedback_text"></textarea>
                  </div>                  
                
				<div class="modal-footer">
                    <input type="submit" value="Send Feedback" class="green-btn">
                    <div>
                      <p data-dismiss="modal" class="inner-cancel">or Cancel</p>
                    </div>
                  </div>
				  </form>
              </div>
            </div>
              </div>			  
		</div>

                </div>
            </div>
        </div>



        <div class="modal fade new-contest" id="openContest" role="dialog">
        	<div class="modal-dialog">    
				<div class="modal-header">
					<button type="button" data-dismiss="modal" class="btn-default"><i aria-hidden="true" class="fa fa-times"></i></button>
				</div>
                <div class="modal-content question-form tab-section">
			       	<h4 class="modal-title" style="text-align:center;">Contest list</h4>
      				<p style="text-align:center;">description</p>

      				<?php $contests = App\Contest::where('publish_at', '<=', Carbon\Carbon::now())->where([['expire_at', '>=', Carbon\Carbon::now()], ['partner_id', '=', $user->id], ['status', '!=', 'draft'],])->where('status', '!=', 'deactive')->get(); ?>
      				<ul>
	      				@foreach($contests as $contest)
	      				<li><a href="{{ $contest->website_url }}" target="_blank">{{ $contest->name }}</a></li>
	      				
	      				@endforeach
	      			</ul>

                </div>
            </div>
        </div>
	</section>

	@if(!empty(auth()->user()->name))
	<div class="modal fade" id="myModal" role="dialog">
	 	<div class="modal-dialog">  
	 		<form method="POST" action="{{ route('challengeForDebate') }}">  
      			<!-- Modal content-->
      			<div class="modal-content">
	        		<div class="modal-header">
	                	<button type="button" class="btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
	          			<!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
	          		</div>
	        		<div class="modal-body">
	        			<h4 class="modal-title">Challenge {{ $user->name }}</h4>
	          			<p>Choose a Debate and Challenge.</p>
	          			<div>
	          				<?php $debates = (new \App\Helpers\Points)->get_debates(); ?>
	          				
	          				@if(count($debates) > 0)
		          			<select name="debate_id" class="dropdown">
		          				@foreach($debates as $debate)
		          					<option value="{{ $debate->debate_id }}">{{ (new \App\Helpers\Points)->get_question($debate->question_id)->text }}</option>
		          				@endforeach
		          			</select>
		          			@else
		          				<h4>You have no debate which need opponent</h4>
		          				<small><a href="{{  route('publicDebateCreate')  }}" class="agree-blue">Create new debate</a></small>
		          			@endif
		          		</div>

	        		</div>
	        		<div class="modal-footer">
	        			<input type="hidden" name="invite[]" value="{{ $user->id }}">
						<input type="hidden" name="challenger_name" value="{{ Auth::user()->name }}">
				  <input type="hidden" name="take_a_dare_name" value="{{ $user->name }}">
	        			@if(count($debates) > 0)
	        			<input type="submit" value="Challenge" class="debate-btn">
	        			@endif
	        		</div>
	      		</div>
      		</form>
      	</div>
    </div>

    @endif


</main>

@endsection