<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" xmlns="w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
   <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
   
    <link href="{{ mix('css/admin.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,600" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
 
</head>
<body>

    <div class="loader-bg">
        <div class="loader"></div>
    </div>


    <div id="app">
        <nav class="admin-nav">
            <header class="admin-nav__header">
                <a class="{{ Request::is('partners') ? 'admin-nav__link--active' : '' }}" href="{{ route('partnerQuestionActivity') }}">
                    <img class="admin-nav__logo" src="{{ asset('img-dist/brand/logo_white.svg') }}" alt="Sided Logo">
                </a>
            </header>
            <div class="topnav" id="myTopnav">
            <div class="admin-nav__user">
                
                <a href="{{ route('proprofile.edit', auth()->user()->id ) }}" class="profile-img-click">
                    <img class="u-img-avatar" src="{{ asset('images') }}/{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}">
                </a>

                <p><strong><a href="{{ route('proprofile.edit', auth()->user()->id ) }}">{{ auth()->user()->name }}</a></strong></p>
                
  <div class="wrapper">
    <p>On Air</p>
  <label class="switch">
  @if(Auth::user()->go_online == 'false')
    <input type="checkbox" value="false">
@else
<input type="checkbox" value="true" checked>
@endif
  <span class="slider round"></span>
</label>
</div>
            </div>
            <div class="admin-nav__section">
