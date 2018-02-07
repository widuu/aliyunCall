<?php

/**
 * 阿里云呼叫中心SDK - 操作方法
 *
 * @package	widuu\aliyunCall
 * @author  widuu <admin@widuu.com>
 * @since	Version 0.0.1
 */
 
namespace widuu\aliyunCall;

class Call
{
	
	/**
	 * 返回值的类型 JSON
	 *
	 * @author widuu <admin@widuu.com>
	 */
	 
	private $format = 'JSON';
	
	/**
	 * 机房信息
	 *
	 * @author widuu <admin@widuu.com>
	 */
	 
	private $region_id = 'cn-shanghai';
	
	/**
	 * 实例ID
	 *
	 * @author widuu <admin@widuu.com>
	 */
	 
	private $instance_id = null;
	
	/**
	 * 秘钥ID
	 *
	 * @author widuu <admin@widuu.com>
	 */
	 
	private $access_key = null;
	
	/**
	 * 签名方式
	 *
	 * @author widuu <admin@widuu.com>
	 */
	
	private $signature_method = 'HMAC-SHA1';
	
	/**
	 * 签名算法版本
	 *
	 * @author widuu <admin@widuu.com>
	 */
	 
	private $signature_version = '1.0';
	
	/**
	 * 接口版本
	 *
	 * @author widuu <admin@widuu.com>
	 */
	 
	private $version = '2017-07-05';
	
	/**
	 * access token 中获取的 security token
	 *
	 * @author widuu <admin@widuu.com>
	 */
	 
	private $security_token = null;
	
	/**
	 * 秘钥 secret
	 *
	 * @author widuu <admin@widuu.com>
	 */

	private $access_secret  = null;
	
	/**
	 * 请求URL
	 *
	 * @author widuu <admin@widuu.com>
	 */
	 
	private static $action_url = 'http://ccc.cn-shanghai.aliyuncs.com/';
	
	/**
	 * 实例化类
	 *
	 * @param  instance_id  实例ID
	 * @param  access_token 获取的ACCESS TOKEN
	 * @author widuu <admin@widuu.com>
	 */
	 
	public function __construct( $instance_id = '' , $access_token = '' )
	{
		if( empty($access_token) ){
			throw  new \Exception('access_token not exists',40004); 
		}
		
		if( empty($instance_id) ){
			throw  new \Exception('instance_id not exists',40006); 
		}
		
		$access_info = json_decode( base64_decode($access_token) , true );
		
		if( !isset($access_info['SecurityToken']) ){
			throw new \Exception('access token error',40007);
		}
		
		$this->security_token = $access_info['SecurityToken'];
		$this->access_key 	  = $access_info['AccessKeyId'];
		$this->access_secret  = $access_info['AccessKeySecret'];
		$this->instance_id    = $instance_id;
	}
	
	/**
	 * 获取服务号码
	 *
	 * @param  string  service_type  服务类型
	 * @author widuu <admin@widuu.com>
	 */
	 
	public function getServiceExtensions( $service_type = 'SatisfactionSurvey' )
	{
		$this->getCommonParams();
		$this->params['Action'] = 'GetServiceExtensions';
		$this->params['ServiceType']   = $service_type;
		$this->params['AccessKeyId']   = $this->access_key;
		$this->params['InstanceId']    = $this->instance_id;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['Signature'] = $this->makeSign();
		return $this->getResponse();
	}
	
	/**
	 * 获取配置
	 *
	 * @author widuu <admin@widuu.com>
	 */
	
	public function getConfig($name = '', $object_type = '', $object_id = '')
	{
		$this->getCommonParams();
		$this->params['Action'] = 'GetConfig';
		$this->params['Name'] 	= $name;
		$this->params['ObjectType'] = $object_type;
		$this->params['ObjectId'] 	= $object_id;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['Signature'] = $this->makeSign();
		return $this->getResponse();
	}
	
	/**
	 * 刷新令牌
	 *
	 * @author widuu <admin@widuu.com>
	 */
	 
	public function refreshToken()
	{
		$this->getCommonParams();
		$this->params['Action'] = 'RefreshToken';
		$this->params['InstanceId']    = $this->instance_id;
		$this->params['AccessKeyId']   = $this->access_key;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['Signature'] = $this->makeSign();
		return $this->getResponse();
	}
	
	/**
	 * 登陆信息
	 *
	 * @author widuu <admin@widuu.com>
	 */
	 
