<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Ember UserApp Demo</title>
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/shop/css/style.css">
  <link rel="stylesheet" href="/assets/shop/css/default-theme.css">
  <link rel="stylesheet" href="/assets/shop/css/emberui.css">
</head>
<body>
  <script type="text/x-handlebars">
    <div class="container">
      <div class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">Verve Shop</a>
        </div>
        <div class="navbar-collapse collapse">
          {{#if user.authenticated}}
            <ul class="nav navbar-nav">
              <li>{{#link-to 'subscribe'}}Subscribe{{/link-to}}</li>
            </ul>
          {{/if}}
          <ul class="nav navbar-nav pull-right">
            {{#unless user.authenticated}}
              <li>{{#link-to 'login'}}Log In{{/link-to}}</li>
              <li>{{#link-to 'signup'}}Sign Up{{/link-to}}</li>
            {{else}}
              <li><a href="#" {{ action 'logout' }}>Log Out</a></li>
            {{/unless}}
          </ul>
        </div>
      </div>

      {{outlet}}
    </div>
  </script>

  <script type="text/x-handlebars" data-template-name="index">
    <div class="jumbotron">
      <h2>Hi {{user.current.first_name}}! Welcome to Ember.js with UserApp</h2>
      <p>This is a simple demo app that illustrates how to add user authentication to an Ember.js app with UserApp.</p>
    </div>
  </script>

  <script type="text/x-handlebars" data-template-name="signup">
    <form class="form" {{action signup on='submit'}}>
      <h2 class="form-heading">Please Sign Up</h2>
      <div class="form-fields">
        {{input id='name' placeholder='First Name' class='form-control' value=first_name}}
        {{input id='email' placeholder='Email' class='form-control' value=email}}
        {{input id='username' placeholder='Username' class='form-control' value=username}}
        {{input id='password' placeholder='Password' class='form-control' type='password' value=password}}
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">
        {{#if loading}}
          <img src="https://app.userapp.io/img/ajax-loader-transparent.gif">
        {{else}}
          Sign Up
        {{/if}}
      </button>
      {{#if error}}
        <div class="alert alert-danger">{{error.message}}</div>
      {{/if}}
    </form>
  </script>

  <script type="text/x-handlebars" data-template-name="login">
    <form class="form" {{action login on='submit'}}>
      <h2 class="form-heading">Please Log In</h2>
      <div class="form-fields">
        {{input id='username' placeholder='Username' class='form-control' value=username}}
        {{input id='password' placeholder='Password' class='form-control' type='password' value=password}}
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">
        {{#if loading}}
          <img src="https://app.userapp.io/img/ajax-loader-transparent.gif">
        {{else}}
          Log In
        {{/if}}
      </button>
      {{#if error}}
        <div class="alert alert-danger">{{error.message}}</div>
      {{/if}}
    </form>
  </script>
  
  <script type="text/x-handlebars" data-template-name="article">
    <div class="row">
      {{#each model}}
      <div class="col-lg-4">
        <h2>{{title}}</h2>
        <p>{{body}}</p>
      </div>
      {{/each}}
    </div>
  </script>
  
  <script type="text/x-handlebars" data-template-name="subscribe">
		<form action="/subscribe.php" method="POST" id="payment-form">
            <div class="form-row">
                <label>Card Number</label>
                <input type="text" size="20" autocomplete="off" class="card-number" value="4242424242424242" />
            </div>
            <div class="form-row">
                <label>CVC</label>
                <input type="text" size="4" autocomplete="off" class="card-cvc" value="971" />
            </div>
            <div class="form-row">
                <label>Expiration (MM/YYYY)</label>
                <input type="text" size="2" class="card-expiry-month" value="12"/>
                <span> / </span>
                <input type="text" size="4" class="card-expiry-year" value="2017"/>
            </div>
            <button type="submit" class="submit-button">Submit Payment</button>
        </form>
  </script>

   <script type="text/x-handlebars" data-template-name="preference">
		<h1>Preferences</h1>
		<h4>Partner's First Name:</h4><br/>
		{{eui-input placeholder='Partner\'s First Name' value=model.partners_firstname}}<br/>
		<h4>Your date of birth:</h4><br/>
		{{eui-input placeholder="dd/mm/yyyy" value=model.dob error=dobValid}}<br/>
		<h4>Gender:</h4><br/>
		{{eui-select value=model.gender options=genders}}<br/>
		<h4>Address:</h4><br/>
		{{eui-textarea value=model.address placeholder='Address'}}<br/>
		<h4>Your mobile number:</h4><br/>
		{{eui-input value=model.mobile error=mobileValid  placeholder='Your mobile number'}}<br/>
		<h4>Date for your first date (approximate):</h4><br/>
		{{eui-calendar selection=model.date_date_moment showNextMonth=false}}<br/>
		<h4>Best Day for your dates (future):</h4><br/>
		{{eui-select value=model.date_days options=days}}<br/>
		<h4>Duration for your dates (hours):</h4><br/>
		{{eui-input value=model.date_duration placeholder='Ex. 6 hours'}}<br/>
		<h4>Distance willing to travel:</h4><br/>
		{{eui-input value=model.travel_distance placeholder='Ex. 6 km'}}<br/>
		<h4>Your anniversary date:</h4><br/>
		{{eui-input placeholder="dd/mm/yyyy" value=model.anniversary error=anniversaryValid}}<br/>
		<h4>Number of children:</h4><br/>
		{{eui-input value=model.children error=childrenValid placeholder='Ex. 3'}}<br/>
		<h4>Music Preference:</h4><br/>
		{{eui-select value=model.likes_music options=musics}}<br/>
		<h4>Food Preference:</h4><br/>
		{{eui-select value=model.likes_food options=foods}}<br/>
		<h4>Adventure Preference:</h4><br/>
		{{eui-select value=model.likes_adventure options=adventures}}<br/>
		<h4>Physical Preference:</h4><br/>
		{{eui-select value=model.likes_physical options=physicals}}<br/>
		<h4>Alcohol Preference:</h4><br/>
		{{eui-select value=model.likes_alcohol options=alcohols}}<br/>
		<h4>Special Needs (Allergies/Dislikes/Eating Requirements):</h4><br/>
		{{eui-textarea value=model.special_needs placeholder='Ex. Gluten Free'}}<br/>
		<br/><br/><br/>
		{{eui-button label='Save Preferences' action="savePreferences"}}
   </script>
   
   <script type="text/x-handlebars" data-template-name="feedback">
		<h1>Preferences</h1>
   </script>

   <script type="text/x-handlebars" data-template-name="transacted">
		<h1>Succcessful Transaction</h1>
		{{#link-to 'preference'}}Now tell us what you'd like to do.{{/link-to}}
   </script>

   <script type="text/x-handlebars" data-template-name="declined">
		<h1>Declined</h1>
   </script>
   
    
  <script src="/assets/shop/js/libs/jquery.js"></script>
  <script src="/assets/shop/js/libs/handlebars.js"></script>
  <script src="/assets/shop/js/libs/ember.js"></script>
  <script src="/assets/shop/js/libs/ember-data.min.js"></script>
  <script src="/assets/shop/js/libs/userapp.client.js"></script>
  <script src="/assets/shop/js/libs/ember-userapp.js"></script>
  <script type="text/javascript" src="https://js.stripe.com/v1/"></script>

<!--   <script src="/assets/shop/js/libs/loader.js"></script>
  <script src="/assets/shop/js/libs/ember-resolver.min.js"></script> 
 -->  
  <script src="/assets/shop/js/libs/list-view.js"></script>
  <script src="/assets/shop/js/libs/moment.js"></script>
  <script src="/assets/shop/js/libs/twix.min.js"></script>
  <script src="/assets/shop/js/libs/velocity.min.js"></script>
  <script src="/assets/shop/js/libs/velocity.ui.min.js"></script>
  <script src="/assets/shop/js/libs/emberui.js"></script>

  <script src="/assets/shop/js/app.js"></script>

  
</body>
</html>
