<?php

	
	require_once('./lib/Stripe.php');

	$stripe = array(
	  "secret_key"      => "sk_live_g9fSE98LDgWTZM3Vv7CccPW6",
	  "publishable_key" => "pk_live_CPiVhO4rfNcUKZVNXMU7Bfuy"
	);
	
	$GLOBALS['stripe'] = $stripe;

	Stripe::setApiKey($stripe['secret_key']);
?>
	