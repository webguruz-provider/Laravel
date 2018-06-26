<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" xmlns="w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="two" />
    <meta property="og:type" content="video.movie" />
    <meta property="og:url" content="http://www.imdb.com/title/tt0117500/" />
    <meta property="og:image" content="http://ia.media-imdb.com/images/rock.jpg" />
	<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sided') }}</title>

    <!-- Scripts -->
		<script>
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}
</script>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'user' => Auth::User(),
            'signedIn' => Auth::check()
        ]) !!};
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
    <div id="app">
        <nav class="primary-nav">
            <div class="u-container">
                <div class="primary-nav__left clone-sec">
                     <a class="" href="{{ route('publicDashboardIndex')}}">
                        <img class="primary-nav__logo" src="{{ asset('img-dist/brand/logo_black.svg') }}" alt="Sided Logo">
                    </a>
					<div class="topnav" id="myTopnav">
                    @if(!empty(auth()->user()->name))
                      <a href="{{ route('publicDashboardIndex') }}" class="primary-nav__dropdown-link u-link-black">
                          Feed
                      </a>
                      <a href="{{  route('publicDebateCreate')  }}" class="primary-nav__dropdown-link u-link-black">
                          Start new debate
                      </a>                    
					           <a href="javascript:void(0);" style="font-size:25px;" class="icon" onclick="myFunction()"><span></span></a>
                    @endif
					</div>
                </div>
				<div class="primary-nav__center">
          <!--a class="primary-nav__link" href="#">
                        <button class="toggle-plus" type="button"></button> 
                    </a-->

          
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


        @yield('content')

        <?php /*
        @if($errors->any())
            <div class="flash-msg">
                <h4 style="padding: 10px">{{ $errors->first() }}</h4>
            </div>
            
        @endif
        */
        ?>


        <div class="game-footer u-text-center">
            &copy; {{ date('Y')}}, Sided, Inc.
        </div>




        <div class="modal fade" id="inviteFriends" role="dialog">
            <div class="modal-dialog">    
                <!-- Modal content-->
                <div class="modal-content">

                    <form method="POST" action="{{ route('inviteFriends') }}">
                        <input type="hidden" name="fingerprint_string" id="fingerprint_string">
                        <div class="modal-header">
                            <button type="button" class="btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
                        </div>
                        <div class="modal-body">
                            <h4 class="modal-title">Invite Friends </h4>
                        </div>
                        <div id="home" class="invite-box">
                            <div>
                                <label>Enter Email</label>
                                <input type="email" required name="email"  placeholder="Please Enter Email">
                                <!-- pattern="^([\w+-.%]+@[\w-.]+\.[A-Za-z]{2,4},*[\W]*)+$"  -->
                            </div>
                        </div>

                        <div class="modal-footer">
                            <input type="submit" value="Send Invite" class="debate-btn">
                        </div>
                    </form>
                </div>
            </div>
        </div>





<div class="modal fade" id="myModal3" role="dialog">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
                  <button type="button" class="btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
          <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->          
        </div>
        <div class="modal-body">
        <h4 class="modal-title">Debate a Friend</h4>
          <p>Send this debate to a friend who might have something to say.</p>
        </div>
        <div class="modal-footer">
         <button type="button" data-toggle="modal" data-target="#myModal12">Send to a Friend</button>
         <p>or Cancel</p>
        </div>
      </div>
      
    </div>
</div>





