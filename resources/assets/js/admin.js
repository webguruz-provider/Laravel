
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue'); 
window.moment = require('moment');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('debate-table', require('./components/admin/DebateTable.vue'));
Vue.component('question-table', require('./components/admin/QuestionTable.vue'));
Vue.component('question-form', require('./components/admin/QuestionForm.vue'));
Vue.component('question-chart', require('./components/admin/QuestionChart.vue'));
Vue.component('user-table', require('./components/admin/UserTable.vue'));


class Errors {
	constructor() {
		this.errors = {};
	}
	// Access a given field's validation error
	get(field) {
		if (this.errors[field]) {
			return this.errors[field][0];
		}
	}
	// Check existance of specific error
	has(field) {
		return this.errors.hasOwnProperty(field)
	}
	// Check existance of any errors
	any() {
		return Object.keys(this.errors).length > 0;
	}
	// Capture new error bag from server
	record(errors) {
		this.errors = errors;
	}
	// Clear errors (on keydown)
	clear(field) {
		if (field) delete this.errors[field];
		this.errors = {};
	}
}

class Form {
	constructor(data) {
		this.originalData = data;
		for (let field in data) {
			this[field] = data[field];
		}
		this.errors = new Errors()
	}
	data() {
		let data = Object.assign({}, this);

		delete data.originalData;
		delete data.errors;
		return data;
	} 

	submit(requestType, url) {
		axios[requestType](url, this.data())
			.then(this.onSuccess.bind(this)) 
			.catch(this.onFail.bind(this));
	}

	onSuccess(response) {
		alert(response.data.message);
		this.reset()
	}

	onFail(error) {
		this.errors.record(error.response.data);
	}

	reset(OriginalData) {
		for (let field in this.originalData) {
			this[field] = '';
		}
		this.errors.clear();
	}

}

const app = new Vue({
    el: '#app',
    data() {
    	return {
    		form: new Form({
			    text: '',
	    		category_id: '',
	    		publish_at: '',
	    		expire_at: '',
    		}),
    	}
    },
    methods: {
    	onSubmit() {
    		this.form.submit('post', 'store')
    	}
    }
});


const Flatpickr = require("flatpickr");
const flatpickerArgs = {
	enableTime: true,
	altInput: true,
	minDate: " ",
	dateFormat: 'Y-m-d H:i:ss',
	//enableSeconds: true
}
const start = document.querySelector("[data-calendar-start]");
const end = document.querySelector("[data-calendar-end]");
if (start) new Flatpickr(start, flatpickerArgs);
if (end) new Flatpickr(end, flatpickerArgs);