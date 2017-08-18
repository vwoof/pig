<?php
/*
 * _______ _ _ _ _____ __ __ ______
 * |__ __| | (_) | | / ____| \/ | ____|
 * | | | |__ _ _ __ | | _| | | \ / | |__
 * | | | '_ \| | '_ \| |/ / | | |\/| | __|
 * | | | | | | | | | | <| |____| | | | |
 * |_| |_| |_|_|_| |_|_|\_\\_____|_| |_|_|
 */
/*
 * _________ ___ ___ ___ ________ ___ __ ________ _____ ______ ________
 * |\___ ___\\ \|\ \|\ \|\ ___ \|\ \|\ \ |\ ____\|\ _ \ _ \|\ _____\
 * \|___ \ \_\ \ \\\ \ \ \ \ \\ \ \ \ \/ /|\ \ \___|\ \ \\\__\ \ \ \ \__/
 * \ \ \ \ \ __ \ \ \ \ \\ \ \ \ ___ \ \ \ \ \ \\|__| \ \ \ __\
 * \ \ \ \ \ \ \ \ \ \ \ \\ \ \ \ \\ \ \ \ \____\ \ \ \ \ \ \ \_|
 * \ \__\ \ \__\ \__\ \__\ \__\\ \__\ \__\\ \__\ \_______\ \__\ \ \__\ \__\
 * \|__| \|__|\|__|\|__|\|__| \|__|\|__| \|__|\|_______|\|__| \|__|\|__|
 */
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace Portal\Controller;

use Common\Controller\HomebaseController;

/**
 * 首页
 */
class IndexController extends HomebaseController
{
    function _initialize() {
        header("Access-Control-Allow-Origin: *");
    }
    // 首页 小夏是老猫除外最帅的男人了
    public function index()
    {
        $this->display(":index");
    }

    public function do_register($username)
    {
        $channel = 0;
        $lat = 0;
        $lng = 0;
        $ua = '';
        if (isset($_REQUEST['channel']))
            $channel = intval($_REQUEST['channel']);
        if (isset($_REQUEST['ua']))
            $ua = $_REQUEST['ua'];
        $users_model = M("Users");
        
        // 自动创建帐号和密码
        // 随机创建
        $email = $username . '@any.com';
        $password = '123456';
        $data = array(
            'user_login' => $username,
            'user_email' => $email,
        	'level' => 0,
            'user_nicename' => '见习新手',
            'user_pass' => sp_password($password),
            'last_login_ip' => get_client_ip(0, true),
            'create_time' => date("Y-m-d H:i:s"),
            'last_login_time' => date("Y-m-d H:i:s"),
            'user_status' => 1,
            "user_type" => 2
        ) // 会员
;
        $rst = $users_model->add($data);
        if ($rst) {
            // 注册成功页面跳转
            $data['id'] = $rst;
            
            $ch_user_db = M('channel_user_relation');
            
            $wallet = array(
            		'user_id' => $rst,
                    'money' => 0,
            		'money3' => floatval(C('BEGINNER_MONEY_GIFT')),
                    'money2' => 0
            );
            
            $wallet_db = M('wallet');
            $wallet_db->add($wallet);
            
            // 记录日志
            $wallet_change_log_db = M('wallet_change_log');
            $change_log = array(
            		'user_id' => $rst,
            		'divide_ratio' => 0,
            		'fee' => 0,
            		'type' => 5,
            		'create_time' => date('Y-m-d H:i:s'),
            		'object_id' => 0,
            		'memo' => '新手注册赠送:' . C('BEGINNER_MONEY_GIFT')
            );
            $wallet_change_log_db->add($change_log);
            
            $channel_db = M('channels');
            // 获取父渠道信息
            $parent_channels = '';
            $parent_channel = $channel_db->where("id=$channel")->find();
            if ($parent_channel != null)
            {
                $parent_channels = $parent_channel["parent_channels"];
                if ($parent_channels == '')
                    $parent_channels = '' . $channel;
                else 
                    $parent_channels .= ',' . $channel;
            }
            
            // 注册渠道
           	$channel_data = array(
           			'name' => $username,
           			'status' => 0,
           			'parent_id' => $channel,
           			'create_time' => date('Y-m-d H:i:s'),
           			'admin_user_id' => $rst,
           	        'parent_channels' => $parent_channels,
           			'divide_ratio' => 0.3
           	);
           	$channel_db->add($channel_data);
            
            /*
            $total_visible_count = $ch_user_db->where("channel_id=$channel and is_visible=1")->count();
            $total_invisible_count = $ch_user_db->where("channel_id=$channel and is_visible=0")->count();
            
            $channel_data = M('channels')->where("id=$channel")->find();
            $is_visible = 1;
            if ($channel_data != null && $channel_data['amount_deduct'] > 0)
            {
                $need_count_count = floor(($total_visible_count + $total_invisible_count) / $channel_data['amount_deduct']);
                
                if ($total_invisible_count < $need_count_count)
                    $is_visible = 0;
            }
            */
            
            $is_visible = 1;
            
            $ch_data = array(
                'user_id' => $rst,
                'channel_id' => $channel,
                'is_visible' => $is_visible
            );
            $ch_user_db->add($ch_data);
            
            $action_log = M('user_action_log');
            $user_data = array(
                'user_id' => $rst,
                'action' => 'login',
                'ip' => get_client_ip(0, true),
                'create_time' => date('Y-m-d H:i:s'),
                'ua' => $ua,
            );
            $action_log->add($user_data);

            session('user', $data);
            
            return $rst;
        }
        else
        {
            return -1;
        }
    }

