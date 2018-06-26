<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Redirect::to('/login');
});
//Route::get('/jk-message', 'TwilioController@index');

Auth::routes();

// followes
// Route::resource('followers', 'FollowerController');
    
Route::group(['namespace' => 'Socialite'], function () {
    // Facebook
    Route::get('/facebook/redirect', 'FacebookAuthController@create');
    Route::get('/facebook/callback', 'FacebookAuthController@store');

    // Google
    Route::get('/google/redirect', 'GoogleAuthController@create');
    Route::get('/google/callback', 'GoogleAuthController@store');

    // Twitter
    Route::get('/twitter/redirect', 'TwitterAuthController@create');
    Route::get('/twitter/callback', 'TwitterAuthController@store');
});



Route::group(['namespace' => 'Game'], function () {

    Route::get('/home', function () {
        return redirect()->route('publicDashboardIndex');
    });

    // Categories
    Route::group(['namespace' => 'Onboarding', 'prefix' => 'onboarding','middleware' => ['frontuser']], function () {
        Route::get('/account', [
            'as' => 'onboardingAccountCreate', 'uses' => 'AccountController@create'
        ]);
        Route::post('/account', [
            'as' => 'onboardingAccountStore', 'uses' => 'AccountController@store'
        ]);

        Route::get('/categories', [
            'as' => 'onboardingCategoryCreate', 'uses' => 'CategoryController@create'
        ]);
        Route::post('/categories', [
            'as' => 'onboardingCategoryStore', 'uses' => 'CategoryController@store'
        ]);
        
       // Route::resource('fingerprints', 'FingerprintController');
    });


    Route::group(['namespace' => 'Ontracking', 'prefix' => 'ontracking'], function () {
        Route::post('/fingerprints', [
            'as' => 'ontrackingFingerprintStore', 'uses' => 'FingerprintController@store'
        ]);
    });


    Route::get('/feed', [
        'as' => 'publicDashboardIndex', 'uses' => 'Dashboard\DashboardController@index'
    , 'middleware' => ['frontuser'] ]);

    Route::post('/feed', [
        'as' => 'publicDashboardIndex', 'uses' => 'Dashboard\DashboardController@index'
    , 'middleware' => ['frontuser'] ]);

    Route::post('/loaddata', [
        'as' => 'publicDashboardLoadData', 'uses' => 'Dashboard\DashboardController@loadDataAjax'
    , 'middleware' => ['frontuser'] ]);

    Route::post('/share_box', [
        'as' => 'hideDashboardSharebox', 'uses' => 'Dashboard\DashboardController@share_box'
    ]);



    Route::post('/load_follow_suggestion', [
        'as' => 'publicFollowSuggestions', 'uses' => 'Dashboard\DashboardController@load_follow_suggestion'
    ]);


    Route::get('/AdsImpression/{adId}', [
        'as' => 'publicAdsImpression', 'uses' => 'Ads\AdsController@AdsImpression'
    ]);

    Route::get('/AdsClick/{adId}', [
        'as' => 'publicAdsClick', 'uses' => 'Ads\AdsController@AdsClick'
    ]);

    Route::get('/QuesAdsClick/{adId}/{quesID}', [
        'as' => 'publicQuesAdsClick', 'uses' => 'Ads\AdsController@QuesAdsClick'
    ]);

    Route::get('/QuesAdsImpression/{adId}/{quesID}', [
        'as' => 'QuesAdsImpression', 'uses' => 'Ads\AdsController@QuesAdsImpression'
    ]);

    Route::get('/QuesAdsImpression/{adId}/{quesID}/{fID}', [
        'as' => 'QuesAdsImpression', 'uses' => 'Ads\AdsController@QuesAdsImpression'
    ]);

    


    


    Route::group(['namespace' => 'Pages', 'middleware' => ['frontuser']], function () {
        // support
        Route::get('/pages/support', ['as' => 'support', 'uses' => 'PagesController@support']);
        // Learn about badges
        Route::get('/pages/badges', ['as' => 'badges', 'uses' => 'PagesController@badges']);
        // Guide of points framework
        Route::get('/pages/pointframework', ['as' => 'pointframework', 'uses' => 'PagesController@pointframework']);
    });



    // Categories
    Route::group(['namespace' => 'Categories', 'prefix' => 'categories', 'middleware' => ['frontuser']], function () {
        Route::get('/', [
            'as' => 'publicCategoryIndex', 'uses' => 'CategoryController@index'
        ]);
        Route::get('/{category}', [
            'as' => 'publicCategoryShow', 'uses' => 'CategoryController@show'
        ]);
    });

    // Questions
    Route::group(['namespace' => 'Questions', 'prefix' => 'questions', 'middleware' => ['frontuser']], function () {
        Route::get('/', [
            'as' => 'publicQuestionIndex', 'uses' => 'QuestionController@index'
        ]);
        Route::get('/{question}', [
            'as' => 'publicQuestionShow', 'uses' => 'QuestionController@show'
        ]);
    });

    // Servey
    Route::group(['namespace' => 'Serveys', 'prefix' => 'servey', 'middleware' => ['frontuser']], function () {
        Route::get('/pickanswer', [
            'as' => 'pickServeyAnswer', 'uses' => 'ServeyController@index'
        ]);
        Route::post('/single-servey-ans', [
            'as' => 'singleServeyAnswers', 'uses' => 'ServeyController@singleServeyAnswer'
        ]);
        Route::post('/multiple-servey-ans', [
            'as' => 'multipleServeyAnswers', 'uses' => 'ServeyController@multipleServeyAnswer'
        ]);
        Route::get('/instant/{id}/result', [
            'as' => 'serVeyInstantResult', 'uses' => 'ServeyController@getInstantResult'
        ]);
        Route::get('/{id}/thankyou', [
            'as' => 'serveyAnsSubmitThankyou', 'uses' => 'ServeyController@thankyou'
        ]);
    });

    // Debates
    Route::group(['namespace' => 'Debates', 'prefix' => 'debates', 'middleware' => ['frontuser']], function () {

        // challenge accept/decline
        Route::get('accept_challenge', [
            'as' => 'acceptDebateChallenge', 'uses' => 'ChallengeController@accept_challenge'
        ]);

        Route::post('save_challenge_with_arg', [
            'as' => 'saveDebateChallengeWithArg', 'uses' => 'ChallengeController@saveChallengeWithArg'
        ]);

        Route::get('decline_challenge', [
            'as' => 'declineDebateChallenge', 'uses' => 'ChallengeController@decline_challenge'
        ]);

        Route::post('join_debate', ['as' => 'joinDebate', 'uses' => 'ChallengeController@join_debate']);


        Route::post('debate_sharebox', ['as' => 'debateSharebox', 'uses' => 'DebateController@debate_sharebox']);




        // start debate 
        Route::get('/create', [
            'as' => 'publicDebateCreate', 'uses' => 'DebateOnboardingController@create', 
            'middleware' => ['auth']
        ]);

        Route::post('/get_questions', [
            'as' => 'getQuestions', 'uses' => 'DebateOnboardingController@get_question_by_category'
        ]);



        Route::get('pickaside', [
            'as' => 'pickaside', 'uses' => 'DebateOnboardingController@pick_your_side',
            'middleware' => 'App\Http\Middleware\QuestionClick'
        ]);

        // save new debate
        Route::post('/store', [
            'as' => 'publicDebateStore', 'uses' => 'DebateOnboardingController@store'
        ]);

        // show debate
        /*
        Route::get('/{debate}', [
            'middleware' => 'App\Http\Middleware\DebateClickMiddleware',
            'as' => 'publicDebateShow', 'uses' => 'DebateController@show'
        ]);
        */
        
	Route::post('invite_inner', [
            'as' => 'inviteInner', 'uses' => 'InviteInnerController@store'
        ]);
        Route::post('inviteFriends', [
            'as' => 'inviteFriends', 'uses' => 'InviteController@store'
        ]);

        Route::post('challengeForDebate', [
            'as' => 'challengeForDebate', 'uses' => 'ChallengeController@challengeForDebate'
        ]);

        // votes
        Route::group(['namespace' => 'Votes'], function () {
            Route::post('/votes', ['as' => 'publicDebateVoteStore', 'uses' => 'VoteController@store']);
            Route::post('/vote-by-third-user', ['as' => 'voteBythirdUsers', 'uses' => 'VoteController@voteByThirdUser']);
        });
        
        // Comments
        Route::group(['namespace' => 'Comments'], function () {
            Route::get('/{debate}/comments', [
                'as' => 'publicDebateCommentIndex', 'uses' => 'CommentController@index'
            ]);
            Route::post('/{debate}/comments', [
                'as' => 'publicDebateCommentStore', 'uses' => 'CommentController@store'
            ]);
            Route::get('/{debate}/comments/{comment}', [
                'as' => 'publicDebateCommentShow', 'uses' => 'CommentController@show'
            ]);
        });

        // Arguments
        Route::group(['namespace' => 'Arguments'], function () {
            Route::post('/{debate}/arguments', 'ArgumentController@store')->name('publicDebateArgumentStore');
            Route::get('/{debate}/arguments', [
                'as' => 'publicDebateArgumentIndex', 'uses' => 'ArgumentController@index'
            ]);
            Route::get('/{debate}/arguments/{argument}', [
                'as' => 'publicDebateArgumentShow', 'uses' => 'ArgumentController@show'
            ]);
        });
    });


    // Debates
    Route::group(['namespace' => 'Debates', 'prefix' => 'debates'], function () {
        // show debate
        Route::get('/{debate}', [
            'middleware' => 'App\Http\Middleware\DebateClickMiddleware',
            'as' => 'publicDebateShow', 'uses' => 'DebateController@show'
        ]);
    });

    // Player Namespace
    Route::group(['namespace' => 'Players', 'prefix' => 'players', 'middleware' => ['frontuser']], function () {


        Route::post('/changePassword', [
            'as' => 'playerChangePassword', 'uses' => 'PlayerController@changePassword', 
            'middleware' => ['auth']
        ]);

        Route::get('notificationSetting/{status}', [
            'as' => 'publicnotificationSetting', 'uses' => 'PlayerController@notificationSetting'
        ]);
        Route::post('notificationSetting/{status}', [
            'as' => 'publicnotificationSetting', 'uses' => 'PlayerController@notificationSetting'
        ]);

        Route::get('/changePassword', [
                'as' => 'playerChangePassword', 'uses' => 'PlayerController@showChangePasswordForm',
                'middleware' => ['auth']
            ]);

        Route::get('/offerfeedbackemail/{email}', [
            'as' => 'publicPlayerOfferfeedbackemail', 'uses' => 'PlayerController@offerfeedbackemail'
        ]);

        Route::get('/proposequestionemail/{email}', [
            'as' => 'publicPlayerProposequestionemail', 'uses' => 'PlayerController@proposequestionemail'
        ]);

        Route::post('/offerfeedbackemail/{email}', [
            'as' => 'publicPlayerOfferfeedbackemail', 'uses' => 'PlayerController@offerfeedbackemail'
        ]);

        Route::post('/proposequestionemail/{email}', [
            'as' => 'publicPlayerProposequestionemail', 'uses' => 'PlayerController@proposequestionemail'
        ]);

        Route::get('/my-category', ['as'=> 'my-category', 'uses' => 'PlayerController@myCategory',
                'middleware' => ['auth']]);
         Route::post('/update-my-category', ['as'=> 'update-my-category', 'uses' => 'PlayerController@updateMyCategory']);
        // player profiles for public
        /*
        Route::get('/{handle}', [
            'as' => 'publicPlayerShow', 'uses' => 'PlayerController@show'
        ]);
        */

        // pro player contest for public
        Route::get('/{id}/contests', [
            'as' => 'publicPlayerContest', 'uses' => 'PlayerController@contests'
        ]);




        // profile namespace For logged in user 
        Route::group(['namespace' => 'Profile'], function () { 

            // profile
            Route::resource('profile', 'ProfileController');
            
            // follower
            Route::post('/follow', [
                'as' => 'publicAjaxFollow', 'uses' => 'FollowerController@follow'
            ]);
            
            // follower
            Route::post('/make_favorite', [
                'as' => 'ajaxMakeFavorite', 'uses' => 'FollowerController@make_favorite'
            ]);

            Route::resource('followers', 'FollowerController');

        });
    });



    // Player Namespace without login
    Route::group(['namespace' => 'Players', 'prefix' => 'players'], function () {
        // player profiles for public

        Route::get('/contestClick/{contestId}', [
            'as' => 'publicContestClick', 'uses' => 'PlayerController@contestClick'
        ]);

        Route::get('/eventClick/{eventId}', [
            'as' => 'publicEventClick', 'uses' => 'PlayerController@eventClick'
        ]);

        
        Route::get('/{handle}', [
            'as' => 'publicPlayerShow', 'uses' => 'PlayerController@show'
        ]);
        Route::get('/contestImpression/{contestId}', [
            'as' => 'publicContestImpression', 'uses' => 'PlayerController@contestImpression'
        ]);
        Route::get('/eventImpression/{eventId}', [
            'as' => 'publicEventImpression', 'uses' => 'PlayerController@eventImpression'
        ]);
        
    });

}); // Game