	public function requestLoginInfo()
	{
		$this->getCommonParams();
		$this->params['Action'] = 'RequestLoginInfo';
		$this->params['InstanceId']    = $this->instance_id;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['Signature'] = $this->makeSign();
		return $this->getResponse();
	}
	
	/**
	 * 联系流列表
	 *
	 * @author widuu <admin@widuu.com>
	 */
	 
	public function listContactFlows()
	{
		$this->getCommonParams();
		$this->params['Action'] = 'ListContactFlows';
		$this->params['InstanceId']    = $this->instance_id;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['AccessKeyId']   = $this->access_key;
		$this->params['Signature'] = $this->makeSign();
		return $this->getResponse();
	}
	
	/**
	 * 权限列表
	 *
	 * @author widuu <admin@widuu.com>
	 */
	 
	public function listRoles()
	{
		$this->getCommonParams();
		$this->params['Action'] = 'ListRoles';
		$this->params['InstanceId']    = $this->instance_id;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['AccessKeyId']   = $this->access_key;
		$this->params['Signature'] = $this->makeSign();
		return $this->getResponse();
	}
	
	/**
	 * 新增号码
	 *
	 * @param  string  phone_number  待添加电话号码
	 * @param  string  usage		 选项 Inbound, Outboung, Bidirection
	 * @param  string  flow_id       (可选)和电话号码绑定的联系流ID。
	 * @author widuu  <admin@widuu.com>
	 */
	 
	public function addPhoneNumber( $phone_number = '', $usage = '', $flow_id = '' )
	{
		$this->getCommonParams();
		$this->params['Action'] = 'AddPhoneNumber';
		$this->params['InstanceId']    = $this->instance_id;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['AccessKeyId']   = $this->access_key;
		$this->params['PhoneNumber']   = $phone_number;
		$this->params['Usage']   	   = $usage;
		if( !empty($flow_id) ){
			$this->params['ContactFlowId'] = $flow_id;
		}
		$this->params['Signature'] = $this->makeSign();
		return $this->getResponse();
	}
	
	/**
	 * 电话列表【官方暂未给出文档】
	 *
	 * @author widuu  <admin@widuu.com>
	 */
	
	public function listPhoneNumbers($outbound = '')
	{
		$this->getCommonParams();
		$this->params['Action'] = 'ListPhoneNumbers';
		$this->params['InstanceId']    = $this->instance_id;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['AccessKeyId']   = $this->access_key;
		$this->params['OutboundOnly']  = $outbound;
		$this->params['Signature'] = $this->makeSign();
		return $this->getResponse();
	}
	
	/**
	 * 新增号码
	 *
	 * @param  string  phone_number_id  待修改的电话号码ID
	 * @param  string  usage		 	选项 Inbound, Outboung, Bidirection
	 * @param  string  flow_id       	(可选)和电话号码绑定的联系流ID。
	 * @author widuu  <admin@widuu.com>
	 */
	 
	public function modifyPhoneNumber( $phone_number_id = '', $usage = '', $flow_id = '' )
	{
		$this->getCommonParams();
		$this->params['Action'] = 'ModifyPhoneNumber';
		$this->params['InstanceId']    = $this->instance_id;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['AccessKeyId']   = $this->access_key;
		$this->params['PhoneNumberId'] = $this->access_key;
		$this->params['Usage']   	   = $usage;
		if( !empty($flow_id) ){
			$this->params['ContactFlowId'] = $flow_id;
		}
		$this->params['Signature'] = $this->makeSign();
		return $this->getResponse();
	}
	
	/**
	 * 电话删除
	 *
	 * @param  string  phone_number_id  待移除电话号码ID。
	 * @author widuu  <admin@widuu.com>
	 */
	 
	public function removePhoneNumber( $phone_number_id = '')
	{
		$this->getCommonParams();
		$this->params['Action'] = 'RemovePhoneNumber';
		$this->params['InstanceId']    = $this->instance_id;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['AccessKeyId']   = $this->access_key;
		$this->params['PhoneNumberId'] = $this->access_key;
		$this->params['Signature'] = $this->makeSign();
		return $this->getResponse();
	}
	
	/**
	 * 创建技能组
	 *
	 * @param  string  name  		待创建的技能组名称。
	 * @param  string  description	待创建的技能组名称。
	 * @param  array   out_numbers  该技能组所允许的外呼号码ID列表。
	 * @param  array   user_ids     归属于技能组的座席用户ID列表。
	 * @param  array   skill_levels 技能级别。
	 * @author widuu  <admin@widuu.com>
	 */
	 
