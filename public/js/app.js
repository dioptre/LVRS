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
  this.route('preferences');
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
				UserApp.User.PaymentMethod.save({
					user_id: 'self',
					name: 'Stripe',
					processor: 'stripe',
					type: 'creditcard',
					data: { token_id: response.id, amount: 250 }
				}, function(error, result) {
					// handle error/result
				});
				UserApp.User.save({
					user_id: 'self',
					subscription: {
						price_list_id: '8OGiDhNcRiCmuQNcGkzZ0A',
						plan_id: 'ebgLXRIrR3qDGu_frfNksA'
					}
				});
				
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

App.Preference = DS.Model.extend({
	partners_firstname: '',
	dob: '',
	gender: '',
	address: '',
	mobile_phone: '',
	date_date: '', 
	date_days: '', 
	date_duration: '',
	travel_distance: '',
	anniversary_date: '',
	children: '',
	likes_music: '',
	likes_alcohol: '',
	likes_adventure: '',
	likes_physical: '',
	likes_food: '',
	allergies: '',
	dislikes: ''  
});

App.Feedback = DS.Model.extend({
	date_date: '',
	feedback: ''
});
