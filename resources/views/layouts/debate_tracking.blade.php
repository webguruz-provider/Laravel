<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" xmlns="w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sided') }}</title>

    <!-- Scripts -->

    
    <script src="{{ asset('js/tracking.js') }}"></script>
	<script>
		function myFunction() {
		    var x = document.getElementById("myTopnav");
		    if (x.className === "topnav") {
		        x.className += " responsive";
		    } else {
		        x.className = "topnav";
		    }
		}
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'user' => Auth::User(),
            'signedIn' => Auth::check(),
            'voted'=>'0',
            'voterSide'=>'0',
            'uid'=> ''
        ]) !!};

        window.Laravel.uid = fp.get();
	</script>


    
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
	<!-- Styles -->
 	<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59edd23175103073"></script>
</head>

<body>
	<!-- loader -->
    <div class="loader-bg">
        <div class="loader"></div>
    </div>
	<div class="js-flash-msg flash-msg" style="display: none">
            <h4 style="padding: 10px"></h4>
        </div>
    <button id="restictUser" type="button" data-toggle="modal" data-target="#restictionModel" style="display:none"></button>
    <!-- /.loader -->

    <!-- #app -->
    <div id="app">
    	<!-- primary-nav -->
        <nav class="primary-nav">
            <div class="u-container">
                <div class="primary-nav__left">
                     <a class="" href="{{ route('publicDashboardIndex')}}">
                        <img class="primary-nav__logo" src="{{ asset('img-dist/brand/logo_black.svg') }}" alt="Sided Logo">
                    </a>

                    <span>
                        <?php 
                            $fstring = session()->get('fingerprint_string');
                        ?>
                        </span>
					<div class="topnav" id="myTopnav">
                    @if(!empty(auth()->user()->name))
                    <a class="primary-nav__link" href="{{ route('publicDashboardIndex')}}">
                        Feed
                    </a>
                    <a class="primary-nav__link" href="{{ route('publicDebateCreate')}}">
                        Start a New Debate
                    </a>
					<a href="javascript:void(0);" style="font-size:25px;" class="icon" onclick="myFunction()"><i class="fa fa-bars" aria-hidden="true"></i></a>
                    @endif
					</div>
                </div>
				<div class="primary-nav__center">
        			<!--button class="toggle-plus" type="button" data-toggle="modal" data-target="#myModal3"></button--> 
         		</div>
                <div class="primary-nav__right">
                    <!--form action="{{ url('/logout') }}" method="POST">
                        <input type='search' class='search-input' placeholder="Search Sided for your favorite topics">
                    </form-->
                     @if(!empty(auth()->user()->name))
                    <dropdown-nav inline-template>
                        <div class="primary-nav__dropdown">
                            <a class="primary-nav__dropdown-toggle" @click.sub="toggleVisibility">
                                @if(!empty(auth()->user()->avatar_url))
                                    <img class="u-rounded primary-nav__avatar" src="{{ asset('images') }}/{{ auth()->user()->avatar_url }}">
                                @else
                                    <img class="u-rounded primary-nav__avatar" src="http://lorempixel.com/100/100/cats/?80538">
                                @endif
                            </a>
                            <ul :class="{'u-display-block' : isVisible}">
                                <span class="primary-nav__dropdown-arrow primary-nav__dropdown-arrow--outer"></span>
                                <span class="primary-nav__dropdown-arrow primary-nav__dropdown-arrow--inner"></span>
                                <!-- <a href="{{ url('/editprofile') }}" class="primary-nav__dropdown-link u-link-black">
                                    Profile
                                </a> -->

                                
                                <a href="{{ url('/players/'.auth()->user()->handle ) }}" class="primary-nav__dropdown-link u-link-black">
                                    Profile
                                </a>                                

                                <a href="#" class="primary-nav__dropdown-link u-link-black" data-toggle="modal" data-target="#inviteFriends">
                                    Invite Friends
                                </a>

                                 <a href="{{ route('playerChangePassword') }}" class="primary-nav__dropdown-link u-link-black">
                                    Change Password
                                </a>
  
                                 <a href="{{ url('/logout') }}"
                                    onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();"
                                     class="primary-nav__dropdown-link u-link-black">
                                    Sign Out
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </ul>
                        </div>
                    </dropdown-nav>
                    @endif
                </div><!-- /primary-nav__right-->
            </div>
        </nav>
        <!-- /.primary-nav -->


        @yield('content')

        <div class="game-footer u-text-center">
            &copy; {{ date('Y')}}, Sided, Inc.
        </div>



        

	</div>


    <!-- Scripts -->
    <script src="{{ asset('js/app_nonlogin.js') }}"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
    <script>
        $(document).ready(function(){

            $('.debate-comment__form').hide();

            // wrap vote-showingline into p tag
            $('.debate-preview.u-background-white')
              .contents() // get all child node including text and comment 
              .filter(function() { // filter the text node which is not empty
                return this.nodeType === 3 && $.trim(this.textContent).length
              }).wrap('<p class="vote-show-line"></p>'); // wrap filtered element with p


            // enable enter form submit for comment and argument
            $(".resp-text-box").keyup(function(event) {
                if (event.keyCode === 13) {
                    if($(this).val() !=''){
                        $(this).next('button[type="submit"]').click();
                    }else{
                        return false;
                    }
                }
            });
            


            if( $('.vote-count-0-not-given-disabled').length == '2'){  
                $.each( $('.voter-sec').find('span') , function( key, value ) {
                    $(this).html('');
                });
            }

            if($('.not-given').length > 0 && $('.not-given-disabled').length > 0){
                $('.not-given').children('li').children('span').hide();
                $('.not-given-disabled').children('li').children('span').hide();
            }


            if( $('.vote-count-0-my-debate-disabled').length == '2')
            {  
                $.each( $('.voter-sec').find('span') , function( key, value ) {
                    $(this).html('');
                });
            }
            // if( $('.my-debate-disabled').length == '2'  ){
            //     $.each( $('.voter-sec').find('a') , function( key, value ) {
            //         $(this).removeClass();
            //         $(this).addClass('gray-in');
            //         $(this).css( 'cursor', 'default' );
            //         $(this).closest( "span" ).css( "color", "red" );
            //     });
            // }

            if($('.not-mine-disagree-1').length > 0){
                $('.not-mine-disagree-1').prev().css('color', '#D8D8D8');
            }
            if($('.not-mine-agree-2').length > 0){
                $('.not-mine-agree-2').next().css('color', '#D8D8D8');
            }

            if($('.not-mine-agree-1').length > 0){
                $('.not-mine-agree-1').prev().css('color', '#D8D8D8');
            }

            if($('.not-mine-disagree-2').length > 0){
                $('.not-mine-disagree-2').next().css('color', '#D8D8D8');
            }
            
            

            $('.loader-bg').hide();
            $('body').on('click', '.shareebate-close', function() {
                //$('.new-share-main').fadeOut('300');

                $.ajax({
                    type: "POST",
                    url: "{{ route('debateSharebox') }}",
                    data: {  } ,
                    success: function (msg) {
                        $('.new-share-sec-debate').fadeOut('300');
                    },
                    error: function (msg) {
                        
                    }
                });
                return false;
            });
            $(".session-flash").delay(15000).fadeOut(500);
            $(".flash-msg").delay(15000).fadeOut(500);
            

            
            
        });

        $("#signout").click(function(){
            if(window.Laravel.voted == '1' ){
                event.preventDefault();
                document.getElementById('logout-form').submit();
            }
        });


        


         $('.debate-comment').each(function(i1,obj) {
            if(i1 < 5){
                $(this).show();
            }else{
                $(this).hide();
            }
         });

         $(".view-comment").click(function(){
                $('.debate-comment').show();
                var str = $(this).text();
                var res = str.replace("Showing last 5 comments. Click to view", "Showing");
                $(this).text(res);
         });




    </script>


    
    
    <?php
        if(empty($fstring)){                    
    ?>
    <script>
        $(document).ready(function(){
            var uid = fp.get();
            window.Laravel.uid = uid;
            var event_type = $("#event_type").val();
            var event_id = $("#event_id").val();

            if(event_type){
                $.ajax({
                    type: "POST",
                    url: "{{ route('ontrackingFingerprintStore') }}",
                    data: { "fingerprint_string": uid , "event_type":event_type, "event_id":event_id } ,
                    success: function (msg) {
                        // alert('here');
                    },
                    error: function (msg) {
                        
                    }
                });    
            }
            
        });
    </script>
    <?php
     } 
    ?>
    


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js"></script>

    <script>
    $('img.lazy').lazyload( {
                effect: "fadeIn"
            });
        </script>



</body>
</html>