    public function any_login()
    {
        $users_model = M("Users a");
        
        $city = '深圳市';
        if (isset($_REQUEST['city']))
            $city = urldecode($_REQUEST['city']);
        
        session('city', $city);
        
        if (! isset($_COOKIE["login_name"])) {
            $username = date("YmdHis") . rand(100, 999);
            $this->do_register($username);
            setcookie("login_name", $username);
        } else {
            $username = $_COOKIE["login_name"];
            $user = $users_model->join('__CHANNEL_USER_RELATION__ b on b.user_id=a.id', 'left')->where("user_login='$username'")->field('a.*,b.channel_id')->find();
            if ($user == null)
                $this->do_register($username);
            else {
                $ch_user_db = M('channel_user_relation');
                if ($user['channel_id'] == 0 && isset($_REQUEST['channel']))
                {
                    $user['channel_id'] = $_REQUEST['channel'];
                    
                    $ch_user_db = M('channel_user_relation');
                    
                    $ch_data = array(
                        'channel_id' => intval($_REQUEST['channel'])
                    );
                    $ch_user_db->where('user_id=' . $user['id'])->save($ch_data);
                }
                
                $wallet_db = M('wallet');
                if ($wallet_db->where("user_id=" . $user['id'])->find() == null)
                {
                	$wallet = array(
                			'user_id' => $user['id'],
                			'money' => 0
                	);
                	$wallet_db->add($wallet);
                }
                
                $action_log = M('user_action_log');
                $data = array(
                    'user_id' => $user['id'],
                    'action' => 'login',
                    'ip' => get_client_ip(0, true),
                    'create_time' => date('Y-m-d H:i:s'),
                );
                $action_log->add($data);
                
                echo json_encode($user);
                
                session('user', $user);
            }
        }
        
        $this->redirect('list/index', array(
            'id' => 6
        ));
    }

