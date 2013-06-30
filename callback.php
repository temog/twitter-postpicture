<?php

session_start();
require('tmhOAuth-master/tmhOAuth.php');

$consumer_key = '';
$consumer_secret = '';

// twitter から渡されるパラメータを保持
$oauth_token = $_GET['oauth_token'];
$oauth_verifier = trim($_GET['oauth_verifier']);

// oauth token を比較。不一致ならエラー処理を
if($oauth_token != $_SESSION['oauth_token']){
	// エラー処理
	exit;
}

$tmh = new tmhOauth(array(
	'consumer_key' => $consumer_key,
	'consumer_secret' => $consumer_secret,
	'token' => $_SESSION['oauth_token'],
	'secret' => $_SESSION['oauth_token_secret']
));

// ユーザトークンを取得
$code = $tmh->user_request(array(
	'method' => 'POST',
	'url' => $tmh->url('oauth/access_token', ''),
	'params' => array(
		'oauth_verifier' => $oauth_verifier
	)
));

if($code != 200){
	// エラー処理
	exit;
}

// 取得したユーザトークンを保持（とりあえずSessionに）
// 普通はDBとかに保存しないと毎回認証が必要になっちゃます
$_SESSION['user'] = $tmh->extract_params($tmh->response['response']);


?><!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>twitter test</title>
</head>
<body>
<pre>

ユーザトークンが取得できたので画像付きで、「<?php echo $_SESSION['user']['screen_name']; ?>」としてTweetしてみる

<form action="postPicture.php" method="POST" enctype="multipart/form-data">
	<input type="file" name="picture"><br>
	<textarea name="tweet"></textarea><br>
	<input type="submit" value="tweet">
</form>


</pre>
</body>
</html>

