<?php
/**
 * 供别的平台使用的支付接口
 */
namespace Wxpay\Controller;

use Common\Controller\HomebaseController;

class YouchangpayController extends HomebaseController
{

    private $wx_pay_db = null;
    private $url = 'http://api.cmbxm.mbcloud.com/wechat/orders';
    private $wx_mch_db = null;

    function _initialize()
    {
        parent::_initialize();
        
        $this->wx_pay_db = M('wx_pay');
        $this->wx_mch_db = M('wx_mch');
    }
    // 从别的平台进来
    public function entry()
    {
        require_once "jssdk.php";
        
        $appid = C('YOUCHANG_APPID');
        $appsecret = C('YOUCHANG_APPSECRET');
        
        $price = $_REQUEST['price'];
        $body = '';
        if (isset($_REQUEST['body']))
            $body = $_REQUEST['body'];
        $mchid = $_REQUEST['mch'];
        $pay_goback = '';
        if (isset($_REQUEST['pay_goback']))
            $pay_goback = $_REQUEST['pay_goback'];
        $memo = '';
        if (isset($_REQUEST['memo']))
            $memo = $_REQUEST['memo'];
        $order_sn = $_REQUEST['order_sn'];
        
        $ticket = $_REQUEST['ticket'];
        $from_openid = $_REQUEST['openid'];
        $sign = $_REQUEST['sign'];
        
        $params_url = $order_sn. $price . $from_openid. urlencode($pay_goback) . $ticket;
        
        $new_sign = $this->sign($params_url, C('YOUCHANG_MCH_KEY'));

        if ($new_sign != $sign)
        {
        	redirect($_REQUEST['pay_goback']);
        	return;
        }

        $redirect_url = "http://" . $_SERVER["HTTP_HOST"] . "/index.php?g=Wxpay&m=youchangpay&a=login&mch=$mchid&memo=$memo&order_sn=$order_sn&body=$body&price=$price&pay_goback=" . urlencode($pay_goback) . '&from_openid=' . $from_openid. '&ticket=' . $ticket . '&sign=' . $sign;
        $jssdk = new \JSSDK($appid, $appsecret);
        $url = $jssdk->gotoAuth($redirect_url, "code", "snsapi_base", "STATE");
        
        redirect($url);
    }
    
    public function sign($par, $key)
    {
    	return md5($par. $key);
    }

    function getRandChar($length)
    {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;
        
        for ($i = 0; $i < $length; $i ++) {
            $str .= $strPol[rand(0, $max)]; // rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }
        
        return $str;
    }

    public function login()
    {
        require_once "jssdk.php";
        
        if (isset($_GET['code']))
            $code = $_GET["code"];
        else
            $code = '';
        
        $appid = C('YOUCHANG_APPID');
        $appsecret = C('YOUCHANG_APPSECRET');
        
        $jssdk = new \JSSDK($appid, $appsecret);
        $res = $jssdk->getAuthAccessToke($code);
        if (! property_exists($res, 'openid')) {
            // echo "<script>alert('请在微信打开');</script>";
        } else {}
        
        $rand_string = $this->getRandChar(16);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        $obj = json_decode($result);
        // curl_close($ch);
        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$obj->access_token}&type=jsapi";
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        echo curl_error($ch);
        $obj2 = json_decode($result);
        curl_close($ch);
        $timestamp = time();
        $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];
        $str = "jsapi_ticket={$obj2->ticket}&noncestr={$rand_string}&timestamp={$timestamp}&url={$url}";
        // print_r($str);
        $signature = sha1($str);
        
        if (! empty($_REQUEST['req_url']) || isset($_REQUEST['req_url'])) {
            $req_url = $_REQUEST['req_url'];
        } else {
            $req_url = 0;
        }
        
        $price = $_REQUEST['price'];
        $body = $_REQUEST['body'];
        $mchid = $_REQUEST['mch'];
        $pay_goback = $_REQUEST['pay_goback'];
        $memo = $_REQUEST['memo'];
        $from_order_sn = $_REQUEST['order_sn'];
        