	public function createSkillGroup( $name = '', $description = '', $out_numbers = [], $user_ids = [], $skill_levels = [] )
	{
		$this->getCommonParams();
		$this->params['Action'] = 'CreateSkillGroup';
		$this->params['InstanceId']    = $this->instance_id;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['AccessKeyId']   = $this->access_key;
		$this->params['Name'] = $name;
		$this->params['Description'] = $description;
		$this->params['OutboundPhoneNumberIds'] = $out_numbers;
		$this->params['UserIds'] = $user_ids;
		$this->params['skillLevels'] = $skill_levels;
		$this->params['Signature'] = $this->makeSign();
		return $this->getResponse();
	}
	
	/**
	 * 删除技能组
	 *
	 * @param  string skill_group_id 	待删除的技能组ID。
	 * @author widuu <admin@widuu.com>
	 */
	
	public function deleteSkillGroup( $skill_group_id = '' )
	{
		$this->getCommonParams();
		$this->params['Action'] = 'DeleteSkillGroup';
		$this->params['InstanceId']    = $this->instance_id;
		$this->params['AccessKeyId']   = $this->access_key;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['SkillGroupId']  = $skill_group_id;
		$this->params['Signature'] = $this->makeSign();
		return $this->getResponse();
	}
	
	/**
	 * 技能组列表
	 *
	 * @author widuu <admin@widuu.com>
	 */
	
	public function listSkillGroups()
	{
		$this->getCommonParams();
		$this->params['Action'] = 'ListSkillGroups';
		$this->params['InstanceId']    = $this->instance_id;
		$this->params['AccessKeyId']   = $this->access_key;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['Signature'] = $this->makeSign();
		return $this->getResponse();
	}
	
	/**
	 * 客服相关联技能组列表
	 *
	 * @param  string user_id  待获取技能组列表的用户ID。
	 * @author widuu <admin@widuu.com>
	 */
	 
	public function listSkillGroupsOfUser( $user_id = '' )
	{
		$this->getCommonParams();
		$this->params['Action'] = 'ListSkillGroupsOfUser';
		$this->params['InstanceId']    = $this->instance_id;
		$this->params['AccessKeyId']   = $this->access_key;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['UserId']    = $user_id;
		$this->params['Signature'] = $this->makeSign();
		$context = $this->getResponse();
		$skillLevels = $context['skillLevels']['skillLevel'];
		foreach($skillLevels as &$v){
			$phoneNumber = $v['skill']['outboundPhoneNumbers']['phoneNumber'];
			unset($v['skill']['outboundPhoneNumbers']);
			$v['skill']['outboundPhoneNumbers'] = $phoneNumber;
		}
		unset($context['skillLevels']);
		$context['skillLevels'] = $skillLevels;
		return $context;
	}
	
	/**
	 * 技能组相关联客服列表
	 *
	 * @param  int    start    分页序号
	 * @param  int    limit    分页大小
	 * @param  string user_id  待获取技能组列表的用户ID。
	 * @author widuu <admin@widuu.com>
	 */
	 
	public function listUsersOfSkillGroup( $skill_group_id = '', $start = 0, $limit = 20 )
	{
		$this->getCommonParams();
		$this->params['Action'] = 'ListUsersOfSkillGroup';
		$this->params['InstanceId']    = $this->instance_id;
		$this->params['AccessKeyId']   = $this->access_key;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['SkillGroupId']  = $skill_group_id;
		$this->params['PageNumber']    = $start;
		$this->params['PageSize']      = $limit;
		$this->params['Signature'] = $this->makeSign();
		return $this->getResponse();
	}
	
	/**
	 * 修改技能组
	 *
	 * @param  string  group_id  	待修改的技能组ID。
	 * @param  string  name  		待创建的技能组名称。
	 * @param  string  description	待创建的技能组名称。
	 * @param  array   out_numbers  该技能组所允许的外呼号码ID列表。
	 * @param  array   user_ids     归属于技能组的座席用户ID列表。
	 * @param  array   skill_levels 技能级别。
	 * @author widuu <admin@widuu.com>
	 */
	 
