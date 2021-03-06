<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');	

	require_once("app_init.php");
	require_once("FirebaseToken.php");
	require_once('firebaseLib.php');


	//$ref = new firebase('https://burning-fire-4834.firebaseio.com/subscriptions.json');
	//$response = $ref->push( array('user-name' => 'Yop', 'content' => 'Hello firebase', 'auth' => $token ));

	$sid = null;
	$customer = null;

	//echo (string)serialize($user->properties->stripe_id);
	if(!isset($_POST['email']) or !isset($_POST['stripeToken'])){
		header('Location: '.'http://'.$_SERVER['HTTP_HOST'].'/shop/#/declined?error=invalidPost');
		die();
	}else {
		// Set your secret key: remember to change this to your live secret key in production
		// See your keys here https://dashboard.stripe.com/account
		Stripe::setApiKey($GLOBALS['stripe']['secret_key']);
		$stoken = $_POST['stripeToken'];


		if (isset($_POST['sid'])) {
			$sid = $_POST['sid'];
		}

		if (!isset($sid) or empty($sid) or $sid == '') {
			//echo (string)serialize('asdasx'.$customer.$_POST['email'].$stoken);
			//die();
			try {
// Get the credit card details submitted by the form
			$customer = Stripe_Customer::create(array(
			  'email' => $_POST['email'],
			  'card'  => $stoken
			));} catch (Exception $e) {
    header('Location: '.'http://'.$_SERVER['HTTP_HOST'].'/shop/#/declined?error=invalidCard');
		die();
}

			
			//echo (string)serialize('asdas'.$customer.$_POST['email'].$stoken);
			//die();
			$sid = $customer->id;	

		}
		else {		
			$customer = Stripe_Customer::retrieve($sid);
			//if (!empty($customer->default_card)) {
			//	$customer->cards->retrieve($customer->default_card)->delete();
			//}
			try {
				$result = $customer->cards->create(array("card" => $stoken));
			} catch (Exception $e) {
				header('Location: '.'http://'.$_SERVER['HTTP_HOST'].'/shop/#/declined?error=duplicateTransaction');
				die();
			}
			$customer->default_card = $result->id; 
			$customer->save();
			
		}
		



		//May not need to do this if stripe integration works
		try {
			if (!isset($_POST['coupon']) or empty($_POST['coupon']))
				$subscription = $customer->subscriptions->create(array("plan" => "LVRS1"));
			else
				$subscription = $customer->subscriptions->create(array("plan" => "LVRS1", "coupon"=>$_POST['coupon']));
		} catch (Exception $e) {
			header('Location: '.'http://'.$_SERVER['HTTP_HOST'].'/shop/#/declined?error=invalidSubscription');
			die();
		}
		
		$tokenGen = new Services_FirebaseTokenGenerator("W91wzxdLOukdO9u5BVaCGrhykCMmENQtfNBtwFtH");
		$token = $tokenGen->createToken(array("uid" => "simplelogin:19"), array("admin" => True));
		$firebase = new Firebase('https://burning-fire-4834.firebaseio.com', $token);

		$data = array(
		    'id' => $_POST['email'],
		    'uid' => $_POST['uid'],
		    'sid' => $sid,
		    'mobile' => $_POST['mobile'],
		    'email' => $_POST['email'],
		    'stoken' => $_POST['stripeToken'],
		    'subscribed' => gmdate("Y-m-d\TH:i:s\Z"),
		    'coupon' => $_POST['coupon'],
		    'subscription' => "LVRS1"
		);

		$res = $firebase->push('/subscriptions', $data);


		$to      = 'support@lvrs.co';
		$subject = 'New LVRS (LVRS1) Client - '.$_POST['firstName'];
		$message = "Please check:\r\n".$_POST['email']."\r\n".$_POST['mobile']."\r\n".$_POST['uid']."\r\n".$res."\r\n".$sid;
		// $headers = 'From: support@lvrs.co' . "\r\n" .
		//     'Reply-To: support@lvrs.co' . "\r\n" .
		//     'X-Mailer: PHP/' . phpversion();

		// mail($to, $subject, $message, $headers);
		

		$url = 'https://api.sendgrid.com/';
		$user = 'dioptre';
		$pass = 'bl4ck5h33p5$';

		$params = array(
		    'api_user'  => $user,
		    'api_key'   => $pass,
		    'to'        => 'support@lvrs.co',
		    'subject'   => $subject,
		    //'html'      => 'testing body',
		    'text'      => $message,
		    'from'      => 'support@lvrs.co',
		  );


		$request =  $url.'api/mail.send.json';

		// Generate curl request
		$session = curl_init($request);
		// Tell curl to use HTTP POST
		curl_setopt ($session, CURLOPT_POST, true);
		// Tell curl that this is the body of the POST
		curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
		// Tell curl not to return headers, but do return the response
		curl_setopt($session, CURLOPT_HEADER, false);
		// Tell PHP not to use SSLv3 (instead opting for TLS)
		//curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

		// obtain response
		$response = curl_exec($session);
		curl_close($session);

		// print everything out
		print_r($response);





		/***** Scratch Area *****/
		// $result = $api->property->save(array(
			// //"property_id" => $user->user_id . "-stripe",
			// "name" => "stripe_id",
			// "type" => "string",
			// "default_value" => "",
			// "access_level" => "private"
		// ));
		
		
		// $result = $api->property->search(array(
			// "page" => 1,
			// "page_size" => 100,
			// "fields" => "*",
			// "sort" => "asc"
		// ));
			// echo (string)serialize($result);
			
			// $result = $api->property->remove(array(
			// "property_id" => "cMtn9g4KE8aQd8QFElhlFR"
		// ));

		// $charge = Stripe_Charge::create(array(
		  // 'customer' => $sid,
		  // 'plan' => "LVRS1",
		  // 'amount'   => 25000,
		  // 'currency' => 'aud'
		// ));
		
		
		// $customer = Stripe_Customer::create(array(
		  // "card" => $stoken,
		  // "plan" => "LVRS1",
		  // "email" => "payinguser@example.com")
		// );
		
		//echo "Successful Payment";
		header('Location: '.'http://'.$_SERVER['HTTP_HOST'].'/shop/#/transacted?sid='. $sid.'&stoken='.$stoken.'&subscription=LVRS1');
		die();

	}

?>
