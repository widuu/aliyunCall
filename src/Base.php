<?php

namespace widuu\aliyunCall;

class Base
{
	private $format = 'JSON';
	
	private $region_id = 'cn-shanghai';
	
	private $instance_id = null;
	
	private $access_key = null;
	
	private $signature_method = 'HMAC-SHA1';
	
	private $signature_version = '1.0';
	
	private $version = '2017-07-05';
	
	private $security_token = null;
	
	private $action = null;
	
	private static $action_url = 'http://ccc.cn-shanghai.aliyuncs.com/';
	
	public function __construct($security_token = '', $access_key = '' , $instance_id = '' )
	{
		if( empty($security_token) ){
			throw  new \Exception('security_token not exists',40004); 
		}
		
		if( empty($access_key) ){
			throw  new \Exception('access_key not exists',40005); 
		}
		
		if( empty($instance_id) ){
			throw  new \Exception('instance_id not exists',40006); 
		}
		$this->security_token = $security_token;
		$this->access_key 	  = $access_key;
		$this->instance_id    = $instance_id;
	}
	
	public function getConfig($security_token = '')
	{
		$this->params['SecurityToken'] = $security_token;
		$this->params['Signature'] = $this->makeSign();
		$return = http::post($url,$this->params);
		$result = json_decode($return,true);
		var_dump($result);
	}
	
	
	/**
	 * 签名算法
	 *
	 * @author widuu <admin@widuu.com>
	 */
	 
	private function makeSign()
	{
		$sign_params = $this->params;
		ksort($sign_params);
		$sign_str = "";
        foreach ($sign_params as $key => $value) {
            $sign_str .= "&" . $this->encode($key) . "=" . $this->encode($value);
        }
		$sign_string = 'POST&%2F&' . $this->encode(substr($sign_str,1));
		$sign = base64_encode(hash_hmac("sha1", $sign_string, $this->access_secret . "&", true));
		return $sign;
	}
	

	/**
	 * 获取公共参数
	 *
	 * @author widuu <admin@widuu.com>
	 */
	 
	private function getCommonParams()
	{
		$this->params['InstanceId']  = $this->instance_id;
		$this->params['RegionId'] 	 = $this->region_id;
		$this->params['AccessKeyId'] = $this->access_key;
		$this->params['Format']		 = $this->format;
		$this->params['Version']	 = $this->version;
		$this->params['SignatureMethod']  = $this->signature_method;
		$this->params['SignatureVersion'] = $this->signature_version;
		$this->params['SignatureNonce']   = uniqid();
		$this->params['Timestamp'] = gmdate('Y-m-d\TH:i:s\Z');		
	}
	
	
	/**
	 * 解析参数使用
	 *
	 * @author widuu <admin@widuu.com>
	 */
	 
	private function encode($str)
    {
        $res = urlencode($str);
        $res = preg_replace("/\+/", "%20", $res);
        $res = preg_replace("/\*/", "%2A", $res);
        $res = preg_replace("/%7E/", "~", $res);
        return $res;
    }
}