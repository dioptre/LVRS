<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <title><?php echo html($page->title()) ?> | <?php echo html($site->title()) ?></title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo html($site->description()) ?>" />
    <meta name="author" content="">
    <link rel="shortcut icon" href="/favicon.ico">

    <script src="//use.typekit.net/ojk0fcu.js"></script>
    <script>try{Typekit.load();}catch(e){}</script>

    <!--
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic,900,900italic,300italic,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,700,300,100' rel='stylesheet' type='text/css'>
    -->

    <!-- CSS files -->
    <?php echo css(array(
      "assets/plugins/bootstrap/css/bootstrap.min.css",
      "assets/plugins/font-awesome/css/font-awesome.css",
      "assets/shop/css/emberui-default-theme.css",
      "assets/shop/css/emberui.css",
      "assets/plugins/flexslider/flexslider.css",
      "assets/plugins/rrssb/css/rrssb.css",
      "assets/css/styles-9.css",

      "assets/css/custom-lvrs.css"
    )); ?>

    <!-- "assets/css/styles-10.css", -->

    <style>
      <?php echo html($site->css()); ?>
    </style>


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


    <?php echo js(array(
      "assets/plugins/jquery-1.11.1.min.js",
      "assets/plugins/jquery-migrate-1.2.1.min.js",
      "assets/plugins/bootstrap/js/bootstrap.min.js",
      "assets/plugins/bootstrap-hover-dropdown.min.js",
      "assets/plugins/back-to-top.js",
      "assets/plugins/jquery-placeholder/jquery.placeholder.js",
      "assets/plugins/FitVids/jquery.fitvids.js",
      "assets/plugins/flexslider/jquery.flexslider-min.js",
      "assets/plugins/imagesloaded/imagesloaded.pkgd.min.js",
      "assets/plugins/masonry.pkgd.min.js",
      "assets/plugins/rrssb/js/rrssb.min.js",
      "assets/js/blog.js",
      "assets/js/main.js"
    )); ?>

    <script>
      // Include the UserVoice JavaScript SDK (only needed once on a page)
      UserVoice=window.UserVoice||[];(function(){var uv=document.createElement('script');uv.type='text/javascript';uv.async=true;uv.src='//widget.uservoice.com/qkIZqSkIfHpTfdIXEBzWTA.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(uv,s)})();

      //
      // UserVoice Javascript SDK developer documentation:
      // https://www.uservoice.com/o/javascript-sdk
      //

      // Set colors
      UserVoice.push(['set', {
        accent_color: '#808283',
        trigger_color: 'white',
        trigger_background_color: 'rgba(46, 49, 51, 0.6)'
      }]);

      // Identify the user and pass traits
      // To enable, replace sample data with actual user traits and uncomment the line
      UserVoice.push(['identify', {
        //email:      'john.doe@example.com', // User’s email address
        //name:       'John Doe', // User’s real name
        //created_at: 1364406966, // Unix timestamp for the date the user signed up
        //id:         123, // Optional: Unique id of the user (if set, this should not change)
        //type:       'Owner', // Optional: segment your users by type
        //account: {
        //  id:           123, // Optional: associate multiple users with a single account
        //  name:         'Acme, Co.', // Account name
        //  created_at:   1364406966, // Unix timestamp for the date the account was created
        //  monthly_rate: 9.99, // Decimal; monthly rate of the account
        //  ltv:          1495.00, // Decimal; lifetime value of the account
        //  plan:         'Enhanced' // Plan name for the account
        //}
      }]);

      // Add default trigger to the bottom-right corner of the window:
      UserVoice.push(['addTrigger', { mode: 'contact', trigger_position: 'bottom-right' }]);

      // Or, use your own custom trigger:
      //UserVoice.push(['addTrigger', '#id', { mode: 'contact' }]);

      // Autoprompt for Satisfaction and SmartVote (only displayed under certain conditions)
      UserVoice.push(['autoprompt', {}]);
    </script>


    <script>
      // MIXPANEL NOT SETUP YET
      // mixpanel
      // (function(f,b){if(!b.__SV){var a,e,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");
      // for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=f.createElement("script");a.type="text/javascript";a.async=!0;a.src="//cdn.mxpnl.com/libs/mixpanel-2.2.min.js";e=f.getElementsByTagName("script")[0];e.parentNode.insertBefore(a,e)}})(document,window.mixpanel||[]);

      // google analytics
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');


      if (window.location.host === "lvrs.co"){
        console.log('LIVE ANLYTICS SETUP')
        // LVRS shared google anlytics
        ga('create', 'UA-55964340-1', 'auto');

        // Mixpanel
        //mixpanel.init("8dff7dce3b6e6f7ab2e1acc9815fb2ca"); // mixpanel dev
      } else {
        console.log('DEV ANLYTICS SETUP`')

        // Should setup a dev one as well
        ga('create', 'UA-55964340-2', 'auto'); // use the dev one
        //mixpanel.init("0672707ed6141205517c7514f9b2337b"); // mixpanel dev
      }

      // mixpanel track event
      // mixpanel.track('Page Viewed', {
      //     pageName: document.title,
      //     domain: location.host,
      //     url: location.href
      // });

        // google track event
        ga('require', 'displayfeatures');
        ga('send', 'pageview');
    </script>
</head>


<body id="<?php echo html($page->bodyid()) ?>">


<!-- END -->