	public function modifySkillGroup( $group_id = '', $name = '', $description = '', $out_numbers = [], $user_ids = [], $skill_levels = [] )
	{
		$this->getCommonParams();
		$this->params['Action'] = 'ModifySkillGroup';
		$this->params['InstanceId']    = $this->instance_id;
		$this->params['AccessKeyId']   = $this->access_key;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['SkillGroupId']  = $group_id;
		$this->params['Name'] = $name;
		$this->params['Description'] = $description;
		$this->params['OutboundPhoneNumberIds'] = $out_numbers;
		$this->params['UserIds'] = $user_ids;
		$this->params['skillLevels'] = $skill_levels;
		$this->params['Signature'] = $this->makeSign();
		return $this->getResponse();
	}
	
	/**
	 * 导入客服
	 *
	 * @param  array   ram_ids		待添加的目录服务中的用户RAM ID列表.
	 * @param  array   role_ids     新添加用户的角色ID列表。
	 * @param  array   group_ids    待创建用户所归属的技能组ID列表。
	 * @param  array   skill_levels 待创建用户所具有的技能级别列表。
	 * @author widuu <admin@widuu.com>
	 */
	 
	public function assignUsers($ram_ids = [], $role_ids = [], $group_ids = [], $skill_levels = [])
	{
		$this->getCommonParams();
		$this->params['Action'] = 'AssignUsers';
		$this->params['InstanceId']    = $this->instance_id;
		$this->params['AccessKeyId']   = $this->access_key;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['UserRamIds']    = $ram_ids;
		$this->params['RoleIds']       = $role_ids;
		$this->params['SkillGroupIds'] = $group_ids;
		$this->params['SkillLevels']   = $skill_levels;
		$this->params['Signature'] = $this->makeSign();
		return $this->getResponse();
	}
	
	/**
	 * 新增客服
	 *
	 * @param  string  login_name   用户登陆名。
	 * @param  string  display_name 用户的全名。
	 * @param  string  phone 		用户电话号码。
	 * @param  string  email 		用户电子邮件地址。
	 * @param  array   role_ids     待创建用户所具有的角色ID列表。
	 * @param  array   groups    	待创建用户所归属的技能组ID列表。
	 * @param  array   skill_levels 待创建用户所具有的技能级别列表。
	 * @author widuu <admin@widuu.com>
	 */
	 
	public function createUser($login_name = '', $display_name = '', $phone = '', $email = '', $role_ids = [], $groups = [], $skill_levels = [])
	{
		$this->getCommonParams();
		$this->params['Action'] = 'CreateUser';
		$this->params['InstanceId']    = $this->instance_id;
		$this->params['AccessKeyId']   = $this->access_key;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['LoginName']     = $login_name;
		$this->params['DisplayName']   = $display_name;
		$this->params['Phone'] 		   = $phone;
		$this->params['Email']   	   = $email;
		$this->params['RoleIds']   	   = $role_ids;
		$this->params['SkillGroups']   = $groups;
		$this->params['SkillLevels']   = $skill_levels;
		$this->params['Signature'] = $this->makeSign();
		return $this->getResponse();
	}
	
	/**
	 * 客服信息
	 *
	 * @param  string  user_id   用户ID。
	 * @author widuu <admin@widuu.com>
	 */
	 
	public function getUser($user_id = '')
	{
		$this->getCommonParams();
		$this->params['Action'] = 'GetUser';
		$this->params['InstanceId']    = $this->instance_id;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['AccessKeyId']   = $this->access_key;
		$this->params['UserId']		   = $user_id;
		$this->params['Signature'] = $this->makeSign();
		return $this->getResponse();
	}
	
	/**
	 * 客服列表
	 *
	 * @param  int  start   分页序号
	 * @param  int  limit   分页大小
	 * @author widuu <admin@widuu.com>
	 */
	 
	public function listUsers($start = 0, $limit = 20)
	{
		$this->getCommonParams();
		$this->params['Action'] = 'ListUsers';
		$this->params['InstanceId']    = $this->instance_id;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['AccessKeyId']   = $this->access_key;
		$this->params['PageNumber']	   = $start;
		$this->params['PageSize']	   = $limit;
		$this->params['Signature'] = $this->makeSign();
		return $this->getResponse();
	}
	
	/**
	 * 修改客服
	 *
	 * @param  string  user_id   	待修改的用户ID
	 * @param  string  display_name 用户的全名。
	 * @param  string  phone 		用户电话号码。
	 * @param  string  email 		用户电子邮件地址。
	 * @param  array   role_ids     用户所具有的角色ID列表。
	 * @param  array   groups    	待创建用户所归属的技能组ID列表。
	 * @param  array   skill_levels 修改后的技能级别列表。
	 * @author widuu <admin@widuu.com>
	 */
	 
