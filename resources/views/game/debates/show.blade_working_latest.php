@extends('layouts.game')

@section('content')

  @if($debate->status == 'needs_opponent')
    <?php $debate_user = (new \App\Helpers\DebateUsers)->get_user($debate->id); ?>
    <div class="btn-set">
      <form method="POST" action="{{ route('joinDebate') }}" id="joinDebate">
        <input type="hidden" name="debate_id" value="{{ $debate->id }}">
        @if($debate_user->user_id == auth()->user()->id)
          <button type="button" data-toggle="modal" data-target="#mychallengeModal">Challenge</button>
        @else
          <button type="submit"> Join Debate</button>
        @endif
      </form>
    </div>
  @endif
 

  @if (Session::has('message'))
    <div class="flash-msg">{{ Session::get('message') }}</div>
  @endif


  <div class="flash-msg" style="display: none;">
    <h4>You voted successfully</h4>
  </div>

  <div class="marginb game-wrapper new-share-main">
    <div class="top-head">
      <div class="debate-preview u-background-white">
		    <div class="new-share-sec">

   			  <div class="share-head">
   				  <h4 class="u-white-text">Share this Debate</h4>
	   			  <a href="#" class="share-close"><i class="fa fa-times" aria-hidden="true"></i></a>
	   		  </div>
	   
	   		  <p class="debate-preview__question-text">Invite others to this debate to grow the discussion, get more votes, and earn more points. </p>

          <span>Learn more about points and status.</span>
          
          <div class="addthis_inline_share_toolbox"></div>
		    
        </div>
	    </div>
    </div>

    <!-- debate component loading -->
    <debate :debate="{{ $debate }}"></debate>

  </div>
  <!-- /.game-wrapper -->

  <div class="modal fade" id="mychallengeModal" role="dialog">  
    <div class="modal-dialog">    
      <div class="modal-content">
        
        
          <div class="modal-header">
            <button type="button" class="btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
          </div>
          
          <div class="modal-body">
            <h4 class="modal-title">Challenge </h4>
            <p>{{ $debate->question_text }}</p>
          </div>
          
          <div class="tab-section">
              
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#home">Favorites</a></li>
              <li><a data-toggle="tab" href="#menu1">My Sided Network</a></li>
              <li><a data-toggle="tab" href="#menu2">Invite Others</a></li>
            </ul>
            

            <div class="tab-content">

              <!-- tab 1-->
              <div id="home" class="tab-pane fade in active">

                <form method="POST" action="{{ route('challengeForDebate') }}" id="challengeForDebate">

                <div class="dashboard-item">
                  
                  <div class="debate-preview u-background-white">
                    <div class="follow-player-sec">

                      @foreach($users as $user)
                      <div class="debate-preview__players follow-players">
                        <div class="debate-select-img">
                          <img width="128" height="128" alt="" src="{{ asset('images') }}/{{ $user->avatar_url }}">
                        </div>
                        
                        <div class="debate-select-name">
                          <h4 class="debate-preview__player-name"><a class="u-link-black" href="#"> {{ $user->handle }}</a></h4>
                          <small> {{ $user->name }} </small>
                        </div>

                        <div class="debate-tick">
                          <input type="checkbox" id="{{ $user->id }}" name="invite[]" value="{{ $user->id }}" />
                          <label for="{{ $user->id }}"><span></span></label>
						  <input type="hidden" name="challenger_name" value="{{ Auth::user()->name }}">
						<input type="hidden" name="take_a_dare_name" value="{{ $user->name }}">
                        </div>
                      </div>
                      @endforeach
                      
                    </div>



                  </div>
                </div>
              </form>
              </div>
              
              <!-- tab 2-->
              <div id="menu1" class="tab-pane fade">
                
              </div>

              <!-- tab 3-->
              <div id="menu2" class="tab-pane fade">
                <div class="sided-net-content">
                  <h4 class="modal-title">Invite by Email</h4>
                  <p>Add the email addresses of up to three friends you want to debate. We’ll invite them into the ring.</p>
                  <div class="email-address-form">
                    <form name="invite_email" action="{{ route('inviteFriends') }}" method="post">
                      <input type="hidden" name="redirect_back" value="{{ url('debates/'.$debate->id) }}">
                      <input type="email" placeholder="Your friends email address…"  name="email[]" required>
                      <input type="email" placeholder="Your friends email address…" name="email[]">
                      <input type="email" placeholder="Your friends email address…" name="email[]">

                      <div class="modal-footer">
                          <input type="hidden" name="debate_id" value="{{ $debate->id }}">
                          <input type="submit" class="green-btn" value="Send Invite ">
                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>



          <div class="modal-footer">
              <input type="hidden" name="debate_id" value="{{ $debate->id }}">
              <input type="submit" class="green-btn" value="Send Challenge ">
          </div>

          
        
      </div>
    </div>
  </div>

    
@endsection