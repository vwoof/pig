<?php
/**
 * 供别的平台使用的支付接口
 */
namespace Wxpay\Controller;

use Common\Controller\HomebaseController;

class WxpaytixianController extends HomebaseController {
    private $drawcash_db = null;
	function _initialize(){
		parent::_initialize();

		$this->drawcash_db= M('drawcash');
	}
	
	// 从别的平台进来
	public function entry() {
	    require_once "jssdk.php";
	
	    $appid = C('APPID');
	    $appsecret = C('APPSECRET');
	
	    $order_id = $_REQUEST['order_id'];
	    $goback= '';
	    if (isset($_REQUEST['goback']))
	    	$goback= $_REQUEST['goback'];
	    
	    $jsapi_ticket = $_REQUEST['jsapi_ticket'];
	    $jsapi_sign = $_REQUEST['sha'];
	    
	    $new_sign = md5(strtolower(urlencode($goback) . $jsapi_ticket . C('MCH_KEY')));
	    if ($jsapi_sign != $new_sign)
	    {
	        echo "<script>setTimeout(function(){WeixinJSBridge.call('closeWindow');},2000);</script>";
	        return;
	    } 
	    
	    $redirect_url = "http://" . $_SERVER['HTTP_HOST'] . "/index.php?g=Wxpay&m=wxpaytixian&a=login&order_id=$order_id&goback=" . urlencode($goback) . '&jsapi_ticket=' . $jsapi_ticket . '&sha=' . $jsapi_sign;
	    $jssdk = new \JSSDK($appid, $appsecret);
	    $url = $jssdk->gotoAuth($redirect_url, "code", "snsapi_base", "STATE");
	
	    redirect($url);
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
	
	/*
	public function login() {
	    require_once "jssdk.php";

	    if (isset($_GET['code']))
	        $code = $_GET["code"];
	    else
	        $code = '';
	
	    $appid = C('APPID');
	    $appsecret = C('APPSECRET');
	
	    $jssdk = new \JSSDK($appid, $appsecret);
	    $res = $jssdk->getAuthAccessToke($code);
	    if (!property_exists($res, 'openid'))
	    {
	        //echo "<script>alert('请在微信打开');</script>";
	    }
	    else
	    {
	    }
	
	    $rand_string = $this->getRandChar(16);
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret");
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	    $result = curl_exec($ch);
	    $obj = json_decode($result);
	    //curl_close($ch);
	    $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$obj->access_token}&type=jsapi";
	    curl_setopt($ch, CURLOPT_URL, $url);
	    $result = curl_exec($ch);
	    echo curl_error($ch);
	    $obj2 = json_decode($result);
	    curl_close($ch);
	    $timestamp = time();
	    $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
	    $str = "jsapi_ticket={$obj2->ticket}&noncestr={$rand_string}&timestamp={$timestamp}&url={$url}";
	    //print_r($str);
	    $signature = sha1($str);
	
	    if (!empty($_REQUEST['req_url']) || isset($_REQUEST['req_url'])) {
	        $req_url=$_REQUEST['req_url'];
	    } else {
	        $req_url=0;
	    }
	    
	    $order_id = $_REQUEST['order_id'];
	    
	    $drawcash = $this->drawcash_db->where("id=$order_id")->find();
	    
	    $this->drawcash_db->where("id=$order_id")->setField('openid', $res->openid);

	    redirect($_REQUEST['goback']);
	}
	*/
	    public function login() {
	    	require_once "jssdk.php";
	    	
	    	$jsapi_ticket = $_REQUEST['jsapi_ticket'];
	    	$jsapi_sign = $_REQUEST['sha'];
	    	 
	    	$new_sign = md5(strtolower(urlencode($_REQUEST['goback']) . $jsapi_ticket . C('MCH_KEY')));
	    	if ($jsapi_sign != $new_sign)
	    	{
	    	    echo "<script>setTimeout(function(){WeixinJSBridge.call('closeWindow');},2000);</script>";
	    	    return;
	    	}	    	
	    	
	    	if (isset($_GET['code']))
	    		$code = $_GET["code"];
	    		else
	    			$code = '';
	    			
	    			$appid = C('APPID');
	    			$appsecret = C('APPSECRET');
	    			
	    			$jssdk = new \JSSDK($appid, $appsecret);
	    			$res = $jssdk->getAuthAccessToke($code);
	    			if (!property_exists($res, 'openid'))
	    			{
	    				//echo "<script>alert('请在微信打开');</script>";
	    			}
	    			else
	    			{
	    			}
	    			
	    			$rand_string = $this->getRandChar(16);
	    			$ch = curl_init();
	    			curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret");
	    			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	    			$result = curl_exec($ch);
	    			$obj = json_decode($result);
	    			//curl_close($ch);
	    			$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$obj->access_token}&type=jsapi";
	    			curl_setopt($ch, CURLOPT_URL, $url);
	    			$result = curl_exec($ch);
	    			echo curl_error($ch);
	    			$obj2 = json_decode($result);
	    			curl_close($ch);
	    			$timestamp = time();
	    			$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
	    			$str = "jsapi_ticket={$obj2->ticket}&noncestr={$rand_string}&timestamp={$timestamp}&url={$url}";
	    			//print_r($str);
	    			$signature = sha1($str);
	    			
	    			if (!empty($_REQUEST['req_url']) || isset($_REQUEST['req_url'])) {
	    				$req_url=$_REQUEST['req_url'];
	    			} else {
	    				$req_url=0;
	    			}
	    			
	    			$ticket = time();
	    			$sign = md5(strtolower($res->openid . $ticket . $rand_string . C('LOGIN_KEY')));
	    			
	    			redirect($_REQUEST['goback'] . '&openid=' . $res->openid . '&noncestr=' . $rand_string . '&ticket=' . $ticket . '&sign=' . $sign);
	    }
}
