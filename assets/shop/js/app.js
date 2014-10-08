var checkLoginEvent = function () { 
    UserApp.Token.heartbeat(function(error, result){
		// Handle error/result
		var currentRoute = window.location.hash.toLowerCase();
		if (error && currentRoute.indexOf('login') < 0 && currentRoute.indexOf('signup') < 0) {		
			//UserApp.User.logout();
			//window.location.hash = 'login';
		}
	});

};

Ember.Application.initializer({
  name: 'userapp',
  initialize: function(container, application) {
  	Ember.UserApp.setup(application, { appId: '542f6b2c8ea22' });
	Ember.run.scheduleOnce('sync', App, checkLoginEvent);
  }
});

App = Ember.Application.create();

Ember.Route.reopen({
  beforeModel : function(transition){
    Ember.run.scheduleOnce('sync', App, checkLoginEvent);
    this._super(transition);
  }  
});


App.Router.map(function() {
  this.route('signup');
  this.route('login');
  this.route('article');
  this.route('subscribe');
  this.route('preference');
  this.route('transacted');
  this.route('declined');
});

App.ApplicationRoute = Ember.Route.extend(Ember.UserApp.ApplicationRouteMixin);
App.SignupController = Ember.Controller.extend(Ember.UserApp.FormControllerMixin);
App.LoginController = Ember.Controller.extend(Ember.UserApp.FormControllerMixin);
App.IndexRoute = Ember.Route.extend(Ember.UserApp.ProtectedRouteMixin);

App.SubscribeRoute = Ember.Route.extend(Ember.UserApp.ProtectedRouteMixin);
App.SubscribeView = Ember.View.extend({
	didInsertElement: function () {
		// this identifies your website in the createToken call below
		Stripe.setPublishableKey('pk_test_eGxKrTUUvwyBCCwUjiwqXCBZ');

		var stripeResponseHandler = function (status, response) {
			if (response.error) {
				// re-enable the submit button
				$('.submit-button').removeAttr("disabled");
				// show the errors on the form
				$(".payment-errors").html(response.error.message);
			} else {

				var form$ = $("#payment-form");
				// token contains id, last4, and card type
				var token = response['id'];
				// insert the token into the form so it gets submitted to the server
				form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
				// and submit
				form$.get(0).submit();
			}
		}

		$(document).ready(function() {
			$("#payment-form").submit(function(event) {
				// disable the submit button to prevent repeated clicks
				$('.submit-button').attr("disabled", "disabled");

				// createToken returns immediately - the supplied callback submits the form if there are no errors
				Stripe.createToken({
					number: $('.card-number').val(),
					cvc: $('.card-cvc').val(),
					exp_month: $('.card-expiry-month').val(),
					exp_year: $('.card-expiry-year').val()
				}, stripeResponseHandler);
				return false; // submit from callback
			});
		});      
	},
	actions: {
		likesMusic: function () {
			UserApp.User.save({"user_id": 'self', properties: { "likes_music": {"value": 1, "override": true }}			
			}, function (error,result) {
				//console.log(error, result);
			});
		}
	}
});

App.ArticleController = Ember.ObjectController.extend({
	// Title: function (key, value, previousValue) {
		// // setter
		// if (arguments.length > 1) {
		  // var title = this.get('model');
		  // title.set('title', value);
		  // title.save();
		// }

		// // getter
		// return this.get('model.title');
	// }.property('model.title'),
	// actions: {

	// }
});
App.ArticleRoute = Ember.Route.extend(Ember.UserApp.ProtectedRouteMixin, {
	beforeModel: function() {
		// $.get('/articles.php', function(data) {
			// App.articlesController.set('content', data);
		// });
//	    Ember.run.scheduleOnce('sync', App, afterRenderEvent);

	},
	model: function() {
		return  this.store.findAll('article');
	}
});

DS.RESTAdapter.reopen({
  buildURL: function(klass, id) {
  if (id)
	return '/' + klass + 's.php?id=' + id;
	else
	return '/' + klass + 's.php';
    // var urlRoot = Ember.get(klass, 'url');
    // if (!urlRoot) { throw new Error('Ember.RESTAdapter requires a `url` property to be specified'); }

    // if (!Ember.isEmpty(id)) {
      // return urlRoot + "/" + id;
    // } else {
      // return urlRoot;
    // }
  }
});

// App.ApplicationAdapter = DS.RESTAdapter.extend({
    // host: 'http://verve.dev'
// });

// App.ApplicationSerializer = DS.RESTSerializer.extend({
    // primaryKey: 'id',
    // serializeId: function(id) {
        // return id.toString();
    // }
// });

App.Article = DS.Model.extend({
  title: DS.attr('string')
});


App.PreferenceRoute = Ember.Route.extend(Ember.UserApp.ProtectedRouteMixin, {	
	model: function() {
		return  this.store.createRecord('preference', {});
	}
});

