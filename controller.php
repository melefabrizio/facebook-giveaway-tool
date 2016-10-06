<?php
if (!session_id()) {
	session_start();
}
?>
<html>
<body>
<?php
require 'vendor/autoload.php';

require 'ApiConnector.php';
include 'conf.php';

$postid= $_POST['postid'];
$pageid = $_POST['pageid'];
$accessToken = $_SESSION['access_token'];

$api = new ApiConnector($pageid,$postid,$accessToken, $_POST['blob']);
echo "<pre>";
		$comments = $api->interpolateData();
		print_r($comments);
echo "</pre>";
?>
</body>
</html>
