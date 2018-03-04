<?php

use widuu\aliyunCall\Call;

require('base.php');

if( !isset($_SESSION['access_token']) ){
	$auth->login();
	exit();
}

// 接口
if( isset($_GET['action']) ){
	$request = json_decode($_POST['request'],true);
	extract($request);
	$call = new Call($instanceId,$_SESSION['access_token']);
	switch ($_GET['action']) {
		case 'ListSkillGroupsOfUser':
			$result = $call->listSkillGroupsOfUser($userId);
			break;
		case 'GetConfig':
			$result = $call->getConfig($name,$objectType,$objectId);
			break;
		case 'RequestLoginInfo':
			$result = $call->requestLoginInfo($userId);
			break;
		default:
			break;
	}
	die(json_encode($result));
}

?>
<!DOCTYPE html>
<html xmlns:th="http://www.thymeleaf.org" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="UTF-8">
    <title>CCC CRM Integration Demo</title>
    <link rel="stylesheet" type="text/css" href="//g.alicdn.com/acca/workbench-sdk/0.1.4/main.min.css"/>
    <style>
		.mini-workbench {
			position: fixed;
			border-radius: 100%;
			height: 50px;
			line-height: 50px;
			width: 50px;
			text-align: center;
			background: #00c1de;
			color: white;
			cursor: pointer;
			bottom: 44px;
			right: 10px;
		}

		.test-call {
			cursor: pointer;
			color: #00c1de;
		}

		#workbench {
			font-size: 14px;
			color: #4F5357;
			position: fixed;
			width: 265px;
			background: #FFFFFF;
			border: 1px solid #D7D8D9;
			box-shadow: 0 1px 4px 0 rgba(55, 61, 65, 0.14);
			bottom: 101px;
			right: 10px;
			transition: all .3s;
		}

    </style>
</head>

<body>
<div id="app">
    <div onclick="openWorkbench()" class="mini-workbench">
        云呼
    </div>
    <div id="workbench"></div>
</div>
<div>
    <h2 onclick="call()" class="test-call">拨号测试:135012345678</h2>
</div>
<script type="text/javascript" src="//g.alicdn.com/crm/acc-phone/1.0.3/SIPml-api.js"></script>
<script type="text/javascript" src="//g.alicdn.com/crm/acc-phone/1.0.3/index.js"></script>
<script type="text/javascript" src="//g.alicdn.com/acca/workbench-sdk/0.1.4/workbenchSdk.js"></script>
<script type="text/javascript">
		!(function (win) {
			win.workbench = new win.WorkbenchSdk({
				dom: 'workbench',
				instanceId: 'e0fb2d0a-a8c3-4c2f-a8c2-07cd7219c0b4',
				ajaxPath: '/index.php',
				ajaxMethod: 'post',
				header: true,
				onErrorNotify: function (error) {
					console.warn(error)
				},
				onCallComing: function (data) {
					console.log('这里该弹屏了');
				}
			})
			//面板展示开关
			win.workbenchOpen = true;
			openWorkbench = function () {
				var workbenchWrapper = document.querySelector("#workbench");
				var floater = document.querySelector(".mini-workbench");
				win.workbench.changeVisible(win.workbenchOpen);
				if (!win.workbenchOpen) {
					workbenchWrapper.style.display = 'none';
					floater.innerHTML = '云呼';
				} else {
					workbenchWrapper.style.display = 'block';
					floater.innerHTML = 'X';
				}
				win.workbenchOpen = !win.workbenchOpen
			}

			call = function () {
				win.workbench.call("135012345678")
			}

		})(window)

</script>
</body>

</html>