    public function any_login_from()
    {
        $users_model = M("Users a");
    
        $city = '深圳市';
        if (isset($_REQUEST['city']))
            $city = urldecode($_REQUEST['city']);
        $login_name = $_REQUEST['login_name'];
        $ua = '';
        if (isset($_REQUEST['ua']))
            $ua = $_REQUEST['ua'];
        session('ua', $ua);
        
        if ($_REQUEST['channel'] == C('TEST_CHANNEL'))
        	session('is_admin_enter', '1');
        else
        {
            session('is_admin_enter', '0');
        }
        
        if ($login_name == null)
        {
            echo "<script>history.go(-1);</script>";
            return;
        }
    
        session('city', $city);
    
            $username = $login_name;
            $user = $users_model->join('__CHANNEL_USER_RELATION__ b on b.user_id=a.id', 'left')->where("user_login='$username'")->field('a.*,b.channel_id')->find();
            $ret = 0;
            if ($user == null)
                $ret = $this->do_register($username);
            else {
                $ch_user_db = M('channel_user_relation');
                /*
                if ($user['channel_id'] == 0 && isset($_REQUEST['channel']))
                {
                    $user['channel_id'] = $_REQUEST['channel'];
    
                    $ch_user_db = M('channel_user_relation');
    
                    $ch_data = array(
                        'channel_id' => intval($_REQUEST['channel'])
                    );
                    $ch_user_db->where('user_id=' . $user['id'])->save($ch_data);
                }*/
                
                $wallet_db = M('wallet');
                if ($wallet_db->where("user_id=" . $user['id'])->find() == null)
                {
                	$wallet = array(
                			'user_id' => $user['id'],
                            'money' => 0,
            		        'money3' => floatval(C('BEGINNER_MONEY_GIFT')),
                	        'money2' => 0
                	);
                	$wallet_db->add($wallet);
                }
                
                
                $action_log = M('user_action_log');
                $data = array(
                    'user_id' => $user['id'],
                    'action' => 'login',
                    'ip' => get_client_ip(0, true),
                    'create_time' => date('Y-m-d H:i:s'),
                    'ua' => $ua
                );
                $action_log->add($data);
    
                session('user', $user);
                
                $ret = 1;
            }
           
        if ($ret <= 0)
        {
            echo "<script>history.go(-1);</script>";
        }
        else
        {
            $_SESSION['is_tips'] = 0;
            
            redirect('index.php?g=Pig&m=index&a=index');
        }
    }
    
    public function wx_login()
    {
        $users_model = M("Users a");
    
        $city = '深圳市';
        if (isset($_REQUEST['city']))
            $city = urldecode($_REQUEST['city']);
        $login_name = $_REQUEST['openid'];
        $ticket = $_REQUEST['ticket'];
        $sign = $_REQUEST['sign'];
        $ticket2 = $_REQUEST['ticket2'];
        $sign2 = $_REQUEST['sign2'];
        $noncestr = $_REQUEST['noncestr'];
        $channel = $_REQUEST['channel'];
        
    	$openid = $_REQUEST['openid'];
    	$url = $openid . $ticket . $noncestr;
        $new_sign = md5(strtolower($url . C('LOGIN_KEY')));
        
        if ($new_sign != $sign)
        {
            echo "<script>setTimeout(function(){WeixinJSBridge.call('closeWindow');},2000);</script>";         
            return;
        }
        
        $url = 'wx_login' . $channel . $ticket2;
        $new_sign2 = md5(strtolower($url . C('LOGIN_KEY')));
        
        if ($new_sign2 != $sign2)
        {
            echo "<script>setTimeout(function(){WeixinJSBridge.call('closeWindow');},2000);</script>";
            return;
        }
                
        $ua = '';
        if (isset($_REQUEST['ua']))
            $ua = $_REQUEST['ua'];
        session('ua', $ua);
        session('openid',  $_REQUEST['openid']);
                
        if ($login_name == null)
        {
            echo "<script>history.go(-1);</script>";
            return;
        }
    
        session('city', $city);
        
        if ($_REQUEST['channel'] == C('TEST_CHANNEL'))
        	session('is_admin_enter', '1');
        else
        {
            session('is_admin_enter', '0');
        }
    
        $username = $login_name;
        $user = $users_model->join('__CHANNEL_USER_RELATION__ b on b.user_id=a.id', 'left')->where("user_login='$username'")->field('a.*,b.channel_id')->find();
        $ret = 0;
        if ($user == null)
            $ret = $this->do_register($username);
        else {
            $ch_user_db = M('channel_user_relation');

            if ($user['channel_id'] == 0 && isset($_REQUEST['channel']))
            {
                $user['channel_id'] = $_REQUEST['channel'];
            
                $ch_user_db = M('channel_user_relation');
            
                $ch_data = array(
                    'channel_id' => intval($_REQUEST['channel'])
                );
                $ch_user_db->where('user_id=' . $user['id'])->save($ch_data);
            }
            
            $wallet_db = M('wallet');
            if ($wallet_db->where("user_id=" . $user['id'])->find() == null)
            {
                $wallet = array(
                    'user_id' => $user['id'],
                    'money' => 0,
            		'money3' => floatval(C('BEGINNER_MONEY_GIFT')),
                    'money2' => 0
                );
                $wallet_db->add($wallet);
            }
            
            $action_log = M('user_action_log');
            $log_data = array(
                'user_id' => $user['id'],
                'action' => 'login',
                'ip' => get_client_ip(0, true),
                'create_time' => date('Y-m-d H:i:s'),
                'ua' => $ua
            );
            $action_log->add($log_data);
            
            // 不允许登录,跳转到别的地方
            if ($user['user_status'] == 0)
            {
                echo "<script>setTimeout(function(){WeixinJSBridge.call('closeWindow');},2000);</script>";
                return;
            }
            
            $user['openid'] = $_REQUEST['openid'];
            $users_model->where("id=" . $user['id'])->setField('openid', $_REQUEST['openid']);
    
            session('user', $user);
    
            $ret = 1;
        }
         
        if ($ret <= 0)
        {
            echo "<script>history.go(-1);</script>";
        }
        else
        {
            $_SESSION['is_tips'] = 0;
            
            $this->redirect('index.php?g=Pig&m=index&a=index');
        }
    }
 
