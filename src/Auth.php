<?php

/**
 * 阿里云呼叫中心SDK - 授权类
 *
 * @package	widuu\aliyunCall
 * @author  widuu <admin@widuu.com>
 * @since	Version 1.0.0
 */
 
namespace widuu\aliyunCall;

class Auth
{
	
	/**
	 * 获取授权码url
	 *
	 * @author widuu <admin@widuu.com>
	 */
	 
	private static $signin_url = 'https://signin.aliyun.com/oauth2/v1/auth';
	
	/**
	 * 授权码换取访问令牌URL
	 *
	 * @author widuu <admin@widuu.com>
	 */
	 
	private static $token_url  = 'https://oauth.aliyun.com/v1/token';
	
	/**
	 * 令牌撤销URL
	 *
	 * @author widuu <admin@widuu.com>
	 */
	 
	private static $revoke_url = 'https://oauth.aliyun.com/v1/revoke';
	/**
	 * 应用的Identifier
	 *
	 * @author widuu <admin@widuu.com>
	 */
	 
	private $client_id = null;
	
	/**
	 * 应用注册的重定向URI之一
	 *
	 * @author widuu <admin@widuu.com>
	 */
	 
	private $redirect_uri = null;
	
	/**
	 * 返回类型。根据OAuth 2.0标准，目前支持设置此参数的取值为code
	 *
	 * @author widuu <admin@widuu.com>
	 */
	 
	private $response_type = 'code';
	
	/**
	 * 使用应用的AppSecret，未使用RSA KEY
	 *
	 * @author widuu <admin@widuu.com>
	 */
	 
	private $client_secret = null;
	
	/**
	 * <code>
	 * new widuu\aliyunCall\Auth([
	 * 		'client_id'     => 'xxx',
	 *		'redirect_uri'  => 'xxx',
	 *		'client_secret' => 'xxx'
	 * ]);
	 * </code>
	 *
	 * @author widuu <admin@widuu.com>
	 */
	 
	public function __construct( $options = [] )
	{
		if( !isset($options['client_id']) || empty($options['client_id']) ){
			throw new \Exception('client id not exists',40000);
		}
		
		if( !isset($options['redirect_uri']) || empty($options['redirect_uri']) ){
			throw new \Exception('redirect_uri not exists',40001);
		}
		
		if( !isset($options['client_secret']) || empty($options['client_secret']) ){
			throw new \Exception('client_secret not exists',40001);
		}
		
		$this->client_id 	 = trim($options['client_id']);
		$this->client_secret = trim($options['client_secret']);
		$this->redirect_uri  = trim($options['redirect_uri']);
	}
	
	
	/**
	 * 获取授权码
	 * 
	 * @author widuu <admin@widuu.com>
	 */
	 
	public function login()
	{
		$url_params = [
			'client_id' 	=> $this->client_id,
			'redirect_uri'  => $this->redirect_uri,
			'response_type' => $this->response_type,
			'state'		    => rand(10000,99999)
		];
		$url = self::$signin_url'?'.http_build_query($url_params);
		header('Location:'.$url);
		exit();
	}
	
	/**
	 * 获取访问授权令牌
	 * 
	 * @param  string  code  可为空，为空通过GET来获取 
	 * @return array   
	 * @author widuu <admin@widuu.com>
	 */
	
	public function getToken( $get_code = '' )
	{
		$code = empty($get_code) ? trim($_GET['code']) : trim($get_code);
		$post_fields = [
			'code' 			=> $code,
			'client_id' 	=> $this->client_id,
			'redirect_uri'  => $this->redirect_uri,
			'grant_type'    => 'authorization_code',
			'client_secret' => $this->client_secret
		];
		$context = Http::post(self::$token_url,$post_fields);
		return json_decode($context, true);
	}
	
	/**
	 * 刷新访问令牌
	 * 
	 * @param  string  refresh_token 获取访问令牌时候获取的refresh_token
	 * @return array   
	 * @author widuu <admin@widuu.com>
	 */
	 
	public function refreshToken( $refresh_token = '' )
	{
		$post_fields = [
			'refresh_token' => $refresh_token,
			'client_id' 	=> $this->client_id,
			'grant_type'    => 'refresh_token',
			'client_secret' => $this->client_secret
		];
		$context = Http::post(self::$token_url,$post_fields);
		return json_decode($context, true);
	}
	
	/**
	 * 撤销令牌
	 * 
	 * @param  string  token 需要撤销的token
	 * @return array   
	 * @author widuu <admin@widuu.com>
	 */
	 
	public function revokeToken( $token = '' )
	{
		$post_fields = [
			'token' 		=> $token,
			'client_id' 	=> $this->client_id,
			'client_secret' => $this->client_secret
		];
		$context = Http::post(self::$revoke_url,$post_fields);
		return json_decode($context, true);
	}
}