<?php

/**
 * 阿里云呼叫中心SDK - HTTP操作类
 *
 * @package	widuu\aliyunCall
 * @author  widuu <admin@widuu.com>
 * @since	Version 1.0.0
 */
 
namespace widuu\aliyunCall;

class Http
{
	/**
	 * Post 提交数据方法
	 *
	 * @param  string  url  	  URL地址
	 * @param  array   post_data  数据数组
	 * @param  array   header     定制的header
	 * @author widuu <admin@widuu.com>
	 */

	public static function post($url = '', $post_data = [], $header = [])
	{
		$ch = curl_init($url);
		// header 头部信息
		if( count($header) != 0 ){
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}
		curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
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