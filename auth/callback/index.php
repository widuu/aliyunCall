<?php

var_dump($_REQUEST);
function http_post($url, $post_data) {
	    $ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

		$return_content =curl_exec($ch);
		$errorCode = curl_error($ch);
		curl_close ($ch); 
		return $return_content;
	}
$return = http_post('https://oauth.aliyun.com/v1/token',http_build_query(['code'=>$_GET['code'],'client_id'=>'920171048','redirect_uri'=>'https://data.zhongze.cc/auth/callback','grant_type'=>'authorization_code','client_secret'=>'IOnron7qCh86uxxuMDViDdVgCerxMNb9YNMM7NZFQSTdtBCIaTsrMjidMQx8VK2l']));
echo "<pre>";
print_r(json_decode($return,true));
echo "</pre>";
