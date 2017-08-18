<?php
/**
 * 供别的平台使用的支付接口
 */
namespace Wxpay\Controller;

use Common\Controller\HomebaseController;

class ZszfpayController extends HomebaseController {
    private $wx_pay_db = null;
    private $wx_mch_db = null;
    function _initialize(){
        parent::_initialize();
    
        $this->wx_pay_db = M('wx_pay');
        $this->wx_mch_db = M('wx_mch');
    }
    // 从别的平台进来
    public function entry() {
    	$price = $_REQUEST['price'];
    	$body = $_REQUEST['body'];
    	$mchid = $_REQUEST['mch'];
    	$memo = $_REQUEST['memo'];
    	$from_order_sn = $_REQUEST['order_sn'];
    	$ticket = $_REQUEST['ticket'];
    	$from_openid = $_REQUEST['openid'];
    	$sign = $_REQUEST['sign'];
    	
    	$params_url = $from_order_sn. $price . $from_openid. $ticket;
    	
    	$new_sign = $this->sign($params_url, C('ZSZF_KEY'));
    	
    	if ($new_sign != $sign)
    	{
    	    $user = M('users')->where("openid='$from_openid'")->find();
    	    // 日志
    	    $action_log = M('user_action_log');
    	    $log_data = array(
    	        'user_id' => $user['id'],
    	        'action' => 'hack',
    	        'params' => 'ZSZF:支付签名不正确:' . $price,
    	        'ip' => get_client_ip(0, true),
    	        'create_time' => date('Y-m-d H:i:s')
    	    );
    	    $action_log->add($log_data);
    	    
    	    echo "<script>setTimeout(function(){WeixinJSBridge.call('closeWindow');},2000);</script>";
    		return;
    	}
    	
    	$mch = $this->wx_mch_db->where("id=$mchid")->find();
    	
    	if ($mch == null)
    	{
    		echo "<script>setTimeout(function(){WeixinJSBridge.call('closeWindow');},2000);</script>";
    		return;
    	}
    	
    	$data = $this->wx_pay_db->where("from_order_sn='$from_order_sn'")->find();
    	
    	if ($data == null)
    	{
	    	$order_sn = sp_get_order_sn();
	    	
	    	$data = array(
	    			'price' => $price,
	    			'body' => $body,
	    			'mch' => $mchid,
	    			'order_sn' => $order_sn,
	    			'from_order_sn' => $from_order_sn,
	    			'status' => 0,
	    	        'channel' => 'ZSZF_PAY',
	    	        'channel_mch' => C('ZSZF_APPID'),
	    			'create_time' => date('Y-m-d H:i:s'),
	    			'memo' => $memo
	    	);
	    	
	    	$rst = $this->wx_pay_db->add($data);
	    	
	    	$data['id'] = $rst;
    	}
    	
    	$this->pay($data);
    }
    

    function getRandChar($length){
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol)-1;
    
        for($i=0;$i<$length;$i++){
            $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }
    
        return $str;
    }
    
    public function sign($par, $key)
    {
    	return md5($par. $key);
    }

    private function pay($order)
    {
    	require_once SITE_PATH . "/wxpay/log.php";
    	
    	$logHandler= new \CLogFileHandler("logs/zszf_".date('Y-m-d').'.log');
    	$log = \Log::Init($logHandler, 15);     
    	
	    $price = $order['price'];
	    $order_sn = $order['order_sn'];
	    $openid = $order['openid'];
	    $body = $order['body'];
	    
	    $url = "http://zsfaka.com/pay.php?zh=$order_sn&appid=" . C('ZSZF_APPID') . "&tyid=1&jine=" . $price;
	    
	    redirect($url);
    }
}
