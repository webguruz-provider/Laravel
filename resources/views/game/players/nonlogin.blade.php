
@extends('layouts.tracking')

@section('content')

@if($errors->any())
    <div class="flash-msg">
        <h4>{{ $errors->first() }}</h4>
    </div>  
@endif

<main class="game-wrapper">
    <section class="player-profile">
        <header class="player-profile__header u-text-center">
            <div class="pick-sec">
                <div class="following-sec">

                    <input type="hidden" name="point_type" id="point_type" value="profile_view">
                    <input type="hidden" name="profile_id" id="profile_id" value="{{ $user->id }}">


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
                           <a class="challenge-btn" href="{{ route('profile.edit', auth()->user()->id ) }}">Update Profile</a>
                        <!-- </div> -->

                    @endif
                </div>
                    

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



                <div class="dropdown profile-name">
                    <h2 class="player-profile__header-name">{{ $user->name }}</h2>
                </div>
            </div>
            <span class="player-profile__header-meta title-caption">
                {{ $user->handle }}
                |
                {{ $user->rank }}
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
                            <p><div class="header-stat__number">{{ $user->total_points }}</div></p>
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
            </ul>
            

            <div class="tab-content"> 
                <div id="tab1" class="tab-pane fade in active player-profile__tab-content">
                    
                </div>
                <div id="tab2" class="tab-pane fade in player-profile__tab-content">
                    
                    
                </div>
                <div id="tab3" class="tab-pane fade in player-profile__tab-content">
                    
                </div>
            </div>


        </div>
    </section>



    
</main>

@endsection