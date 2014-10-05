<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');	

	use \UserApp\Widget\User;
	require("app_init.php");
	

	$valid_token = false;

	if(isset($_COOKIE["ua_session_token"])){
		$token = $_COOKIE["ua_session_token"];

		try{
			$valid_token = User::loginWithToken($token);
			$user = User::current();
		}catch(\UserApp\Exceptions\ServiceException $exception){
			$valid_token = false;
		}
	}
	//echo (string)serialize($user->properties->stripe_id);
	if(!$valid_token or !isset($_POST['stripeToken'])){
		//echo "Invalid token";
		header('Location: '.'http://'.$_SERVER['HTTP_HOST'].'/failed-transaction');
		die();
	}else {
		// Set your secret key: remember to change this to your live secret key in production
		// See your keys here https://dashboard.stripe.com/account
		Stripe::setApiKey("sk_test_VnTLRckG5HMoF2o9ZOEUeuV6");
		$stoken = $_POST['stripeToken'];

		$sid = null;
		
		$api = new \UserApp\API($GLOBALS['userAppId'], $GLOBALS['userAppToken']);

		$result = $api->user->get(array(
			"user_id" => $user->user_id
		));
		if (isset($result[0]->properties->stripe_id->value)) {
			$sid = $result[0]->properties->stripe_id->value;
		}
		else {
			// Get the credit card details submitted by the form
			$customer = Stripe_Customer::create(array(
			  'email' => $user->email,
			  'card'  => $stoken
			));
			$sid = $customer->id;	
			$result = $api->user->save(array(
				'user_id' => $user->user_id,
				'properties' => array( 'stripe_id' => array ('value' => $sid, 'override' => true))
			));
		}
		
		
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

		$charge = Stripe_Charge::create(array(
		  'customer' => $sid,
		  'amount'   => 25000,
		  'currency' => 'aud'
		));

		
		// $customer = Stripe_Customer::create(array(
		  // "card" => $stoken,
		  // "plan" => "VERVE1",
		  // "email" => "payinguser@example.com")
		// );
		
		//echo "Successful Payment";
		header('Location: '.'http://'.$_SERVER['HTTP_HOST'].'/successful-transaction');
		die();

	}

?>
