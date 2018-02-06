#阿里云呼叫中心SDK


##安装##

    composer require widuu/aliyuncall:@dev 
    
##使用示例##

    
    <?php
    
    require "src/Auth.php";
    
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
    $result = $call -> getConfig('AllowHangup');
    
    // 方法全部参考阿里云呼叫中心文档 https://help.aliyun.com/document_detail/63028.html?spm=a2c4g.11186623.6.566.hVNcED 默认全部开头字母小写
    

