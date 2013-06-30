<?php

session_start();
require('tmhOAuth-master/tmhOAuth.php');

$consumer_key = '';
$consumer_secret = '';

// 簡単にバリデーション
if(empty($_FILES) || ! $_POST['tweet']){
	// エラー処理
	exit;
}

$tmh = new tmhOauth(array(
	'consumer_key' => $consumer_key,
	'consumer_secret' => $consumer_secret,
	'token' => $_SESSION['user']['oauth_token'],
	'secret' => $_SESSION['user']['oauth_token_secret']
));


$params = array(
	'media[]' => "@" . $_FILES['picture']['tmp_name'] . ";".
				"type=" . $_FILES['picture']['type'] . ";".
				"filename=" . $_FILES['picture']['name'],
    'status' => $_POST['tweet']
);

$code = $tmh->user_request(array(
	'method' => 'POST',
	'url' => $tmh->url("1.1/statuses/update_with_media"),
	'params' => $params,
	'multipart' => true
));

if($code != 200){
	// エラー処理
	// $tmh->response['error'];
	// $tmh->response['response'];
	exit;
}

?><!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>twitter test</title>
</head>
<body>
<pre>
成功しました。

<?php print_r(json_decode($tmh->response['response'])); ?>

</pre>
</body>
</html>


