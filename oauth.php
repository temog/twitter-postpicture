<?php

// oauth_token, secret をあとで使うため session 利用
session_start();
require('tmhOAuth-master/tmhOAuth.php');

$consumer_key = '';
$consumer_secret = '';

$tmh = new tmhOauth(array(
	'consumer_key' => $consumer_key,
	'consumer_secret' => $consumer_secret
));

$code = $tmh->request('POST', $tmh->url('oauth/request_token', ''));
if($code != 200){
	// エラー処理

	exit;
}

$response = $tmh->extract_params($tmh->response['response']);

// oauth token, secret を保存
$_SESSION['oauth_token'] = $response['oauth_token'];
$_SESSION['oauth_token_secret'] = $response['oauth_token_secret'];

//print_r($response);

// 認証用URL生成。Redirectするのが普通でしょうか。
// サンプルなのでリンクにしときます。
$url = $tmh->url('oauth/authorize', '') . "?oauth_token=" . $response['oauth_token'];

?><!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>twitter test</title>
</head>
<body>

<a href="<?php echo $url; ?>">認証画面へ</a>

</body>
</html>

