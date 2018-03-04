# 阿里云呼叫中心SDK


## 安装

    composer require widuu/aliyuncall 
    
## 使用示例

    
    <?php
        
    require "vendor/autoload.php";
    use widuu\aliyunCall\Auth;
    
    $auth = new Auth([
    	'client_id'		=> '应用ID',
    	'client_secret' => '应用秘钥',
    	'redirect_uri'  => '回调地址'
    ]); 
    
    // 如果没有登录,跳转至登录页面
    $auth->login();
    
    // 跳转页面使用，获取access_token
    $access = $auth->getToken();
    
    // 官方获取配置信息使用方法
    
    use widuu\aliyunCall\Call;
    
    $call = new Call('呼叫中心实例ID','上一步存储的ACCESS_TOKEN');
	// 前端请求的参数json_decode解析后，传入参数
    $result = $call -> getConfig($name,$objectType,$objectId);
    
    // 方法全部参考阿里云呼叫中心文档 https://help.aliyun.com/document_detail/63028.html?spm=a2c4g.11186623.6.566.hVNcED 默认全部开头字母小写
    
### DEMO 说明

> 文件夹 `demo`，这个是官方demo的简化版本，所以请跟官方索要测试账号和密码

+ 1. 请求地址 `https://127.0.0.1:8443` 回调地址是 `https://127.0.0.1:8443/aliyun/auth/callback` 详细配置`base.php`
+ 2. 然后就可以布置测试了，记住回调地址目前是官方给的改了会出错。
+ 3. 如果您是用自己的测试，请在 `base.php` 填写自己的信息，替换自己的回调地址，然后将 `aliyun\auth\callback` 里边的 `index.php` 放到你的回调地址上

### 技术支持

邮箱 : admin@widuu.com
