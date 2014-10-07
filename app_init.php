<?php

	use \UserApp\Widget\User;
	require(dirname(__FILE__) . '/autoload.php');

	// Find your App Id and Token:
	// App Id: https://help.userapp.io/customer/portal/articles/1322336-how-do-i-find-my-app-id-
	// Token: https://help.userapp.io/customer/portal/articles/1364103-how-do-i-create-an-api-token-

	$GLOBALS['userAppId'] = "542f6b2c8ea22";
	$GLOBALS['userAppToken'] = "qKXq1OUfSQaB3GZiGGNtuw";
	User::setAppId($GLOBALS['userAppId']);
	
	require_once('./lib/Stripe.php');

	$stripe = array(
	  "secret_key"      => "sk_test_VnTLRckG5HMoF2o9ZOEUeuV6",
	  "publishable_key" => "pk_test_eGxKrTUUvwyBCCwUjiwqXCBZ"
	);
	
	$GLOBALS['stripe'] = $stripe;

	Stripe::setApiKey($stripe['secret_key']);
?>
	