        $mch = $this->wx_mch_db->where("id=$mchid")->find();
        
        if ($mch == null) {
            echo '参数缺少';
            return;
        }

        $cur_ticket = $_REQUEST['ticket'];
        $from_openid = $_REQUEST['from_openid'];
        $sign = $_REQUEST['sign'];
        
        $params_url = $from_order_sn. $price . $from_openid. urlencode($pay_goback) . $cur_ticket;
        
        $new_sign = $this->sign($params_url, C('YOUCHANG_MCH_KEY'));
        
        if ($new_sign != $sign)
        {
        	redirect($_REQUEST['pay_goback']);
        	return;
        }
        
        $order_sn = sp_get_order_sn();
        
        $data = array(
            'price' => $price,
            'body' => $body,
            'mch' => $mchid,
            'openid' => $res->openid,
            'order_sn' => $order_sn,
            'from_order_sn' => $from_order_sn,
            'status' => 0,
            'create_time' => date('Y-m-d H:i:s'),
            'memo' => $memo
        );
        
        $rst = $this->wx_pay_db->add($data);
        
        $data['id'] = $rst;
        
        $this->pay($data, $pay_goback);
    }
    
    public function ToUrlParams($params)
    {
        $buff = "";
        foreach ($params as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }
    
        $buff = trim($buff, "&");
        return $buff;
    }
    
    public function MakeSign($params)
    {
        require_once SITE_PATH . "/wxpay/log.php";
        
        //签名步骤一：按字典序排序参数
        ksort($params);
        $string = $this->ToUrlParams($params);
        
        $logHandler= new \CLogFileHandler("logs/".date('Y-m-d').'.log');
        $log = \Log::Init($logHandler, 15);        
        
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".C('YOUCHANG_MCH_KEY');
                
        \Log::DEBUG('makesign:' . $string);
    
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
    
        return $result;
    }
    
    private function postXmlCurl($xml, $url, $second = 30)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
    
        curl_setopt($ch,CURLOPT_URL, $url);
        //curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
        //curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new \Exception("curl出错，错误码:$error");
        }
    }

    public function pay($order, $goback)
    {
	    $price = $order['price'];
	    $order_sn = $order['order_sn'];
	    $openid = $order['openid'];
	    $body = $order['body'];
	    
        require_once SITE_PATH . '/swiftpass/Utils.class.php';
        require_once "wxpay/WxPay.JsApiPay.php";
        require_once SITE_PATH . "/wxpay/log.php";
        
        $params = array();
        $params['mch_id'] = C('YOUCHANG_MCHID');
        $params['nonce_str'] = mt_rand(time(),time()+rand());//随机字符串，必填项，不长于 32 位
        $params['sub_appid'] = C('YOUCHANG_APPID');
        $params['sub_openid'] = $openid;
        $params['body'] = '充值' . $price . '元';
        $params["out_trade_no"] = $order_sn;
        $params["total_fee"] = $price;
        $params['spbill_create_ip'] = get_client_ip();
        $params['notify_url'] = "http://" . $_SERVER['HTTP_HOST'] . "/api/youchangpay/notify_wx";
        $params['trade_type'] = 'JSAPI';
        $params['sign'] = $this->MakeSign($params);        
        
        $data = \Utils::toXml($params);
        
        $logHandler= new \CLogFileHandler("logs/".date('Y-m-d').'.log');
        $log = \Log::Init($logHandler, 15);
        
        \Log::DEBUG('YouchangpayController支付调用开始');
        
        \Log::DEBUG($data);
        
        $response = $this->postXmlCurl($data, $this->url);
        
        \Log::DEBUG('response:' . $response);

        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        if($values['return_code'] != 'SUCCESS'){
        	redirect($_REQUEST['pay_goback']);
            
            return;
        }
        
        $js_prepay_info = $values['js_prepay_info'];
        
        \Log::DEBUG($js_prepay_info);
        
        $this->assign('jsApiParameters', $js_prepay_info);
        $this->assign('goback', $_REQUEST['pay_goback']);
        
        $this->display(':youchang_pay');
    }
}
