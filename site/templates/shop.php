<?php snippet('header') ?>


  <script type="text/x-handlebars">
    <!-- ******HEADER****** -->
    <header id="header" class="header">
        <div class="container">
            <h1 class="logo">
                <a href="/"><span class="text"><img src="/assets/LvrsLogo2.png"></span></a>
            </h1><!--//logo-->
            <nav class="main-nav navbar-right" role="navigation">
                <div class="navbar-header">
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button><!--//nav-toggle-->
                </div><!--//navbar-header-->
                <div id="navbar-collapse" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                      <?php foreach($pages->visible() as $p): ?>
                        <?php if($p->hasVisibleChildren()): ?>
                          <?php if(false): ?>
                            <li class="dropdown">
                              <a class="dropdown-toggle <?php e($p->isOpen(), ' active') ?>" href="<?php echo $p->url() ?>" data-toggle="dropdown">
                                <?php echo html($p->title()) ?>
                                <b class="caret"></b>
                              </a>

                              <ul class="dropdown-menu">
                                <?php foreach($p->children()->visible() as $p): ?>
                                  <?php if (!in_array($p->template(), array('title','section','divider'))): ?>
                                    <li>
                                      <a href="<?php echo $p->url() ?>"><?php echo html($p->title()) ?></a>
                                    </li>
                                  <?php endif ?>
                                <?php endforeach ?>
                              </ul>
                            </li>
                          <?php else: ?>
                            <li class="nav-item <?php e($p->isOpen(), ' active') ?>">
                              <a <?php e($p->isOpen(), ' class="active"') ?> href="<?php echo $p->url() ?>"><?php echo html($p->title()) ?></a>
                            </li>
                          <?php endif ?>
                        <?php else: ?>
                          <li class="nav-item <?php e($p->isOpen(), ' active') ?>">
                            <a <?php e($p->isOpen(), ' class="active"') ?> href="<?php echo $p->url() ?>"><?php echo html($p->title()) ?></a>
                          </li>
                        <?php endif ?>

                      <?php endforeach ?>

                      {{#unless user.authenticated}}
                        <li class="nav-item">{{#link-to 'login'}}Log In{{/link-to}}</li>
                        <li class="nav-item">{{#link-to 'signup'}}Sign Up{{/link-to}}</li>
                      {{else}}
                        <li class="nav-item nav-item-cta last"><a href="#">Log Out</a></li>
                      {{/unless}}
                    </ul>


                      <!--
                        <li class="nav-item"><a href="http://lvrs.uservoice.com/knowledgebase" target="_blank">FAQ</a></li>
                        <li class="nav-item"><a href="<?php echo html($site->loginurl()) ?>">Log in</a></li>
                        <li class="nav-item nav-item-cta last"><a class="btn btn-cta btn-cta-secondary" href="<?php echo html($site->signupurl()) ?>">Sign Up</a></li>
                        -->
                    </ul><!--//nav-->
                </div><!--//navabr-collapse-->
            </nav><!--//main-nav-->
        </div><!--//container-->
    </header><!--//header-->

    <div class="wrap">
      {{#if user}}
        <ul class="nav nav-tabs text-center">
          {{#if user.subscription}}
            {{#link-to 'index' tagName='li'}}
              <a>
                <i class="fa fa-dashboard"></i><br>
                Dashboard
              </a>
            {{/link-to}}
          {{/if}}

          {{#link-to 'subscribe' tagName='li'}}
            <a>
              <i class="fa fa-money"></i><br>
              Manage subscription
            </a>
          {{/link-to}}


          {{#if user.subscription}}
            {{#link-to 'preference' tagName='li' classNames="last"}}
              <a>
                <i class="fa fa-cog"></i><br>
                Preferences
              </a>
            {{/link-to}}
          {{/if}}

        </ul>
      {{/if}}
      {{outlet}}
    </div>

  </script>

  <script type="text/x-handlebars" data-template-name="loading">
    Loading...
  </script>

  <script type="text/x-handlebars" data-template-name="index">

      <h1>Dashboard</h1>
      <h2>Hi {{user.id}}, welcome back to Lvrs!</h2>

      </br></br>

      <h3>Status</h3>
      <p>Membership status: <span class="green"><b>ACTIVE</b><span></p>
  	  <p>Next Date: <b>{{user.current.properties.date_date.value}}</b></p>

      </br></br>


      <h3>Links</h3>
      <ul>
        <li>
          {{#link-to 'preference'}}
    	       <p>Preferences</p>
          {{/link-to}}
        </li>
    	  <li>
          {{#link-to 'subscribe'}}
            <p>Update Payment Details</p>
          {{/link-to}}
        </li>
      </ul>
  </script>

  <script type="text/x-handlebars" data-template-name="signup">
    {{#unless user.authenticated}}
    <div class="userapp">
      <form class="form" {{action 'signup' on='submit'}}>
        <h2 class="form-heading">Please Sign Up</h2>
        <div class="form-fields">
          {{input id='name' placeholder='Name' class='form-control' value=fullName}}
          {{input id='email' placeholder='Email' class='form-control' value=email}}
          {{input id='password' placeholder='Password' class='form-control' type='password' value=password}}
          <br/>
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
    </div>
    {{else}}
      Succcessfully logged in.
    {{/unless}}
  </script>

  <script type="text/x-handlebars" data-template-name="login">
    <div class="userapp">
      <form class="form" {{action login on='submit'}}>
        <h2 class="form-heading">Please Log In</h2>
        <div class="form-fields">
          {{input id='email' placeholder='Email' class='form-control' value=email error=emailValid}}
          {{input id='password' placeholder='Password' class='form-control' type='password' value=password}}
          {{#unless cv}}<p>Bad username/password</p>{{/unless}}
        </div>
        <br/>
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
    </div>
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
    <h1>Payment Details</h1>

    <div class="row">
          <div class="col-xs-12 col-md-4">
            <form action="/subscribe.php" method="POST" id="payment-form">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Payment Details
                    </h3>
                    <!--
                      <div class="checkbox pull-right">
                          <label>
                              <input type="checkbox" />
                              Remember
                          </label>
                      </div>
                    -->
                </div>
                <div class="panel-body">
                    <form role="form">
                    <div class="form-group">


                        <label for="cardNumber">
                            CARD NUMBER</label>
                        <div class="input-group">
                            <input type="text" class="form-control card-number" id="cardNumber" placeholder="Valid Card Number"v alue="4242424242424242" required autofocus />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-7 col-md-7">
                            <div class="form-group">
                                <label for="expityMonth">
                                    EXPIRY DATE</label>
                                <div class="col-xs-6 col-lg-6 pl-ziro">
                                    <input type="text" class="form-control card-expiry-month" id="expityMonth" placeholder="MM" required />
                                </div>
                                <div class="col-xs-6 col-lg-6 pl-ziro">
                                    <input type="text" class="form-control card-expiry-year" id="expityYear" placeholder="YYYY" required /></div>
                            </div>
                        </div>
                        <div class="col-xs-5 col-md-5 pull-right">
                            <div class="form-group">
                                <label for="cvCode">
                                    CV CODE</label>
                                <input type="password" class="form-control card-cvc" id="cvCode" placeholder="CVC" required />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="nav nav-pills nav-stacked">
                <li class="active"><a href="#"><span class="badge pull-right"><!--<span class="glyphicon glyphicon-usd"></span>-->$ 297 AUD</span> Per Month</a>
                </li>
            </ul>
            <br/>
            <button type="submit" class="submit-button btn btn-primary btn-lg btn-block">Submit Payment</button>
            </form>
        </div>

          <div class="col-xs-12 col-md-8">
            <h3>Price</h3>
            <p>A Lvrs subscription costs $297 AUD per month (including GST). Provided is one all-inclusive date with food and drinks per month.</p>

            <h3>Security</h3>
            <p>We do not store any credit card information. We use <a href="https://stripe.com/">Stripe</a> for all payment processesing.</p>
            <p>Stripe is one of the biggest and most secure payment processors available on the internet. Stripe has been audited by a PCI-certified auditor, and is certified to <a href="http://www.visa.com/splisting/searchGrsp.do?companyNameCriteria=stripe">PCI Service Provider Level 1</a>. This is the most stringent level of certification available.</p>
            <br>
            <h3>Cancelling your subscription</h3>
            <p>Your subscription is monthly. You will be able to cancel your subscription anytime.</p>

          </div>
      </div>



		{{!--<form action="/subscribe.php" method="POST" id="payment-form">
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
        </form>--}}
  </script>

   <script type="text/x-handlebars" data-template-name="preference">
    <div class="form">

  		<h1>Preferences</h1>

     {{!-- <div class="row">
        <div class="col-md-4">
          <h3>Personal details:</h3>
      		<h4>Partner's First Name:</h4><br/>
      		{{eui-input placeholder='Partner\'s First Name' value=model.partners_firstname}}<br/>
      		<h4>Your date of birth:</h4><br/>
      		{{eui-input placeholder="dd/mm/yyyy" value=model.dob error=dateValid}}<br/>
      		<h4>Gender:</h4><br/>
      		{{eui-select value=model.gender options=genders}}<br/>
      		<h4>Address:</h4><br/>
      		{{eui-textarea value=model.address placeholder='Address'}}<br/>
      		<h4>Your mobile number:</h4><br/>
      		{{eui-input value=model.mobile error=mobileValid  placeholder='Your mobile number'}}<br/>
        </div>


        <div class="col-md-8">
          <h3>Date settings:</h3>
          <div class="row">
            <div class="col-md-6">
              <h4>Date for your next date (approximate):</h4><br/>
          		{{eui-selectdate selection=model.date_date_moment}}<br/>
          		<h4>Best Day for your dates:</h4><br/>
          		{{eui-select value=model.date_days options=days}}<br/>
				<h4>Best Time for your dates:</h4><br/>
          		{{eui-select value=model.date_time options=times}}<br/>
          		<h4>Duration for your dates (hours):</h4><br/>
          		{{eui-input value=model.date_duration placeholder='Ex. 6 hours'}}<br/>
          		<h4>Distance willing to travel:</h4><br/>
          		{{eui-input value=model.travel_distance placeholder='Ex. 6 km'}}<br/>
          		<h4>Your anniversary date:</h4><br/>
          		{{eui-input placeholder="dd/mm/yyyy" value=model.anniversary error=anniversaryValid}}<br/>
            </div>
            <div class="col-md-6">
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
              <br/><br/>
              {{eui-button label='Save Preferences' action="savePreferences" style="primary"}}
            </div>
          </div>
        </div>
      </div>--}}

    </div>
   </script>

   <script type="text/x-handlebars" data-template-name="feedback">
		<h1>Feedback</h1>
   </script>

   <script type="text/x-handlebars" data-template-name="paymentMethod">
		<h1>Payment Method</h1>
   </script>

   <script type="text/x-handlebars" data-template-name="invoice">
		<h1>Invoices</h1>
   </script>


   <script type="text/x-handlebars" data-template-name="transacted">
		<h1>Succcessful Transaction</h1>
		<p>{{#link-to 'preference'}}Now tell us what you would like to do...{{/link-to}}</p>
   </script>

   <script type="text/x-handlebars" data-template-name="declined">
		<h1>Declined Transaction</h1>
		<p>{{#link-to 'subscribe'}}Please try again later...{{/link-to}}</p>
		<p>Or <a href="mailto:support@lvrs.co">contact our support team</a> if you believe there is something has gone wrong.</p>
   </script>


  <script src="/assets/shop/js/libs/jquery.js"></script>
  <script src="/assets/shop/js/libs/handlebars.js"></script>
  <script src="/assets/shop/js/libs/ember.js"></script>
  <script src="/assets/shop/js/libs/ember-data.min.js"></script>
  <script src="/assets/shop/js/libs/firebase.js"></script>
  <script src="/assets/shop/js/libs/emberfire.min.js"></script>
  <script type="text/javascript" src="https://js.stripe.com/v1/"></script>

<!--   <script src="/assets/shop/js/libs/loader.js"></script>
  <script src="/assets/shop/js/libs/ember-resolver.min.js"></script>
 -->
  <script src="/assets/shop/js/libs/list-view.js"></script>
  <script src="/assets/shop/js/libs/moment.js"></script>
  <script src="/assets/shop/js/libs/twix.min.js"></script>
  <script src="/assets/shop/js/libs/velocity.min.js"></script>
  <script src="/assets/shop/js/libs/velocity.ui.min.js"></script>
  <!-- handlebars 2 killed ember-ui essential for firebase :( <script src="/assets/shop/js/libs/emberui.js"></script>-->

  <script src="/assets/shop/js/app.js"></script>

</body>
</html>