<!-- #challengeFriends -->
  <div id="challengeFriends" role="dialog" class="modal fade in">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" action="{{ route('challengeForDebate') }}" id="challengeForDebate">
          
          <div class="modal-header">
            <button type="button" data-dismiss="modal" class="btn-default"><i aria-hidden="true" class="fa fa-times"></i></button>
          </div>
          
          <div class="modal-body">
            <h4 class="modal-title">Select Opponent</h4>
            <p>Select opponents from your network or challenge out to your friends via email.</p>
            <p>Invite as many as you like. First one in gets to debate.</p>     
          </div>
          

          <div class="tab-section">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#fav">Favorites</a></li>
              <li><a data-toggle="tab" href="#network">My Sided Network</a></li>
              <li><a data-toggle="tab" href="#invite-others">Invite Others</a></li>
            </ul>

            <div class="tab-content">
              <!-- .fav -->
              <div id="fav" class="tab-pane fade in active">

                <div class="dashboard-item">
                  <div class="debate-preview u-background-white">
                    <div class="follow-player-sec">


                      <div class="debate-preview__players follow-players">
                        <div class="debate-select-img"><img width="128" height="128" alt="" src="{{ asset('images') }}/images/1508755261.jpg">
                          
                          <a class="fav-add">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24.125px" height="21.125px" viewBox="0 0 24.125 21.125" enable-background="new 0 0 24.125 21.125" xml:space="preserve">
                              <g>
                                <g id="favorite">
                                  <path stroke="#FFFFFF" stroke-width="3" stroke-miterlimit="10" d="M12.063,18.578l-1.422-1.262
                                    C5.36,13.172,1.907,10.379,1.907,6.955C1.907,4.162,4.345,2,7.493,2c1.727,0,3.453,0.722,4.57,1.894
                                    C13.181,2.722,14.907,2,16.634,2c3.146,0,5.584,2.162,5.584,4.955c0,3.424-3.453,6.218-8.732,10.361L12.063,18.578z"/>
                                </g>
                              </g>
                            </svg>
                          </a>
                        </div>
                        <div class="debate-select-name">
                          <h4 class="debate-preview__player-name"><a href="#" class="u-link-black"> mhaley</a></h4>
                          <small> Mr. Clifton Erdman Sr. </small>
                        </div>
                        <div class="debate-tick">
                            <input type="checkbox" id="1" name="invite[]" value="1">
                            <label for="1"><span></span></label>
                        </div>
                      </div>


                    </div>
                  </div>
                </div>
              </div>
              <!-- /.fav -->


              <!-- #network -->
              <div id="network" class="tab-pane fade">
                <div class="sided-net-content">
                  <h4 class="modal-title">Invite by Email</h4>
                  <p>Add the email addresses of up to three friends you want to debate. We’ll invite them into the ring.</p>
                  <div class="email-address-form">
                    <form>
                      <input type="email" value="Your friends email address…">
                      <input type="email" value="Your friends email address…">
                      <input type="email" value="Your friends email address…">
                    </form>
                  </div>
                </div>
              </div>
              <!-- /close #network -->
              






              <div id="invite-others" class="tab-pane fade">
              </div>
            </div>
            <!-- /.tab content -->
          </div>
          <!-- /.tab section -->

          <!-- .modal-footer -->
          <div class="modal-footer">
            <input type="hidden" name="debate_id" value="20">
            <input type="submit" value="Send Challenge " class="green-btn">
            <button type="button" data-dismiss="modal" class="cancel-btn">or Cancel</button>
          </div>
          <!-- /.modal-footer -->
        </form>
      </div>
    </div>
  </div>
<!-- /#challengeFriends -->

