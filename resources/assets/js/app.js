
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
var VueTouch = require('vue-touch');
Vue.use(VueTouch)

window.Vue.prototype.authorize = function (handler) {
	return handler(window.Laravel.user);
}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.moment = require('moment');

Vue.component('dropdown-nav', require('./components/DropdownNavigation.vue'));

Vue.component('category-list', require('./components/onboarding/CategoryList.vue'));
Vue.component('debate', require('./components/game/Debate.vue'));
Vue.component('reply', require('./components/game/Reply.vue'));

Vue.filter('timeago', function(value) {
            return moment.utc(value).fromNow();
        });

Vue.filter('dateAgo', function(value) {
            return moment.utc(value).fromNow();
        });

const app = new Vue({
    el: '#app',
});


require('./components/phone-validation.js');

jQuery(document).ready(function($) {

	// Onboarding Categories
	$('.onboarding-category').click(function() {
		var checkbox = $(this).children('input[type=checkbox]');
		$(this).toggleClass('is-selected');
		if (checkbox.prop('checked') ) {
			checkbox.prop( "checked", false );
		} else {
			checkbox.prop( "checked", true );
		}
	});


	// Sortable Table Rows
    $("[data-debate]").click(function() {
        window.location = '../debates/' + $(this).data("debate");
    });

});

