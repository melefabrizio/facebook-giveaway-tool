<?php if (!session_id()) {
	session_start();
}
?>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script>
	</script>
</head>
<body>
<?php
/*
if(isset($_GET['logout'])){
	$_SESSION['access_token'] = null;
	header('Location: '.$_SERVER['REQUEST_URI']);
}*/
require 'vendor/autoload.php';

require 'ApiConnector.php';
include 'conf.php';
$postid= "192526417824469";
$pageid ="132224490521329";



$code = $_GET['code'];
$fb = new Facebook\Facebook([
	'app_id' => APP_ID,
	'app_secret' => APP_SECRET,
	'version' => VERSION
]);
$permissions = ['user_posts'];
$helper = $fb->getRedirectLoginHelper();
$_SESSION['FBRLH_state'] = $_GET['state'];

if(isset($_GET['code'])){
	//echo $_GET['code'];

	$accessToken = $helper->getAccessToken();
	$_SESSION['access_token'] = $accessToken->getValue();
	echo $accessToken->getValue();
	echo "<br>";
	$api = new ApiConnector($pageid,$postid,$accessToken,null);

	echo "<a id='link' href='https://www.facebook.com/ajax/shares/view/?target_fbid=$postid&__a=1'>Clicca qui</a><br>";
	?>
	<br><br>
	<form action="controller.php" method="post">
		<label for="postid">Post</label>
		<input type="text" value="192526417824469" name="postid"/><br>
		<label for="pageid">pagina</label>
		<input type="text" value="132224490521329" name="pageid"/><br>
		<label for="blob">Blob</label>
		<input type="text" name="blob"/><br>
		<input type="submit" name="submit"/>
	</form>

	<a href="index.php?logout">Logout</a>

<?php


}else {

	echo "<a href='{$helper->getLoginUrl('http://localhost:8888/giveaway/index.php',$permissions)}'>Log In</a>";
}
//
?>
<script>


</script>
</body>
</html>
