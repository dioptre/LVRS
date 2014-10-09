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
		header('Location: '.'http://'.$_SERVER['HTTP_HOST'].'/shop/#/declined');
		die();
	}else {
		// Set your secret key: remember to change this to your live secret key in production
		// See your keys here https://dashboard.stripe.com/account
		Stripe::setApiKey($GLOBALS['stripe']['secret_key']);
		$stoken = $_POST['stripeToken'];

		$sid = null;
		$customer = null;
		$api = new \UserApp\API($GLOBALS['userAppId'], $GLOBALS['userAppToken']);

		$result = $api->user->get(array(
			"user_id" => $user->user_id
		));
		if (isset($result[0]->properties->stripe_id->value)) {
			$sid = $result[0]->properties->stripe_id->value;
		}
		if (!isset($sid) or empty($sid)) {
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
		else {			
			$customer = Stripe_Customer::retrieve($sid);
			//if (!empty($customer->default_card)) {
			//	$customer->cards->retrieve($customer->default_card)->delete();
			//}
			$result = $customer->cards->create(array("card" => $stoken));
			$customer->default_card = $result->id; 
			$customer->save();
			$result = $api->user->paymentMethod->search(array(
				 "user_id" => $user->user_id,
				 "page" => 1,
				 "page_size" => 100,
				 "fields" => "*",
				 "sort" => "asc"
			 ));
			foreach ($result->items as $value) {
				if ($value->name == "Stripe") {
					$r = $api->user->paymentMethod->remove(array(
						"user_id" => $user->user_id,
						"payment_method_id" => $value->payment_method_id
					));		
				}
			}
			
		}
		
		$payment_method = $api->user->paymentMethod->save(array(
			"user_id" => $user->user_id,
			"name" => "Stripe",
			"type" => "creditcard",
			"processor" => "stripe",
			"data" => array('card_id' => $customer->default_card, 'customer_id' => $customer->id)
		));

		$invoice = $api->invoice->save(array(
			"user_id" => $user->user_id,
			"payment_method_id" => $payment_method->payment_method_id,
			"items" => array(
				array(
					"id" => "ebgLXRIrR3qDGu_frfNksA",
					"amount" => 270,
					"description" => "Monthly Subscription - "."VERVE1"
				)
			),
			"description" => "VERVE1",
			"state" => "pending",
			"vat_percentage" => 10,
			"currency" => "AUD"
		));

		//May not need to do this if stripe integration works
		// $subscription = $customer->subscriptions->create(array("plan" => "VERVE1"));
		
		
		// $result = $api->charge->save(array(
			// "user_id" => $user->user_id,
			// "payment_method_id" => $payment_method->payment_method_id,
			// "invoice_id" => $invoice->invoice_id,
			// "data" => array('subscription'=>$subscription->id, 'token'=>$stoken),
			// "amount" => 297,
			// "currency" => "AUD",
			// "error" => array()
		// ));
		
		//Update Subscription to Lvrs1
		$result = $api->user->save(array(
			"user_id" => $user->user_id,
			"subscription" => array( 'price_list_id'=> '8OGiDhNcRiCmuQNcGkzZ0A', 'plan_id'=> 'ebgLXRIrR3qDGu_frfNksA'),
		));
		
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
		  // 'plan' => "VERVE1",
		  // 'amount'   => 25000,
		  // 'currency' => 'aud'
		// ));
		
		
		// $customer = Stripe_Customer::create(array(
		  // "card" => $stoken,
		  // "plan" => "VERVE1",
		  // "email" => "payinguser@example.com")
		// );
		
		//echo "Successful Payment";
		header('Location: '.'http://'.$_SERVER['HTTP_HOST'].'/shop/#/transacted');
		die();

	}

?>
