<?php
if (Auth::check()) {
    $login_user_id  = auth()->user()->id;
} else {
    $login_user_id = "0";
}

$users          = $debate->users()->get();
$users_array    = [$users[0]->id , $users[1]->id ];
$total_votes    = ($users[0]->pivot->votes + $users[1]->pivot->votes);

$my_debate      = false;
$votes          = $debate->votes()->select('voter_id','user_id')->where('voter_id', $login_user_id)->first();
?>

@if(in_array($login_user_id, $users_array))
    <?php $my_debate = true; ?>
@endif


<div class="debate-preview u-background-white user-detial-bottom">
    <div class="debate-preview__header">
        <h4 class="debate-preview__category">
            Submitted In <strong class="u-text-black">{{ $debate->question->category->name }}</strong> 
			
            <span>
                <?php
                    $days = $debate->starts_at->diffInDays();
                    if($days < 1){
                        echo $debate->starts_at->diffForHumans();
                    }else{
                        echo $days." days ago";
                    }
                ?>

                @if($my_debate)
                    <!-- <a data-toggle="modal" data-target="#inviteFriends" class="align-right" id="openPopUpClick"><img  src="{{ asset('img') }}/dot.svg" class="align-right"></a> -->
                @endif

            </span>
        </h4>
		<h5 class="debate-preview__category">Submitted By <strong class="u-text-black"><a href="{{ route('publicPlayerShow', $debate->getDebatequestion->getquestionAuther->handle ) }}">{{ $debate->getDebatequestion->getquestionAuther->name }}</a></strong></h5>
        <p class="debate-preview__question-text">
            {{$debate->question->text }}
        </p>
        <small class="debate-preview__question-source <?=(empty($debate->question->source))?'source-hidden':''?>">
            {{$debate->question->medium }} from 
            <strong class="u-text-black">
                <a href="{{ $debate->question->source_url }}" target="_blank" onclick="return false;"> {{$debate->question->source }}
                </a>
            </strong>
        </small>

    </div>
    <div class="debate-preview__players u-flex">
        <?php $i=1; ?>

        @foreach ($users as $user)

            <?php $side = strtolower($user->pivot->side); ?>

            <div class="debate-preview__player u-flex-center">
                <div class="debate-preview__player-img {{ $side }}" >
                    <a href="{{ route('publicPlayerShow', $user->handle) }}">
                        <img class="debate-preview__player-avatar" src="{{ asset('images') }}/{{ $user->avatar_url }}" alt="{{ $user->name }}">
                    </a>
                </div>
                <div class="debate-preview__player-info">
                    <h4 class="debate-preview__player-name">
                        <a class="u-link-black" href="{{ route('publicPlayerShow', $user->handle) }}">
                            {{ $user->handle }}</a>
                    </h4>
                    <small>
                        {{ $user->rank }}
                    </small>
                </div><!-- /player-info-->

                <ul class="voter-sec full-dark">
                    <!-- <li><span>22</span><img src="img/green-vote-btn.svg"></li> -->

                    <li>
                        @if($my_debate)
                            @if($i==1)
                                @if($total_votes > 0)
                                    <span class="{{$side}}-{{$i}}">{{ $user->pivot->votes }}</span>
                                    <img src="/img/{{$side}}-{{$i}}-vote-btn.svg">
                                @else
                                    <img src="/img/left-vote-btn-dark.svg">
                                @endif
                                
                            @else
                                @if($total_votes > 0)
                                    <img src="/img/{{$side}}-{{$i}}-vote-btn.svg">
                                    <span class="{{$side}}-{{$i}}">{{ $user->pivot->votes }}</span>
                                @else
                                    <img src="/img/right-vote-btn-dark.svg">
                                @endif
                            @endif
                        @else

                            @if($i==1)
                               
                                @if(isset($votes))
                                    @if($votes->user_id == $user->id)
                                        <span  class="{{$side}}-{{$i}}">{{ $user->pivot->votes }}</span>
                                        <img src="/img/{{$side}}-{{$i}}-vote-btn.svg">
                                    @else
                                        <span class="{{$side}}-{{$i}}-dark">{{ $user->pivot->votes }}</span>
                                        <img src="/img/left-vote-btn-dark.svg">
                                    @endif 
                                @else
                                    <!-- <span>{{ $user->pivot->votes }}</span> -->
                                   <!--  <img src="/img/left-vote-btn.svg"> -->
                                    <img src="/img/{{$side}}-{{$i}}-vote-btn.svg">
                                @endif 

                                
                            @else
                                <!-- <img src="/img/right-vote-btn.svg">
                                <span>{{ $user->pivot->votes }}</span> -->

                                
                                @if(isset($votes))
                                    @if($votes->user_id == $user->id)
                                        <img src="/img/{{$side}}-{{$i}}-vote-btn.svg">
                                        <span class="{{$side}}-{{$i}}">{{ $user->pivot->votes }}</span>
                                    @else
                                        
                                        <img src="/img/right-vote-btn-dark.svg">
                                        <span class="{{$side}}-{{$i}}-dark">{{ $user->pivot->votes }}</span>
                                    @endif 
                                @else
                                    <img src="/img/{{$side}}-{{$i}}-vote-btn.svg">
                                    <!-- <img src="/img/right-vote-btn.svg"> -->
                                    <!-- <span>{{ $user->pivot->votes }}</span> -->
                                @endif 


                            @endif

                        @endif
                    </li>
                </ul>

            </div>
            <?php $i++; ?>
        @endforeach
    </div>
    <div class="">
        <div>
            <h3>Start your own debate with this question.<a href="{{ url('debates/pickaside') }}?question_id={{$debate->question->id}}"> Click here.</a>
            <a href="{{ url('debates/create') }}?cid={{$debate->question->category->id}}#category_container">All questions</a>
            </h3>
        </div>
    </div>
</div>