// Partners
Route::group(['namespace' => 'Partner', 'prefix' => 'partners','middleware' => ['prouser']], function () {

    Route::get('/', function () {
        return redirect()->route('partnerLiveQuestionIndex');
    });

     // Pro Settings
    Route::group(['namespace' => 'ProSettings', 'prefix' => 'prosettings'], function () {

       Route::get('goOnline/{status}', [
            'as' => 'publicgoOnline', 'uses' => 'ProSettingsController@goOnline'
        ]);
        Route::post('goOnline/{status}', [
            'as' => 'publicgoOnline', 'uses' => 'ProSettingsController@goOnline'
        ]);
        
    });

     // Ads
    Route::group(['namespace' => 'Ads', 'prefix' => 'ads'], function () {
        Route::get('/', [
            'as' => 'partnerAdIndex', 'uses' => 'AdController@index'
        ]);
        Route::get('/draft', [
            'as' => 'partnerDraftAdIndex', 'uses' => 'DraftAdController@index'
        ]);
        Route::get('/deactivated', [
            'as' => 'partnerDeactivatedAdIndex', 'uses' => 'DeactivatedAdController@index'
        ]);
        Route::get('/scheduled', [
            'as' => 'partnerScheduledAdIndex', 'uses' => 'ScheduledAdController@index'
        ]);
        Route::get('/expired', [
            'as' => 'partnerExpiredAdIndex', 'uses' => 'ExpiredAdController@index'
        ]);
        Route::get('/create', [
            'as' => 'partnerAdCreate', 'uses' => 'AdController@create'
        ]);
        Route::post('/store', [
            'as' => 'partnerAdStore', 'uses' => 'AdController@store'
        ]);
        Route::post('/edit/{id}', [
            'as' => 'partnerAdEdit', 'uses' => 'AdController@edit'
        ]);
        Route::get('/edit/{id}', [
            'as' => 'partnerAdEdit', 'uses' => 'AdController@edit'
        ]);
        Route::post('/update/{id}', [
            'as' => 'partnerAdUpdate', 'uses' => 'AdController@update'
        ]);
        Route::get('/update/{id}', [
            'as' => 'partnerAdUpdate', 'uses' => 'AdController@update'
        ]);
         Route::post('/deactivate/{id}', [
            'as' => 'partnerAdDeactivate', 'uses' => 'AdController@deactivate'
        ]);
        Route::get('/deactivate/{id}', [
            'as' => 'partnerAdDeactivate', 'uses' => 'AdController@deactivate'
        ]);
        Route::get('/show/{id}', [
            'as' => 'partnerAdShow', 'uses' => 'AdController@show'
        ]);
        Route::post('/show/{id}', [
            'as' => 'partnerAdShow', 'uses' => 'AdController@show'
        ]);
       
    });
	
	// Contests
    Route::group(['namespace' => 'Contests', 'prefix' => 'contests'], function () {
        Route::get('/', [
            'as' => 'partnerContestIndex', 'uses' => 'ContestController@index'
        ]);
		Route::post('/store', [
            'as' => 'partnerContestStore', 'uses' => 'ContestController@store'
        ]);
		Route::get('/store', [
            'as' => 'partnerContestStore', 'uses' => 'ContestController@store'
        ]);
        Route::get('/draft', [
            'as' => 'partnerDraftContestIndex', 'uses' => 'DraftContestController@index'
        ]);
        Route::get('/deactivated', [
            'as' => 'partnerDeactivatedContestIndex', 'uses' => 'DeactivatedContestController@index'
        ]);
        Route::get('/scheduled', [
            'as' => 'partnerScheduledContestIndex', 'uses' => 'ScheduledContestController@index'
        ]);
        Route::get('/expired', [
            'as' => 'partnerExpiredContestIndex', 'uses' => 'ExpiredContestController@index'
        ]);
        Route::get('/create', [
            'as' => 'partnerContestCreate', 'uses' => 'ContestController@create'
        ]);
        
        Route::post('/edit/{id}', [
            'as' => 'partnerContestEdit', 'uses' => 'ContestController@edit'
        ]);
        Route::get('/edit/{id}', [
            'as' => 'partnerContestEdit', 'uses' => 'ContestController@edit'
        ]);
        Route::post('/update/{id}', [
            'as' => 'partnerContestUpdate', 'uses' => 'ContestController@update'
        ]);
        Route::get('/update/{id}', [
            'as' => 'partnerContestUpdate', 'uses' => 'ContestController@update'
        ]);
         Route::post('/deactivate/{id}', [
            'as' => 'partnerContestDeactivate', 'uses' => 'ContestController@deactivate'
        ]);
        Route::get('/deactivate/{id}', [
            'as' => 'partnerContestDeactivate', 'uses' => 'ContestController@deactivate'
        ]);
        Route::get('/show/{id}', [
            'as' => 'partnerContestShow', 'uses' => 'ContestController@show'
        ]);
        Route::post('/show/{id}', [
            'as' => 'partnerContestShow', 'uses' => 'ContestController@show'
        ]);
    });
	
	// Events
    Route::group(['namespace' => 'Events', 'prefix' => 'events'], function () {
        Route::get('/', [
            'as' => 'partnerEventIndex', 'uses' => 'EventController@index'
        ]);
		Route::post('/store', [
            'as' => 'partnerEventStore', 'uses' => 'EventController@store'
        ]);
		Route::get('/store', [
            'as' => 'partnerEventStore', 'uses' => 'EventController@store'
        ]);
        Route::get('/draft', [
            'as' => 'partnerDraftEventIndex', 'uses' => 'DraftEventController@index'
        ]);
        Route::get('/deactivated', [
            'as' => 'partnerDeactivatedEventIndex', 'uses' => 'DeactivatedEventController@index'
        ]);
        Route::get('/scheduled', [
            'as' => 'partnerScheduledEventIndex', 'uses' => 'ScheduledEventController@index'
        ]);
        Route::get('/expired', [
            'as' => 'partnerExpiredEventIndex', 'uses' => 'ExpiredEventController@index'
        ]);
        Route::get('/create', [
            'as' => 'partnerEventCreate', 'uses' => 'EventController@create'
        ]);
        
        Route::post('/edit/{id}', [
            'as' => 'partnerEventEdit', 'uses' => 'EventController@edit'
        ]);
        Route::get('/edit/{id}', [
            'as' => 'partnerEventEdit', 'uses' => 'EventController@edit'
        ]);
        Route::post('/update/{id}', [
            'as' => 'partnerEventUpdate', 'uses' => 'EventController@update'
        ]);
        Route::get('/update/{id}', [
            'as' => 'partnerEventUpdate', 'uses' => 'EventController@update'
        ]);
         Route::post('/deactivate/{id}', [
            'as' => 'partnerEventDeactivate', 'uses' => 'EventController@deactivate'
        ]);
        Route::get('/deactivate/{id}', [
            'as' => 'partnerEventDeactivate', 'uses' => 'EventController@deactivate'
        ]);
        Route::get('/show/{id}', [
            'as' => 'partnerEventShow', 'uses' => 'EventController@show'
        ]);
        Route::post('/show/{id}', [
            'as' => 'partnerEventShow', 'uses' => 'EventController@show'
        ]);
    });

    //advertiser
    Route::group(['namespace' => 'Advertisers', 'prefix' => 'advertiser'], function () {
        Route::get('/', [
            'as' => 'partnerAdvertiserIndex', 'uses' => 'AdvertiserController@index'
        ]);
        Route::get('/inactive', [
            'as' => 'partnerAdvertiserInactive', 'uses' => 'AdvertiserController@inactive'
        ]);
        Route::get('/create', [
            'as' => 'partnerAdvertiserCreate', 'uses' => 'AdvertiserController@create'
        ]);
        Route::post('/store', [
            'as' => 'partnerAdvertiserStore', 'uses' => 'AdvertiserController@store'
        ]);
        Route::match(['post', 'get'], '/edit/{id}', [
            'as' => 'partnerAdvertiserEdit', 'uses' => 'AdvertiserController@edit'
        ]);
        Route::post('/deativate/{id}', [
            'as' => 'partnerAdvertiserDeactivate', 'uses' => 'AdvertiserController@deativate'
        ]);
        Route::post('/activate/{id}', [
            'as' => 'partnerAdvertiserActivate', 'uses' => 'AdvertiserController@activate'
        ]);
        Route::post('/update', [
            'as' => 'partnerAdvertiserUpdate', 'uses' => 'AdvertiserController@update'
        ]);
    });

    //answer of question for pro
    Route::group(['namespace' => 'Answers', 'prefix' => 'manage-answer'], function () {
        Route::get('/questions/{id}/answers', [
            'as' => 'manageAnswers', 'uses' => 'AnswerController@index'
        ]);
        Route::post('/answer/store', [
            'as' => 'manageAnswersStore', 'uses' => 'AnswerController@store'
        ]);
        Route::post('/answer/update', [
            'as' => 'manageAnswersUpdate', 'uses' => 'AnswerController@update'
        ]);
        Route::post('/answer/delete', [
            'as' => 'manageAnswersDelete', 'uses' => 'AnswerController@delete'
        ]);
    });

    // Categories
    Route::group(['namespace' => 'Categories', 'prefix' => 'categories'], function () {
        Route::get('/', [
            'as' => 'partnerCategoryIndex', 'uses' => 'CategoryController@index'
        ]);
        Route::get('/deactivate', [
            'as' => 'partnerCategoryDeactivate', 'uses' => 'CategoryController@deactivate'
        ]);
        Route::get('/draft', [
            'as' => 'partnerCategoryDraft', 'uses' => 'CategoryController@draft'
        ]);
        Route::get('/{category}', [
            'as' => 'partnerCategoryShow', 'uses' => 'CategoryController@show'
        ]);
        Route::post('/store', [
            'as' => 'partnerCategoryStore', 'uses' => 'CategoryController@store'
        ]);
        Route::get('/updatestatus/{id}', [
            'as' => 'partnerCategoryUpdatestatus', 'uses' => 'CategoryController@updatestatus'
        ]);
        Route::post('/updatestatus/{id}', [
            'as' => 'partnerCategoryUpdatestatus', 'uses' => 'CategoryController@updatestatus'
        ]);
        Route::get('/edit/{id}', [
            'as' => 'partnerCategoryEdit', 'uses' => 'CategoryController@edit'
        ]);
        Route::post('/edit/{id}', [
            'as' => 'partnerCategoryEdit', 'uses' => 'CategoryController@edit'
        ]);
        Route::get('/update/{id}', [
            'as' => 'partnerCategoryUpdate', 'uses' => 'CategoryController@update'
        ]);
        Route::post('/update/{id}', [
            'as' => 'partnerCategoryUpdate', 'uses' => 'CategoryController@update'
        ]);
        Route::post('attach/ads', [
            'as' => 'attachAdsToCategory', 'uses' => 'CategoryController@attach_ads'
        ]);
        Route::get('unattach/{id}', [
            'as' => 'romoveAdFromCategory', 'uses' => 'CategoryController@unattach'
        ]);
    });

    // Questions
    Route::group(['namespace' => 'Questions', 'prefix' => 'questions'], function () {
        Route::get('/', function () {
            return redirect()->route('partnerLiveQuestionIndex');
        });
        Route::post('importCsv', [
            'as' => 'partnerQuestionImportCsv', 'uses' => 'QuestionController@importCsv'
        ]);
        Route::post('view/{id}', [
            'as' => 'partnerQuestionPreview', 'uses' => 'QuestionController@preview'
        ]);
        Route::get('view/{id}', [
            'as' => 'partnerQuestionPreview', 'uses' => 'QuestionController@preview'
        ]);
        
        Route::post('multiple-choice-question-setting', [
            'as' => 'questionSetting', 'uses' => 'QuestionController@multiChoiceSetting'
        ]);
        Route::get('/{id}/result', [
            'as' => 'questionServeyResult', 'uses' => 'QuestionController@serveyResult'
        ]);

        Route::post('unattach/{id}', [
            'as' => 'partnerQuestionUnattach', 'uses' => 'QuestionController@unattach'
        ]);
        Route::get('unattach/{id}', [
            'as' => 'partnerQuestionUnattach', 'uses' => 'QuestionController@unattach'
        ]);

        
        Route::post('nodebateassigned/{id}', [
            'as' => 'partnerQuestionPreview', 'uses' => 'QuestionController@preview'
        ]);
        Route::get('nodebateassigned/{id}', [
            'as' => 'partnerQuestionPreview', 'uses' => 'QuestionController@preview'
        ]);
        Route::post('destroy/{id}', [
            'as' => 'partnerQuestionDestroy', 'uses' => 'QuestionController@destroy'
        ]);
        Route::post('destroycomment/{id}', [
            'as' => 'partnerQuestionDestroyComment', 'uses' => 'QuestionController@destroycomment'
        ]);
        Route::get('destroycomment/{id}', [
            'as' => 'partnerQuestionDestroyComment', 'uses' => 'QuestionController@destroycomment'
        ]);
        Route::post('destroyargument/{id}', [
            'as' => 'partnerQuestionDestroyArgument', 'uses' => 'QuestionController@destroyargument'
        ]);
        Route::get('destroyargument/{id}', [
            'as' => 'partnerQuestionDestroyArgument', 'uses' => 'QuestionController@destroyargument'
        ]);
       Route::get('/supportcenter', [
            'as' => 'partnerQuestionsupport', 'uses' => 'QuestionController@support'
        ]);
        Route::get('/live', [
            'as' => 'partnerLiveQuestionIndex', 'uses' => 'LiveQuestionController@index'
        ]);
         Route::get('/draft', [
            'as' => 'partnerDraftQuestionIndex', 'uses' => 'DraftQuestionController@index'
        ]);
          Route::get('/deactivated', [
            'as' => 'partnerDeactivatedQuestionIndex', 'uses' => 'DeactivatedQuestionController@index'
        ]);
        Route::get('/scheduled', [
            'as' => 'partnerScheduledQuestionIndex', 'uses' => 'ScheduledQuestionController@index'
        ]);
        Route::get('/expired', [
            'as' => 'partnerExpiredQuestionIndex', 'uses' => 'ExpiredQuestionController@index'
        ]);
        Route::get('/create', [
            'as' => 'partnerQuestionCreate', 'uses' => 'QuestionController@create'
        ]);
        Route::post('/store', [
            'as' => 'partnerQuestionStore', 'uses' => 'QuestionController@store'
        ]);
        Route::post('/updatequestion', [
            'as' => 'partnerQuestionUpdatequestion', 'uses' => 'QuestionController@updatequestion'
        ]);
        Route::post('/update/{id}', [
            'as' => 'partnerQuestionUpdate', 'uses' => 'QuestionController@update'
        ]);
        Route::get('/update/{id}', [
            'as' => 'partnerQuestionUpdate', 'uses' => 'QuestionController@update'
        ]);
        Route::get('/activities', [
            'as' => 'partnerQuestionActivity', 'uses' => 'QuestionController@activity'
        ]);
        Route::post('/{id}', [
            'as' => 'partnerQuestionEdit', 'uses' => 'QuestionController@edit'
        ]);
        Route::get('/{id}', [
            'as' => 'partnerQuestionEdit', 'uses' => 'QuestionController@edit'
        ]);
        Route::get('/{question}', [
            'as' => 'partnerQuestionShow', 'uses' => 'QuestionController@show'
        ]);

        Route::post('attach/ads', [
            'as' => 'attachAdsToQues', 'uses' => 'QuestionController@attach_ads'
        ]);

        Route::resource('questions', 'QuestionsController');
    });


    // Debates
    Route::group(['namespace' => 'Debates', 'prefix' => 'debates'], function () {

        Route::get('/', [
            'as' => 'partnerDebateIndex', 'uses' => 'DebateController@index'
        ]);

        Route::get('/{debate}', [
            'as' => 'partnerDebateShow', 'uses' => 'DebateController@show'
        ]);

        // Comments
        Route::group(['namespace' => 'Comments'], function () {
            Route::get('/{debate}/comments', [
                'as' => 'partnerDebateCommentIndex', 'uses' => 'CommentController@index'
            ]);
            Route::get('/{debate}/comments/{comment}', [
                'as' => 'partnerDebateCommentShow', 'uses' => 'CommentController@show'
            ]);
        });

        // Arguments
        Route::group(['namespace' => 'Arguments'], function () {
            Route::get('/{debate}/arguments', [
                'as' => 'partnerDebateArgumentIndex', 'uses' => 'ArgumentController@index'
            ]);
            Route::get('/{debate}/arguments/{argument}', [
                'as' => 'partnerDebateArgumentShow', 'uses' => 'ArgumentController@show'
            ]);
        });
    });

    Route::group(['namespace' => 'Profile'], function () {
        Route::resource('proprofile', 'ProfileController');

        Route::post('attach/ads', [
            'as' => 'attachAdsToProfile', 'uses' => 'ProfileController@attach_ads'
        ]);
        Route::get('unattach/{id}', [
            'as' => 'romoveAdFromProProfile', 'uses' => 'ProfileController@unattach'
        ]);
       
    });


});









