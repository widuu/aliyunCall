<?php

require "vendor/autoload.php";
use widuu\aliyunCall\Auth;

$aliyun_config = [
	'client_id' 	=> '920171031',
	'client_secret' => 'E1QGQUDMSqRNcOO/WTt83vQ25Bdtb0LJYSm0fFdF0eY=',
	'redirect_uri'  => 'https://127.0.0.1:8443/aliyun/auth/callback'
]; 

$auth = new Auth($aliyun_config);

session_start();