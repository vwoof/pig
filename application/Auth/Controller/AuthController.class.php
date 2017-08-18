<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tuolaji <479923197@qq.com>
// +----------------------------------------------------------------------
/**
 * 功    能：聚合支付
 * 修改日期：2013-12-11
 */

namespace Auth\Controller;

use Common\Controller\HomebaseController;

class AuthController extends HomebaseController {
	
	public function _initialize() {
	    parent::_initialize();
	    
	    header("Content-Type:text/html;charset=UTF-8");
	}
	
	public function check()
	{
	    $ip = $_REQUEST['ip'];
	    $server_name = $_REQUEST['server_name'];
	    
	    $db = M('server_auth');
	    $server = $db->where("ip='$ip'")->find();
	    
	    if ($server == null)
	    {
	        $data = array(
	            'ip' => $ip,
	            'server_name' => $server_name,
	            'status' => 0,
	            'create_time' => date('Y-m-d H:i:s')
	        );
	        
	        $db->add($data);
	        
	        echo json_encode(array('code' => 0));
	    }
	    else 
	    {
	        if ($server['status'] == 2)    // 提示
	        {
	            echo json_encode(array('code' => -1, 'url' => urlencode('<script>alert("请联系QQ:3427523753")</script>')));
	            //echo json_encode(array('code' => -1, 'url' => urlencode('<script>location.href="http://www.baidu.com"</script>')));
	        }
	        else if ($server['status'] == 3)   // 禁止使用
	        {
	            echo json_encode(array('code' => -2, 'url' => urlencode('<script>alert("请联系QQ:3427523753")</script>')));
	        }
	        else
	            echo json_encode(array('code' => 0));
	    }
	}
}