// Admin
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    
    // Categories
    Route::group(['namespace' => 'Categories', 'prefix' => 'categories'], function () {
        Route::get('/', [
            'as' => 'adminCategoryIndex', 'uses' => 'CategoryController@index'
        ]);
        Route::get('/{category}', [
            'as' => 'adminCategoryShow', 'uses' => 'CategoryController@show'
        ]);
    });

    // Questions
    Route::group(['namespace' => 'Questions', 'prefix' => 'questions'], function () {
        Route::get('/', [
            'as' => 'adminQuestionIndex', 'uses' => 'QuestionController@index'
        ]);
        Route::get('/{question}', [
            'as' => 'adminQuestionShow', 'uses' => 'QuestionController@show'
        ]);
    });

    // Debates
    Route::group(['namespace' => 'Debates', 'prefix' => 'debates'], function () {

        Route::get('/', [
            'as' => 'adminDebateIndex', 'uses' => 'DebateController@index'
        ]);
        Route::get('/{debate}', [
            'as' => 'adminDebateShow', 'uses' => 'DebateController@show'
        ]);

        // Comments
        Route::group(['namespace' => 'Comments'], function () {
            Route::get('/{debate}/comments', [
                'as' => 'adminDebateCommentIndex', 'uses' => 'CommentController@index'
            ]);
            Route::get('/{debate}/comments/{comment}', [
                'as' => 'adminDebateCommentShow', 'uses' => 'CommentController@show'
            ]);
        });

        // Arguments
        Route::group(['namespace' => 'Arguments'], function () {
            Route::get('/{debate}/arguments', [
                'as' => 'adminDebateArgumentIndex', 'uses' => 'ArgumentController@index'
            ]);
            Route::get('/{debate}/arguments/{argument}', [
                'as' => 'adminDebateArgumentShow', 'uses' => 'ArgumentController@show'
            ]);
        });
    });
});
