<?php
if (!session_id()) {
	session_start();
}
require 'vendor/autoload.php';
require 'conf.php';
$fb = new Facebook\Facebook([
	'app_id' => APP_ID,
	'app_secret' => APP_SECRET,
	'version' => VERSION
]);
$helper = $fb->getRedirectLoginHelper();
$accessToken = $helper->getAccessToken();
$_SESSION['access_token'] = $accessToken;

header("Location:http://localhost:8888/giveaway/index.php");
//$api->setToken();

//echo $api->getLikes();
