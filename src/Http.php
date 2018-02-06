<?php

namespace widuu\aliyunCall;

class Http
{
	/**
	 * Post 提交数据方法
	 *
	 * @author widuu <admin@widuu.com>
	 */

	public static function post($url = '', $post_data = [], $header = [] )
	{
		$ch = curl_init($url);
		// header 头部信息
		if( count($header) != 0 ){
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}
        // https 
        if (strlen($url) > 5 && strtolower(substr($url, 0, 5)) == "https") {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
	    curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);		
		$return_content =curl_exec($ch);
		curl_close ($ch); 
		return $return_content;
	} 	
}