App.PreferenceController = Ember.ObjectController.extend({
	genders: [
	  { label: 'Male', value: 'm' },
	  { label: 'Female', value: 'f' }
	],
	days: [
	  { label: 'Monday', value: 'mon' },
	  { label: 'Tuesday', value: 'tue' },
	  { label: 'Wednesday', value: 'wed' },
	  { label: 'Thursday', value: 'thu' },
	  { label: 'Friday', value: 'fri' },
	  { label: 'Saturday', value: 'sat' },
	  { label: 'Sunday', value: 'sun' }
	],
	musics: [
	  { label: 'Classical', value: 'cla' },
	  { label: 'Country', value: 'cnt' },
	  { label: 'Electro', value: 'elc' },
	  { label: 'Folk', value: 'flk' },
	  { label: 'Jazz', value: 'jaz' },
	  { label: 'RnB', value: 'rnb' },
	  { label: 'Rock', value: 'rck' },
	  { label: 'Rockabilly', value: 'rby' },
	  { label: 'Roots', value: 'rts' },
	  { label: '60s', value: '60s' },
	  { label: '70s', value: '70s' },
	  { label: '80s', value: '80s' },
	  { label: '90s', value: '90s' },
	  { label: 'Pop', value: 'pop' },
	  { label: 'Dislike Music', value: 'dmu' }
	],
	alcohols: [
	  { label: 'Beer', value: 'ber' },
	  { label: 'Cocktails', value: 'cck' },
	  { label: 'Shots', value: 'sht' },
	  { label: 'Whiskey', value: 'whi' },
	  { label: 'Wine', value: 'win' },
	  { label: 'Digestifs', value: 'dig' },
	  { label: 'Dislike Alcohol', value: 'dal' }
	],
	adventures: [
	  { label: 'Water', value: 'wat' },
	  { label: 'Mountains', value: 'mnt' },
	  { label: 'Air', value: 'air' },
	  { label: 'City', value: 'cit' },
	  { label: 'Dislike Adventure', value: 'dad' }  
	],
	physicals: [
	  { label: 'Upper Body', value: 'ubo' },
	  { label: 'Lower Body', value: 'lbo' },
	  { label: 'Dislike Physical Activities', value: 'dph' }
	],
	foods: [
	  { label: 'Ethnic', value: 'eth' },
	  { label: 'All you can eat', value: 'ace' },
	  { label: 'Gourmand', value: 'gou' },
	  { label: 'Dislike Food', value: 'dfo' }
	],
	dobValid: function () {
		return !moment(this.get('model.dob'), ["DD/MM/YYYY"], true).isValid()
	}.property('model.dob'),
	anniversaryValid: function () {
		return !moment(this.get('model.anniversary'), ["DD/MM/YYYY"], true).isValid()
	}.property('model.anniversary'),
	childrenValid: function () {
		return  !/^\d+$/.test(this.get('model.children'));
	}.property('model.children'),
	mobileValid: function () {
		return !/^\d+$/.test(this.get('model.mobile'));
	}.property('model.mobile'),
	actions: {
		savePreferences: function () {
			alert('hi');
		}
	}
});



App.Preference = DS.Model.extend({
	partners_firstname: DS.attr('', {defaultValue: ''}),
	dob: DS.attr('', {defaultValue: ''}),
	gender: DS.attr('', {defaultValue: ''}),
	address: DS.attr('', {defaultValue: ''}),
	mobile: DS.attr('', {defaultValue: ''}),
	date_date: DS.attr('', {defaultValue: ''}), 
	date_days: DS.attr('', {defaultValue: ''}), 
	date_duration: DS.attr('', {defaultValue: ''}),
	travel_distance: DS.attr('', {defaultValue: ''}),
	anniversary: DS.attr('', {defaultValue: ''}),
	children: DS.attr('', {defaultValue: ''}),
	likes_music: DS.attr('', {defaultValue: ''}),
	likes_food: DS.attr('', {defaultValue: ''}),
	likes_adventure: DS.attr('', {defaultValue: ''}),
	likes_physical: DS.attr('', {defaultValue: ''}),
	likes_alcohol: DS.attr('', {defaultValue: ''}),
	special_needs: DS.attr('', {defaultValue: ''}),
	date_date_moment: function (key, value, previousValue) {
		 if (arguments.length > 1) {
		  this.set('date_date', value.format("DD/MM/YYYY"));
		}
		if (moment(this.get('date_date'), ["DD/MM/YYYY"], true).isValid())
			return moment(this.get('date_date'), ["DD/MM/YYYY"]);
		else
			return '';
	}.property('date_date')
});

App.Feedback = DS.Model.extend({
	date_date: '',
	feedback: ''
});
