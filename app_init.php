<?php

	
	require_once('./lib/Stripe.php');

	$stripe = array(
	  "secret_key"      => "sk_test_VnTLRckG5HMoF2o9ZOEUeuV6",
	  "publishable_key" => "pk_test_eGxKrTUUvwyBCCwUjiwqXCBZ"
	);
	
	$GLOBALS['stripe'] = $stripe;

	Stripe::setApiKey($stripe['secret_key']);
?>
	