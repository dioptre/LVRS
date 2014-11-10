<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');	

	require("app_init.php");
	
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
			echo (string)serialize('asdasx'.$customer.$_POST['email'].$stoken);
			//die();
			try {
// Get the credit card details submitted by the form
			$customer = Stripe_Customer::create(array(
			  'email' => $_POST['email'],
			  'card'  => $stoken
			));} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

			
			echo (string)serialize('asdas'.$customer.$_POST['email'].$stoken);
			die();
			$sid = $customer->id;	

		}
		else {		
			$customer = Stripe_Customer::retrieve($sid);
			//if (!empty($customer->default_card)) {
			//	$customer->cards->retrieve($customer->default_card)->delete();
			//}
			$result = $customer->cards->create(array("card" => $stoken));
			$customer->default_card = $result->id; 
			$customer->save();
			
		}
		



		//May not need to do this if stripe integration works
		$subscription = $customer->subscriptions->create(array("plan" => "LVRS1"));
		
		
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
		header('Location: '.'http://'.$_SERVER['HTTP_HOST'].'/shop/#/transacted?sid='. $sid.'&token='.$stoken);
		die();

	}

?>