	public function modifyUser($user_id = '', $display_name = '', $phone = '', $email = '', $role_ids = [], $groups = [], $skill_levels = [])
	{
		$this->getCommonParams();
		$this->params['Action'] = 'ModifyUser';
		$this->params['InstanceId']    = $this->instance_id;
		$this->params['AccessKeyId']   = $this->access_key;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['UserId']        = $user_id;
		$this->params['DisplayName']   = $display_name;
		$this->params['Phone'] 		   = $phone;
		$this->params['Email']   	   = $email;
		$this->params['RoleIds']   	   = $role_ids;
		$this->params['SkillGroups']   = $groups;
		$this->params['SkillLevels']   = $skill_levels;
		$this->params['Signature'] = $this->makeSign();
		return $this->getResponse();
	}
	
	/**
	 * 移除客服
	 *
	 * @param  string  user_ids   待移除的呼叫中心实例中的用户ID列表。
	 * @author widuu <admin@widuu.com>
	 */
	 
	public function removeUsers($user_ids = [])
	{
		$this->getCommonParams();
		$this->params['Action'] = 'RemoveUsers';
		$this->params['InstanceId']    = $this->instance_id;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['AccessKeyId']   = $this->access_key;
		$this->params['UserIds']	   = $user_ids;
		$this->params['Signature'] = $this->makeSign();
		return $this->getResponse();
	}
	
	/**
	 * 下载录音
	 *
	 * @param  string  user_ids   待移除的呼叫中心实例中的用户ID列表。
	 * @author widuu <admin@widuu.com>
	 */
	 
	public function downloadRecording( $filename = '' )
	{
		$this->getCommonParams();
		$this->params['Action'] = 'DownloadRecording';
		$this->params['InstanceId']    = $this->instance_id;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['AccessKeyId']   = $this->access_key;
		$this->params['FileName']	   = $filename;
		$this->params['accessKeySecret'] = $this->access_secret;
		$this->params['Signature'] = $this->makeSign();
		return $this->getResponse();
	}
	
	/**
	 * 获取通话详单列表
	 *
	 * @param  string  phone_number   电话号码
	 * @param  long    start_time     获取的历史数据的起始时间。缺省为0，代表从当天的0时开始。
	 * @param  long    end_time       获取的历史数据的终止时间。缺省为0，代表截止到目前的时间。
	 * @param  string  criteria       搜索条件
	 * @param  int     start          起始分页
	 * @param  int     page           分页大小
	 * @author widuu <admin@widuu.com>
	 */
	 
	public function listCallDetailRecords($phone_number = '',$start_time = 0, $end_time = 0, $criteria = '', $start = 0, $page = 20 )
	{
		$this->getCommonParams();
		$this->params['Action'] = 'ListCallDetailRecords';
		$this->params['InstanceId']    = $this->instance_id;
		$this->params['PhoneNumber']   = $phone_number;
		if( !empty($start_time) ){
			$this->params['StartTime'] = $start_time;
		}
		if( !empty($end_time) ){
			$this->params['StopTime'] = $end_time;
		}
		if( !empty($criteria) ){
			$this->params['Criteria'] = $criteria;
		}
		$this->params['PageNumber']    = $start;
		$this->params['PageSize'] 	   = $start;
		$this->params['SecurityToken'] = $this->security_token;
		$this->params['Signature'] = $this->makeSign();
		return $this->getResponse();
	}
	
	/**
	 * 获取返回结果
	 *
	 * @author widuu <admin@widuu.com>
	 */

	private function getResponse()
	{
		$context = Http::post(self::$action_url,$this->params);
		$result  = json_decode($context,true);
		$result  = $this->changeLowerKey($result);
		return   $result;
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
	 * @param  string  str  处理参数
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
	
	/**
	 * 处理首写字母小写
	 *
	 * @param  array  data  预处理数组
	 * @return array
	 */
	 
	private function changeLowerKey($data = [])
	{
		if( !is_array($data) ) return $data;
		$temp_array = [];
		foreach( $data as $k => $v ){
			$k = lcfirst($k);
			if( is_array($v) ){
				$v = $this->changeLowerKey($v);
			}
			$temp_array[$k] = $v;
		}
		return $temp_array;
	}
}