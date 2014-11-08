

Ember.Application.initializer({
  name: 'emberfire:firebase',
  initialize: function(container, application) {
  	var firebase = new Firebase('https://burning-fire-4834.firebaseio.com/');
    application.register('emberfire:firebase', firebase, { instantiate: false, singleton: true });
	      Ember.A(['model', 'controller', 'view', 'route', 'adapter', 'component']).forEach(function(component) {
	        application.inject(component, 'firebase', 'emberfire:firebase');
	      });
  }
});

App = Ember.Application.create();

Ember.Lvrs = {};
Ember.Lvrs.InjectUser = function (user) {
	App.register('emberfire:user', user , { instantiate: false, singleton: true });
	Ember.A(['model', 'controller', 'view', 'route', 'component']).forEach(function(component) {
  		App.inject(component, 'user', 'emberfire:user');
	});
}
Ember.Lvrs.SubscriptionOnlyRouteMixin = Ember.Mixin.create({
	beforeModel: function(transition) {
		var _this = this;
	    return new Ember.RSVP.Promise(function(resolve, reject) {
			if (!_this.get('user')) {
		  		var authData = _this.get('firebase').getAuth();
				if (authData) {
					_this.store.find('user', authData.uid).then(function (user) {
					    Ember.Lvrs.InjectUser(user);
					    if (!user.get('subscription')) {
					    	transition.abort();
			    			_this.transitionTo('index');
			    			reject('Not a subscriber.')
					    }
					    else {
					    	resolve();
					    }
					})
				}
				else {
				    transition.abort();
				    _this.transitionTo('login');
				    reject('Not logged in.')
				}
			}
			else if (!_this.get('user.subscription')) {
			    transition.abort();
			    _this.transitionTo('index');
			    reject('Not a subscriber.')
			}
			else {
				resolve();
			}
		});
	}
});
Ember.Lvrs.ApplicationRouteMixin = Ember.Mixin.create({

});
Ember.Lvrs.FormControllerMixin = Ember.Mixin.create({
	cv : true,
	credentialsValid: function(key, value, previousValue) {
		if (arguments.length > 1) {
      		this.set('cv', value)
	    }
	    // getter
	    return this.get('cv');
	}.property('email', 'password'),
	emailValid: function () {
		if (this.get('email'))
			return !this.get('email').match(/[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/); //'
		else return true;
	}.property('email'),
	fullNameValid: function () {
		return (this.get('fullName') && this.get('fullName').length > 0)
	}.property('fullName'),
	actions: {
		login: function() {
			var _this = this;
			this.get('firebase').authWithPassword({
			  email    : this.get('email'),
			  password : this.get('password')
			}, function(err, authData) {
			  if (err) {
			    switch (err.code) {
			      case "INVALID_EMAIL":
			      // handle an invalid email
			      case "INVALID_PASSWORD":
			      // handle an invalid password
			      default:
			    }
			    _this.set('cv', false);
			  } else if (authData) {
			  	var _authData = authData;
			    // user authenticated with Firebase
			    console.log("Logged In! User ID: " + authData.uid);
			    if (!_this.get('user')) {
				    _this.store.find('user', authData.uid).then(function (user) {
				    	Ember.Lvrs.InjectUser(user);
				    	_this.set('cv', true);
				    	_this.transitionToRoute('index');
				    }).catch(function (reason) {
				    	if (_this.get('fullName')) {
						    var fullName = _this.get('fullName').split(" ");
						    var lastName = null;
						    var firstName = fullName[0];
						    if (fullName.length > 1)
						    	lastName = fullName[fullName.length - 1];
						    user = _this.store.createRecord('user', {id: _authData.uid, firstName: firstName, lastName: lastName});
						    user.save();
				    	}
				    	Ember.Lvrs.InjectUser(user);
				    	_this.set('cv', true);
				    	_this.transitionToRoute('index');
				    });
				}
				else {
					_this.set('cv', true);
				    _this.transitionToRoute('index');
				}
			    
				
			  }
			});

		},
		signup: function() {
			var _this = this;
			this.get('firebase').createUser({
			  email    : this.get('email'),
			  password : this.get('password')
			}, function(error) {
			  if (error === null) {
			    console.log("User created successfully");
			    _this.send('login');
			  } else {
			    console.log("Error creating user:", error);
			  }
			});
	  	}
	  }
});
Ember.Lvrs.ProtectedRouteMixin = Ember.Mixin.create({
	beforeModel: function(transition) {
		var _this = this;
	    return new Ember.RSVP.Promise(function(resolve, reject) {
  			Ember.run.scheduleOnce('sync', App, function() {
		    	if (!_this.get('user')) {
		    		var authData = _this.get('firebase').getAuth();
					if (authData) {
						_this.store.find('user', authData.uid).then(function (user) {
						    	Ember.Lvrs.InjectUser(user);
						    	resolve();
						}).catch(function (reason) {
							transition.abort();
							_this.transitionTo('login');
							reject('Not valid user - could not fetch details')
						});
					}
					else {
						_this.transitionTo('login');	
						reject('Not valid user - not logged in')
					}	    	
		    	}
		    	else {
		    		if (this.get('user') && (transition.targetName === 'signup' || transition.targetName === 'login')) {
						transition.abort();
						this.transitionTo('index');
					}
					resolve();
		    	}
		    });
  		});

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
  this.route('feedback');
  this.route('paymentMethod');
  this.route('invoices');
});


App.ApplicationRoute = Ember.Route.extend(Ember.Lvrs.ApplicationRouteMixin);
App.SignupController = Ember.Controller.extend(Ember.Lvrs.FormControllerMixin);
App.LoginController = Ember.Controller.extend(Ember.Lvrs.FormControllerMixin);
App.IndexRoute = Ember.Route.extend(Ember.Lvrs.ProtectedRouteMixin);

App.SubscribeRoute = Ember.Route.extend(Ember.Lvrs.SubscriptionOnlyRouteMixin);
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
App.ArticleRoute = Ember.Route.extend(Ember.Lvrs.ProtectedRouteMixin, {
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

App.ApplicationAdapter = DS.FirebaseAdapter.extend({
    //firebase: new Firebase('https://slo2606sr0d.firebaseio-demo.com/')
});



// App.ApplicationSerializer = DS.RESTSerializer.extend({
    // primaryKey: 'id',
    // serializeId: function(id) {
        // return id.toString();
    // }
// });

App.Article = DS.Model.extend({
  title: DS.attr('string')
});


App.PreferenceRoute = Ember.Route.extend(Ember.Lvrs.SubscriptionOnlyRouteMixin, {
	model: function() {
		return this.get('user');
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
	  { label: '60s', value: '60s' },
	  { label: '70s', value: '70s' },
	  { label: '80s', value: '80s' },
	  { label: '90s', value: '90s' },
	  { label: 'Classical', value: 'cla' },
	  { label: 'Country', value: 'cnt' },
	  { label: 'Electro', value: 'elc' },
	  { label: 'Folk', value: 'flk' },
	  { label: 'Jazz', value: 'jaz' },
	  { label: 'Pop', value: 'pop' },
	  { label: 'Rap', value: 'rnb' },
	  { label: 'RnB', value: 'rnb' },
	  { label: 'Rock', value: 'rck' },
	  { label: 'Rockabilly', value: 'rby' },
	  { label: 'Roots', value: 'rts' },
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
	times: [
	  { label: 'Morning', value: 'mor' },
	  { label: 'Midday', value: 'mid' },
	  { label: 'Afternoon', value: 'aft' },
	  { label: 'Evening', value: 'eve' }
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
			this.get('user').save();
			// var _this = this;
			// var p = {};
			// $.each(this.get('content.constructor.attributes').keys.list, function (i,v) {
			// 		p[v] = {"value": _this.get('model.' + v), "override": true };
			// });
			// debugger;
			// UserApp.User.save({
			// 	"user_id": 'self',
			// 	"properties": p
			// }, function (error,result) {
			// 	//console.log(error, result);
			// });
		}
	}
});

App.User = DS.Model.extend({
	subscription: DS.attr(''),
	firstName:  DS.attr('', {defaultValue: ''}),
	lastName:  DS.attr('', {defaultValue: ''}),
	partners_firstname: DS.attr('', {defaultValue: ''}),
	dob: DS.attr('', {defaultValue: ''}),
	gender: DS.attr('', {defaultValue: ''}),
	address: DS.attr('', {defaultValue: ''}),
	mobile: DS.attr('', {defaultValue: ''}),
	date_time: DS.attr('', {defaultValue: ''}),
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
