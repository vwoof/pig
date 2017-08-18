<?php 
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
//require_once 'log.php';

//初始化日志
//$logHandler= new CLogFileHandler("logs/".date('Y-m-d').'.log');
//$log = Log::Init($logHandler, 15);
$order_sn = $_GET['order_sn'];
$goback = $_GET['goback'];
//打印输出数组信息
function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#00ff55;'>$key</font> : $value <br/>";
    }
}

//①、获取用户openid
$tools = new JsApiPay();
$openId = $_GET['openid'];

//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("商品信息：".$_GET['body']);//商品或支付单简要描述
$input->SetAttach($_GET['order_sn']);//附加数据
//$input->SetAttach("地址".$_GET['addre']);//附加数据
//$input->SetOut_trade_no(WxPayConfig::$MCHID.date("YmdHis"));//订单号
$input->SetOut_trade_no($_GET['order_sn']);//订单号
$input->SetTotal_fee($_GET['total']);//总价
$input->SetTime_start(date("YmdHis"));//开始时间
$input->SetTime_expire(date("YmdHis", time() + 3600));
$input->SetGoods_tag("test");//商品标记
$input->SetNotify_url("http://" . $_SERVER['SERVER_NAME'] . "/api/wxpay/notify_wx");//回调通知地址
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
//echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
//printf_info($order);
$jsApiParameters = $tools->GetJsApiParameters($order);

//获取共享收货地址js函数参数
//$editAddress = $tools->GetEditAddressParameters();

//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/**
 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */
 

?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/> 
    <title>微信支付</title>
    <script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
				var type = '<?php echo $_REQUEST['type']; ?>';
				//WeixinJSBridge.log(res.err_msg);
				if (res.err_msg.indexOf('ok') != -1)    // 支付成功
				{
					if (type==1) {
						location.href = '<?php echo urldecode($goback); ?>&ret=weichat_pay_ok';
					} else {
						location.href = '<?php echo urldecode($goback); ?>&ret=weichat_pay_ok';
					}
					
				}
				else
				{	
					if (type==1) {
						location.href = '<?php echo urldecode($goback); ?>&ret=weichat_pay_failed';	
					} else {
						location.href = '<?php echo urldecode($goback); ?>&ret=weichat_pay_failed';
					}
					
				}
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	</script>
	<script type="text/javascript">
	//获取共享地址
	function editAddress()
	{
	}
	
	window.onload = function(){
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', editAddress, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', editAddress); 
		        document.attachEvent('onWeixinJSBridgeReady', editAddress);
		    }
		}else{
			editAddress();
		}
	};

	callpay();
	
	</script>
</head>
<body>
    <br/>
    <!--
    <font color="#9ACD32"><b>该笔订单支付金额为<span style="color:#f00;font-size:50px">1分</span>钱</b></font><br/><br/>
	<div align="center">
		<button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>
	</div>
	 -->
</body>
</html>