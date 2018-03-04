<?php

require('../../../base.php');

$access_toen = $auth->getToken();
// 授权失败
if( !isset($access_toen['access_token']) ){
	die('authenticate error');
}
// 授权成功
$_SESSION['access_token'] = $access_toen['access_token'];
header('location:/index.php');