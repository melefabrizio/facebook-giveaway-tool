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
include_once 'conf.php';

$postid= $_POST['postid'];
$pageid = $_POST['pageid'];
$accessToken = $_SESSION['access_token'];

$api = new ApiConnector($pageid,$postid,$accessToken);
$comments = $api->interpolateData();
$count = count($comments);
echo <<<HTML
<b>Totale: $count </b>
<table>
<tr><th>Name</th><th>Comment</th></tr>
HTML;

		foreach ($comments as $comment){
			echo "<tr>";
			$id = $comment['from_id'];
			$from = $comment['from'];
			$message = $comment['message'];
			echo "<td>$from</td><td>$message</td></tr>";
		}
echo "</table>";
session_unset();
?>
</body>
</html>