</div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>


    <script>

      $.urlParam = function(name){
          var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
          if (results==null){
             return null;
          }
          else{
             return decodeURI(results[1]) || 0;
          }
      }



        $(document).ready(function() {
            $('.loader-bg').hide();

            $(".session-flash").delay(15000).fadeOut(500);
            $(".flash-msg").delay(15000).fadeOut(500);
            

            var type = window.location.hash.substr(1);
            //alert(type);
            if(type =='category_container'){

                $('#nav-tabs > li:first').removeClass('active');
                $('#nav-tabs > li:last').addClass('active');


                $("#recent_container").removeClass('in active');
                $("#category_container").addClass('in active');


                var cat_id = $.urlParam('cid'); // name
                if(cat_id > 0){
                  var ele = $('span[data-cat-id="'+cat_id+'"]').parent();
                  var cat_name = $('span[data-cat-id="'+cat_id+'"]').text();
                  show_category_questions(cat_name, cat_id,ele);
                }

            }


            // on question select

            $('body').on('click touchstart', '.questions', function() {
                $(".debate-btn-box").html('');

                $(".debate-preview").removeClass("debateselected");
                $(this).children(".debate-preview").addClass("debateselected");

                var questionID = $(this).children(".question_id").attr('ques-id');
                $("#question_id").val(questionID);

                var sub_btn = '<button type="submit">Start Debate</button>';
                $(this).children(".debateselected").children(".debate-btn-box").html(sub_btn);

            });

            $('body').on('click', '.debate-btn-box', function() {
                $('form["name=select_question"]').submit();
            });




            // on category click
            $('.onboarding-category').click(function() {
                $("#category-listing").hide();
                $('.onboarding-category').removeClass('is-selected');
                $(this).addClass('is-selected');
                var cat_name = $(this).children(".onboarding-category__name").text();
                var cat_id = $(this).children(".onboarding-category__name").attr("data-cat-id");
                //alert('jkjkj');
                $.ajax({
                    type: "POST",
                    //url: "./debates/get_questions",
                    url: "{{ route('getQuestions') }}",
                    data: {
                        "category_id": cat_id,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(resp) {
                        //var resp = $.parseJSON(msg);
                        if (resp.length == 0) {
                            alert('No question in this category');
                            $("#category-listing").show();
                            return false;
                        }

                         if(resp.length > 0){
                            if(resp[0].category.ads_id > 0){
                                //var img = resp[0].category.ads.image_url;
                                if(resp[0].category.ads != null){
                                    var img = resp[0].category.ads.image_url;
                                    $("#category-ads").html('<img src="{{ asset('/img-dist/ads/') }}/'+img+'">');
                                }
                            }
                        } 
                        
                        $("#category-wise-questions").html("<div class='close-sec'>View all questions in  <span>" + cat_name + "</span> <a id='close-btn' href='#' onclick='show_categories(); '><i class='fa fa-times'></i></a></div>");

                       

                        $.each(resp, function(index, value) {
                          
                           var source_hidden = (value.source == "" || value.source == null)?"source-hidden":"";
							//alert(JSON.stringify(value.getquestion_auther.handle));
                            var resp_html = '<div class="dashboard-item questions">' +
                                '<div ques-id="' + value.id + '" class="question_id"></div>' +

                                '<div class="debate-preview u-background-white"><div class="debate-preview__header"><div class="debate-haeder-top"><h4 class="debate-preview__category"> Submitted In <strong class="u-text-black">' + value.category.name + '</strong></h4> <h5 class="debate-preview__category"> Submitted By <strong class="u-text-black"> <a href="../players/'+value.getquestion_auther.handle+'">' + value.getquestion_auther.name + '</a></strong></h5><span>' +
                                '<img alt="" src="../img-dist/dot.svg"></span></div> <p class="debate-preview__question-text">' + value.text + '</p> <small class="debate-preview__question-source '+source_hidden+'">Source from <strong class="u-text-black"><a href="' + value.source_url + '" target="_blank">' + value.source + '</a></strong></small></div>' +
                                '<div class="debate-btn-box"></div></div></div>';
                            $("#category-wise-questions").append(resp_html);
                        });
                    },
                    error: function(msg) {
                        //alert(msg.status + ' ' + msg.statusText);
                    }
                });
            });



            $('#cat-tab').click(function() {
				//alert('test1');
                $("#question_id").val('');
                //$("input[type='submit']").attr('disabled', true);
                //$("input[type='submit']").addClass('disabled');
            });



            // vote module 
            $('a#vote_for_debate').click(function() {
                //alert("{{ route('publicDebateVoteStore') }}");

                var debate_id = $(this).attr('data-debate-id');
                var user_id = $(this).attr('data-user-id');

                $.ajax({
                    type: "POST",
                    url: "{{ route('publicDebateVoteStore') }}",
                    data: {
                        "debate_id": debate_id,
                        "user_id": user_id
                    },
                    success: function(msg) {
                        // var response = $.parseJSON(msg);
                        // console.log(msg.status);

                        $(".flash-msg").html(msg.response);
                        $(".flash-msg").show();

                        setTimeout(function() {
                            $('.flash-msg').fadeOut('fast');
                        }, 20000); // <-- time in milliseconds


                        if (msg.status == 'success') {

                            setTimeout(function() {
                                location.reload();
                            }, 5000); // <-- time in milliseconds
                        }


                    },
                    error: function(msg) {
                        //alert(msg.status + ' ' + msg.statusText);
                    }
                });
            });




        });

        function show_categories() {
            $("#category-listing").show();
            $("#category-ads").html("");
            $("#category-wise-questions").html("");

            $("#question_id").val('');
            //$("input[type='submit']").attr('disabled', true);
            //$("input[type='submit']").addClass('disabled');

            return false;
        }



        function show_category_questions(cat_name, cat_id,ele){
          history.pushState(null, null, 'create');
            $("#category-listing").hide();
            $('.onboarding-category').removeClass('is-selected');
            ele.addClass('is-selected');

            //var cat_name = $(this).children(".onboarding-category__name").text();
            //var cat_id = $(this).children(".onboarding-category__name").attr("data-cat-id");

            $.ajax({
                type: "POST",
                //url: "./debates/get_questions",
                url: "{{ route('getQuestions') }}",
                data: {
                    "category_id": cat_id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(resp) {
                    //var resp = $.parseJSON(msg);
                    if (resp.length == 0) {
                        alert('No question in this category');
                        $("#category-listing").show();
                        return false;
                    }
                    if(resp.length > 0){
                            if(resp[0].category.ads_id > 0){
                                //var img = resp[0].category.ads.image_url;
                                if(resp[0].category.ads != null){
                                    var img = resp[0].category.ads.image_url;
                                    console.log(resp[0].category.ads);
                                    $("#category-ads").html('<img src="{{ asset('/img-dist/ads/') }}/'+img+'">');
                                }
                            }
                        }
                    $("#category-wise-questions").html("<div class='close-sec'>View all questions in  <span>" + cat_name + "</span> <a id='close-btn' href='#' onclick='show_categories(); '><i class='fa fa-times'></i></a></div>");

                    $.each(resp, function(index, value) {

                         var source_hidden = (value.source == "" || value.source == null)?"source-hidden":"";


                        var resp_html = '<div class="dashboard-item questions">' +
                            '<div ques-id="' + value.id + '" class="question_id"></div>' +

                            '<div class="debate-preview u-background-white"><div class="debate-preview__header"><div class="debate-haeder-top"><h4 class="debate-preview__category"> Submitted In <strong class="u-text-black">' + value.category.name + '</strong></h4> <span>' +
                            '<img alt="" src="../img-dist/dot.svg"></span></div> <p class="debate-preview__question-text">' + value.text + '</p> <small class="debate-preview__question-source '+ source_hidden +'">Source from <strong class="u-text-black"><a href="' + value.source_url + '" target="_blank">' + value.source + '</a></strong></small></div>' +
                            '<div class="debate-btn-box"></div></div></div>';
                        $("#category-wise-questions").append(resp_html);
                    });
                },
                error: function(msg) {
                    //alert(msg.status + ' ' + msg.statusText);
                }
            });



        }
    </script>

    
		</body>
</html>