    function is_weixin(){
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            return true;
        }
        return false;
    }
    
 // 入口
    public function entry()
    {
        $channel = '0';
        $is_admin = '0';
        if (isset($_REQUEST['channel']))
            $channel = $_REQUEST['channel'];
        
            if ($channel == C('TEST_CHANNEL'))
            {
            	$_SESSION['is_admin_enter'] = '1';
            }
            else
            {
            	$_SESSION['is_admin_enter'] = '0';
            }
        
        if (C('IS_STOPPED') == '1')
        {
        	if ($_SESSION['is_admin_enter'] != '1')
        	{
        	    if (empty(C('STOP_GOURL')))
        	    {
        	        echo "<script>setTimeout(function(){WeixinJSBridge.call('closeWindow');},2000);</script>";
        	    }
        	    else
        	    {
        	       $goto_url = str_replace('&amp;', '&', C('STOP_GOURL'));
        		   redirect($goto_url);
        	    }
        		
        		return;
        	}
        }
        
        $ticket = $_REQUEST['ticket'];
        $sign = $_REQUEST['sign'];
        $new_sign = md5($channel . $ticket . C('LOGIN_KEY'));
        
        if ($new_sign != $sign)
        {
            echo "<script>setTimeout(function(){WeixinJSBridge.call('closeWindow');},2000);</script>";
            return;
        }
        
        $hosts_db = M('hostnames');
        
        if (!$this->is_weixin())
        {
            vendor('phpqrcode.phpqrcode');//导入类库
            
            include APP_PATH . "Common/Common/upload.php";
            
            $data = M('ads_template')->where()->order("id asc")->find();
            
            // 不是微信,显示新的二维码
            $url = $data['url'];
            $level = 'L';
            $size = 4;
            
            $channel_id = $channel;
            
            $channel_db = M('channels');
            $admin_channel = $channel_db->where("id=$channel_id")->find();
            $channel_user_id = 0;
            if ($admin_channel != null)
            {
                $channel_user_id = $admin_channel['admin_user_id'];
            }
            
            $url = str_replace("{channel_id}", $channel_id, $url);

            // 获取域名生成二进制            
            $hosts = $hosts_db->where('status=1 and `type` in (0,2)')->order('`type` asc, update_time desc')->select();
            
            shuffle($hosts);
            $host = $hosts[0];
            
            $url = str_replace("{hostname}", $host['hostname'], $url);
            $ticket = time();
            $sign = md5($channel_id . $ticket . C('LOGIN_KEY'));
            $url .= '&ticket=' . $ticket . '&sign=' . $sign;

            $ids = date('YmdHis') . '_c' . '_' . $channel_id;
            
            $out_file = './data/upload/' . $ids . '.png';
            \QRcode::png($url,$out_file,$level,$size,2);
            
            $smeta = json_decode($data['smeta'],true);
            
            $bg_image = './data/upload/'.$smeta['thumb'];
            
            $ids = date('YmdHis') . '_c' . '_' . $channel_id . '_out';
            
            $out_file2 = './data/upload/' . $ids . '.png';
            
            $bg_image_c = imagecreatefromstring(file_get_contents($bg_image));
            
  
            $col = imagecolorallocate($bg_image_c,255,255,255);
            $content = 'ID:' . $channel_user_id;
            imagestring($bg_image_c,5, floatval($data['add_x']), floatval($data['add_y']) + floatval($data['height']) + 10,$content,$col);            
            
            image_copy_image($bg_image_c, $out_file, floatval($data['add_x']), floatval($data['add_y']), floatval($data['width']), floatval($data['height']), $out_file2);
            
            $this->assign('src', $out_file2);
            
            $this->display(':qr');
            
            return;
        }
        
        // 随机选择一个中转域名
        $hosts = $hosts_db->where('status=1 and `type` in (3,2)')->order('`type` desc, update_time desc')->select();
        shuffle($hosts);
        $host = $hosts[0];
        
        $ticket = time();
        $url = 'redir' . $channel . $ticket;
        $sign = md5(strtolower($url . C('LOGIN_KEY')));
        $goto_url = "http://"  . $host['hostname'] . '/portal/index/redir?channel=' . $channel . '&ticket=' . $ticket . '&sign=' . $sign;
        
        redirect($goto_url);
    }
    
    // 重新做多一次跳转
    public function redir()
    {
    	$hosts_db = M('hostnames');
    	
    	$channel = $_REQUEST['channel'];
    	$ticket = $_REQUEST['ticket'];
    	$sign = $_REQUEST['sign'];
    	
    	$url = 'redir' . $channel . $ticket;
    	$new_sign = md5(strtolower($url . C('LOGIN_KEY')));
    	
    	if ($new_sign != $sign)
    	{
    	    echo "<script>setTimeout(function(){WeixinJSBridge.call('closeWindow');},2000);</script>";
    		return;
    	}
    		
    	$goto_url = C('LOGIN_URL');
    	
    	// 落地域名做一次随机
    	$hosts = $hosts_db->where('status=1 and `type` in (1,2)')->order('`type` asc, update_time desc')->select();
    	shuffle($hosts);
    	$host = $hosts[0];
    	$ticket = time();
    	$url = 'wx_login' . $channel . $ticket;
    	$sign = md5(strtolower($url . C('LOGIN_KEY')));
    	$return_url = "http://"  . $host['hostname'] . '/portal/index/wx_login?channel=' . $channel . '&ticket2=' . $ticket . '&sign2=' . $sign;
    	
    	$jsapi_ticket = time();
    	$jsapi_sign = md5(strtolower(urlencode($return_url) . $jsapi_ticket . C('LOGIN_KEY')));
    	
    	redirect($goto_url . '?req_url=' . urlencode($return_url) . '&jsapi_ticket=' . $jsapi_ticket . '&sha=' . $jsapi_sign);
    }
    
    public function locate () {
        $latitude = $_REQUEST['latitude'];
        $longitude = $_REQUEST['longitude'];
        $cityname = $_REQUEST['cityname'];
        
        session('latitude', $latitude);
        session('longitude', $longitude);
        session('cityname', $cityname);
        
        echo json_encode(array('code' => 0));
    }
    
    public function ban_url() {
        $this->assign('tips', '系统维护中');
        $this->display(':error');
    }

}