<a class="admin-nav__link {{ Request::is('partners/questions/activities') ? 'admin-nav__link--active' : '' }}" href="{{ route('partnerQuestionActivity') }}">Activity</a>
<a class="admin-nav__link {{ Request::is('partners/questions/live*') ? 'admin-nav__link--active' : '' }}" href="{{ route('partnerLiveQuestionIndex') }}">Questions</a>
<a class="admin-nav__link {{ Request::is('*partners/ads*') ? 'admin-nav__link--active' : '' }}" href="{{ route('partnerAdIndex') }}">Ad & Promotions</a>
<a class="admin-nav__link {{ Request::is('*partners/advertiser*') ? 'admin-nav__link--active' : '' }}" href="{{ route('partnerAdvertiserIndex') }}">Advertisers</a>
                <a class="admin-nav__link {{ Request::is('*partners/categories*') ? 'admin-nav__link--active' : '' }}" href="{{ route('partnerCategoryIndex') }}">
                    Categories
                </a>
                <a class="admin-nav__link {{ Request::is('*partners/contests*') ? 'admin-nav__link--active' : '' }}" href="{{ route('partnerContestIndex') }}">Contests</a>
                <a class="admin-nav__link {{ Request::is('*partners/Events*') ? 'admin-nav__link--active' : '' }}" href="{{ route('partnerEventIndex') }}">Events</a>
            </div>
            <hr class="admin-nav__divider">
            <div class="admin-nav__section">
                <a class="admin-nav__link {{ Request::is('*players/proprofile*') ? 'admin-nav__link--active' : '' }}" href="{{ route('proprofile.edit', auth()->user()->id ) }}">
                    Account Settings
                </a>
                <a href="{{ url('/logout') }}"
                                    onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();"
                                     class="primary-nav__dropdown-link admin-nav__link">
                                    Sign Out
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                <!-- <a class="admin-nav__link {{ Request::is('partners') ? 'admin-nav__link--active' : '' }}" href="#">
                    Sided Overview
                </a>
                <a class="admin-nav__link {{ Request::is('*partners/questions/supportcenter*') ? 'admin-nav__link--active' : '' }}" href="{{ route('partnerQuestionsupport') }}">
                    Support Center
                </a> -->
                <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()"><span></span></a>
            </div>
            </div>
        </nav>
        <main class="admin-content">
            <div class="prosetting" style="display:none"></div>
            @if (Session::has('message'))
                <div class="flash-msg message_editprofile">{{ Session::get('message') }}</div>
            @endif 
			@if (Session::has('errorcsv'))
                <div class="flash-msg errorcsv">{{ Session::get('errorcsv') }}</div>
            @endif


            @yield('content')
        </main>
    </div>

    <script type="text/javascript" src="{{ asset('js/jquery-2.1.3.min.js') }}"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.smoothState.min.js') }}"></script>
    <script src="{{ mix('js/admin.js') }}"></script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  
  <script type="text/javascript">          
    $( document ).ready( function() { 

    function writeLog(event, msg){
      var output = "<span>TinyToggle::" + event + "</span> &gt; " + msg;
      $("#event-log").append( $("<p/>").html(output) ).scrollTop(+500);      
    }    
    
  </script>
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
<script type="text/javascript">
	 $('.tabgroup > div').hide();
$('.tabgroup > div:first-of-type').show();
$('.tabs a').click(function(e){
  e.preventDefault();
    var $this = $(this),
        tabgroup = '#'+$this.parents('.tabs').data('tabgroup'),
        others = $this.closest('li').siblings().children('a'),
        target = $this.attr('href');
    others.removeClass('active');
    $this.addClass('active');
    $(tabgroup).children('div').hide();
    $(target).show();
  
})
    </script>
	<script>
$(function(){

var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");

	$('a[data-modal-id]').click(function(e) {
		e.preventDefault();
    $("body").append(appendthis);
    $(".modal-overlay").fadeTo(500, 0.7);
    //$(".js-modalbox").fadeIn(500);
		var modalBox = $(this).attr('data-modal-id');
		$('#'+modalBox).fadeIn($(this).data());
	});  
  
  
$(".js-modal-close, .modal-overlay").click(function() {
    $(".modal-box, .modal-overlay").fadeOut(500, function() {
        $(".modal-overlay").remove();
    });
 
});
 
$(window).resize(function() {
    $(".modal-box").css({
        top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
        left: ($(window).width() - $(".modal-box").outerWidth()) / 2
    });
});
 
$(window).resize();
 
});


$("#open_adportfolio").click(function(e) {
     
    //var newTab = safari.self.browserWindow.openTab();
    if(navigator.userAgent.indexOf("Safari") != -1)
    {
        //alert('safari');
        window.open("https://www.iab.com/newadportfolio/",'myWindow', "width=800, height=800");
        return false;

       // safari.self.browserWindow.openTab("https://www.iab.com/newadportfolio/",'myWindow', "width=800, height=800");
    }else{
        window.open("https://www.iab.com/newadportfolio/",'myWindow', "width=800, height=800");
    }


    
    e.stopPropagation();
});


function readURL(input) {

      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#img-preview').attr('src', e.target.result)
                        .width(150)
                        .height(100);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }
	
function readBackgroundURL(input) {

      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#background-img-preview').attr('src', e.target.result)
                        .width(150)
                        .height(100);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }

    $("#avatar_url").change(function() {
        var input = $("input[name=avatar_url]");
        $('.img-size-err').text('');
        if(this.files[0].size/1024/1024 > 2){
            $('.img-size-err').show();
            input.val('');
            $('.img-size-err').text('Please upload only max 2MB of image.');
            $('#img-preview').hide();
        }else{
            $('#img-preview').show();
            $('.img-size-err').hide();
            readURL(this);
        }
    });
	
	$("#background_img").change(function() {
        var input = $("input[name=background_img]");
        $('.img-size-err').text('');
        if(this.files[0].size/1024/1024 > 2){
            $('.img-size-err').show();
            input.val('');
            $('.img-size-err').text('Please upload only max 2MB of image.');
            $('#background-img-preview').hide();
        }else{
            $('#background-img-preview').show();
            $('.img-size-err').hide();
            readBackgroundURL(this);
        }
    });


    $(document).ready(function() {
            
            $('.loader-bg').hide();
			
			$(".session-flash").delay(15000).fadeOut(500);
            $(".flash-msg").delay(15000).fadeOut(500);
            $(".message_editprofile").delay(15000).fadeOut(500);

            $('table').DataTable({
                "bPaginate": false,
                "bLengthChange": false,
                "bFilter": true,
                "aaSorting": [[ 2, "desc" ]],
                "bInfo": true,
                "bAutoWidth": false,
                "oLanguage": { "sSearch": "" } 
            });
            
        });

// custom code for search and filters
$(document).ready(function(){
    var user_engagements =0;

    $(".user_engagements").each(function(){
        user_engagements += Number($(this).text());
    });

    $("#user-engagement").text(user_engagements);

    /* contest page scripts */

    var contest_clicks = 0;
    var contest_impressions = 0;
    $(".contest-clicks").each(function(){
        contest_clicks += Number($(this).text());
    });

    $(".contest-impressions").each(function(){
        contest_impressions += Number($(this).text());
    });

    $("#contest_impressions").text(contest_impressions);
    $("#contest_clicks").text(contest_clicks);

    /* contest page scripts */


    /* Ads page stats */

    var ads_clicks = 0;
    var ads_impressions = 0;
    $(".ads-clicks").each(function(){
        ads_clicks += Number($(this).text());
    });

    $(".ads-impressions").each(function(){
        ads_impressions += Number($(this).text());
    });

    $("#impression__no").text(ads_impressions);
    $("#clicks__no").text(ads_clicks);


    
    /*  ads page stats*/


    $("#search-filter").click(function(){
        var days = $("#search_days").val();
        var search_text = $("#search_text").val();
        var loc = "?filter_days="+days+"&filter_text="+search_text+"#search_text";

        //alert(loc);
        window.location.assign(loc);
        return false;

        //window.location.href = loc;

        // alert('here '+days+" days data "+search_text);
        // return false;

    });

    $("#search-filter-expired").click(function(){
        var search_text = $("#search_text").val();
        var loc = "?filter_text="+search_text;
        //alert(loc);
        window.location.assign(loc);
        return false;
    });

    $("#search-filter-draft").click(function(){
        var search_text = $("#search_text").val();
        var loc = "?filter_text="+search_text;
        //alert(loc);
        window.location.assign(loc);
        return false;
    });

    $("#search-filter-deactivated").click(function(){
        var search_text = $("#search_text").val();
        var loc = "?filter_text="+search_text;
        //alert(loc);
        window.location.assign(loc);
        return false;
    });

    $("#search-filter-ads").click(function(){
        var search_text = $("#search_text").val();
        var loc = "?filter_text="+search_text+"#search_text";
        window.location.assign(loc);
        return false;
    });

    $("#search-ads-expired").click(function(){
        var search_text = $("#search_text").val();
        var loc = "?filter_text="+search_text+"#search_text";
        
        window.location.assign(loc);
        return false;
    });

    $("#search-ads-scheduled").click(function(){
        var search_text = $("#search_text").val();
        var loc = "?filter_text="+search_text+"#search_text";
        
        window.location.assign(loc);
        return false;
    });


    $("#view-ads-search-filter").click(function(){

        var days = $("#search_days").val();
        var search_text = $("#search_text").val();
        var loc = "?filter_days="+days+"&filter_text="+search_text+"#search_text";

        //alert(loc);
        window.location.assign(loc);
        return false;
    });


    $("#filter_days").change(function(){
        var days = $(this).val();
        var search_text = $("#search_text").val();
        if(search_text !='' && typeof search_text != 'undefined'){
            //alert(search_text);

             var loc = "?filter_days="+days+"&filter_text="+search_text+"#search_text";
        }else{
            if(days ==''){
                var loc = window.location.href ;
                var loc  = loc.split('?')[0];
                //alert(loc);
            }else{
                var loc = "?filter_days="+days;
            }
        }
        //alert(loc);
        window.location.assign(loc);
        return false;
    });


    $("#search-question-scheduled").click(function(){
        var search_text = $("#search_text").val();
        var loc = "?filter_text="+search_text+"#search_text";
        
        window.location.assign(loc);
        return false;
    });



    // custom 
    $('.ads_listing > li').click(function(){
        $('.ads_listing > li').removeClass('active');
        $(this).addClass('active');
        $('#attached_ads_id').val($(this).attr('data-id'));
    });

});
</script>
<script>
$(function() {
  $(checkPosition);
  function checkPosition() {
    // for mobile - you nedd to uncomment line below and line 19
    //if (window.matchMedia("(max-width: 992px)").matches) {
      var menuWrap = $("nav");
      if (menuWrap.length !== 0) {
        var stickyHeaderTop = menuWrap.offset().top;
      }

      $(window).scroll(function() {
        if ($(window).scrollTop() > stickyHeaderTop) {
          menuWrap.addClass("fixed");
        } else {
          menuWrap.removeClass("fixed");
        }
      });
    // for mobile - you nedd to uncomment line below too
    //}
  }
});


</script>
<script>
    	$('.switch input').click(function(){
        	//alert($(this).val());
        	if($(this).val() == "true"){
                var jk = "false";
                $.ajax({
                    'type': 'POST',
                    'url': "{{ route('publicgoOnline', 'false') }}",
                    'data': { 'go_online': 'false'},
                    success: function(res){
                        $(".prosetting").html('<p>'+res.response+'</p>');
                        $(".prosetting").css('display','block');
                        $(".prosetting").delay(15000).fadeOut(500);
                        console.log('false');
                    }
                });
            }else{
                var jk = "true";
                $.ajax({
                    'type': 'POST',
                    'url': "{{ route('publicgoOnline', 'true') }}",
                    'data': {'go_online': 'true'},
                    success: function(res){
                        $(".prosetting").html('<p>'+res.response+'</p>');
                        $(".prosetting").css('display','block');
                        $(".prosetting").delay(15000).fadeOut(500);
                        console.log('true');
                    }
                });
            }
            $(this).val(jk);
        });


    </script>
    <script type="text/javascript">
        $(function () {
            var url = $("#add-change").find("option:selected").attr('img-path');
            var image_url = '/img-dist/ads/'+url;
                $('.add-img-preview').find('img').attr('src',image_url);
            $("#add-change").change(function () {
                var url = $(this).find("option:selected").attr('img-path');
                var image_url = '/img-dist/ads/'+url;
                $('.add-img-preview').find('img').attr('src',image_url);
            });
        });
    </script>
    <script>
        function editAns(id, ans) {
            $("#edit-answer-modal").trigger( "click" );
           $("#answer-id").val(id);
           $("#answer-text").val(ans);
        }
        function deleteAns(id, qId) {
            $("#delete-answer-modal").trigger( "click" );
           $("#answer-id-delete").val(id);
           $("#question-id-delete").val(qId);
        }
        function resultDetail(ansName, answered, percentage) {
            $("#answer-details-servey-modal").trigger( "click" );
            $("#ans-name-servey").text(ansName);
            if(answered == 1){
                $("#total-answered-servey").text(answered+' Respondent');
            }else{
                $("#total-answered-servey").text(answered+' Respondents');
            }
            $("#total-percentage-servey").text(percentage+'%');
        }
    </script>
</body>
</html>
