<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="user-scalable=no, width=320">
    <meta name="format-detection" content="telephone=no" />
    <title><?php echo ($site_name); ?></title>
    <link rel="stylesheet" href="/qqonline_ex/themes/simplebootx_pig_fake/Public/cssdb/laohu.css" />
    <script src="/qqonline_ex/themes/simplebootx_pig_fake/Public/jsdb/jquery.min.js" type="application/javascript"></script>
    <script src="/qqonline_ex/themes/simplebootx_pig_fake/Public/jsdb/jquery.mobile-1.4.5.min.js" type="application/javascript"></script>
    <script src="/qqonline_ex/themes/simplebootx_pig_fake/Public/jsdb/jquery.cookie.js" type="application/javascript"></script>
    <script src="/qqonline_ex/themes/simplebootx_pig_fake/Public/jsdb/jquery.shCircleLoader.js" type="text/javascript"></script>
    <style>
        .ui-loader-default
        {
            display: none;
        }
        .ui-mobile-viewport
        {
            border: none;
        }
        .ui-page
        {
            padding: 0;
            margin: 0;
            outline: 0;
        }
        #hidebg
        {
            position: absolute;
            left: 0px;
            top: 0px;
            background-color: #7D7D7D;
            width: 100%; /*宽度设置为100%，这样才能使隐藏背景层覆盖原页面*/
            height: 120%;
            filter: alpha(opacity=80); /*设置透明度为60%*/
            opacity: 0.8; /*非IE浏览器下设置透明度为60%*/
            display: none; /* http://www.jb51.net */
            z-index: 998;
        }
        #hidebox
        {
            position: absolute;
            width: 400px;
            height: 300px;
            top: 200px;
            left: 30%;
            background-color: #fff;
            display: none;
            cursor: pointer;
            z-index: 4;
        }
        .slide-mask
        {
            position: relative;
            overflow: hidden;
            height: 100px;
        }
        *
        {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        #FontScroll
        {
            height: 30px;
            line-height: 30px;
            overflow: Hidden;
            padding: 5px 0;
            margin: 0 auto;
        }
        #FontScroll .line
        {
            text-align: center;
            width: 100%;
        }
        #FontScroll .fontColor a
        {
            color: red;
        }
        
        #shclDefault
        {
            width: 50px;
            height: 50px;
            margin-left: 125px;
            margin-top: 60px;
            position: absolute;
            z-index: 10;
        }
    </style>
</head>
<body align="center" style="background: #F2F2F2;">
    <input type="hidden" id="sm_timestamp" name="sm_timestamp" value="1502521861"  />
    <input type="hidden" id="sm_noncestr" name="sm_noncestr"  value="oMMQCNlefRmXrvQ" />
    <input type="hidden" id="sm_signature" name="sm_signature"  value="0BB96433A2C257FEC5B175C1456658209982AF4C" />
    <input type="hidden" id="duobao_result" name="duobao_result"  value="" />
    <div class="all">
        <div class="content" style="width: 95%;">
            <div id="FontScroll">
                <ul>
                    <li class="slide" style="font-family: 'Hiragino Sans GB', 'Microsoft YaHei','WenQuanYi Micro Hei', sans-serif;">
                        <font style="color: #7E7E84;" id="lun1"></font><font style="color: #7E7E84;">获利</font>
                        <font style="color: #EE3844;" id="qian1"></font><font style="color: #7E7E84;">元</font></li>
                    <li class="slide" style="font-family: 'Hiragino Sans GB', 'Microsoft YaHei','WenQuanYi Micro Hei', sans-serif;">
                        <font style="color: #7E7E84;" id="lun2"></font><font style="color: #7E7E84;">获利</font>
                        <font style="color: #EE3844;" id="qian2"></font><font style="color: #7E7E84;">元</font></li>
                    <li class="slide" style="font-family: 'Hiragino Sans GB', 'Microsoft YaHei','WenQuanYi Micro Hei', sans-serif;">
                        <font style="color: #7E7E84;" id="lun3"></font><font style="color: #7E7E84;">获利</font>
                        <font style="color: #EE3844;" id="qian3"></font><font style="color: #7E7E84;">元</font></li>
                    <li class="slide" style="font-family: 'Hiragino Sans GB', 'Microsoft YaHei','WenQuanYi Micro Hei', sans-serif;">
                        <font style="color: #7E7E84;" id="lun4"></font><font style="color: #7E7E84;">获利</font>
                        <font style="color: #EE3844;" id="qian4"></font><font style="color: #7E7E84;">元</font></li>
                    <li class="slide" style="font-family: 'Hiragino Sans GB', 'Microsoft YaHei','WenQuanYi Micro Hei', sans-serif;">
                        <font style="color: #7E7E84;" id="lun5"></font><font style="color: #7E7E84;">获利</font>
                        <font style="color: #EE3844;" id="qian5"></font><font style="color: #7E7E84;">元</font></li>
                </ul>
            </div>
            <script>
                (function ($) {
                    $.fn.FontScroll = function (options) {
                        var d = { time: 5000, s: 'fontColor', num: 1 }
                        var o = $.extend(d, options);


                        this.children('ul').addClass('line');
                        var _con = $('.line').eq(0);
                        var _conH = _con.height(); //滚动总高度
                        var _conChildH = _con.children().eq(0).height(); //一次滚动高度
                        var _temp = _conChildH;  //临时变量
                        var _time = d.time;  //滚动间隔
                        var _s = d.s;  //滚动间隔


                        _con.clone().insertAfter(_con); //初始化克隆

                        //样式控制
                        var num = d.num;
                        var _p = this.find('li');
                        var allNum = _p.length;

                        _p.eq(num).addClass(_s);


                        var timeID = setInterval(Up, _time);
                        this.hover(function () { clearInterval(timeID) }, function () { timeID = setInterval(Up, _time); });

                        function Up() {
                            _con.animate({ marginTop: '-' + _conChildH });
                            //样式控制
                            _p.removeClass(_s);
                            num += 1;
                            _p.eq(num).addClass(_s);

                            if (_conH == _conChildH) {
                                _con.animate({ marginTop: '-' + _conChildH }, "normal", over);
                            } else {
                                _conChildH += _temp;
                            }
                        }
                        function over() {
                            _con.attr("style", 'margin-top:0');
                            _conChildH = _temp;
                            num = 1;
                            _p.removeClass(_s);
                            _p.eq(num).addClass(_s);
                        }
                    }
                })(jQuery);

                $('#FontScroll').FontScroll({ time: 5000, num: 1 });
			
            </script>
            <div style="width: 299px; border: 1px solid #EEEEEE; margin: 0 auto; margin-top: 10px;
                background: white; float: left; box-sizing: border-box; height: 298px; border-radius: 4px;">
                <div style="float: left; margin-left: 10px; font-size: 14px; color: black; line-height: 46px;
                    margin-top: 8px;">
                    <div style="float: left">
                        <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/img/1-4.png" width="25" height="25" /></div>
                    <div style="float: left; margin-top: -7px; margin-left: 10px;">
                        小猪</div>
                </div>
                <div style="float: right; font-size: 12px; margin-top: 10px; margin-right: 10px;
                    color: white" id="yue">
                    <div>
                        <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/imgdb/bit2.jpg" width="70" height="30" /></div>
                    <div style="margin-top: -27px; line-height: 17px;">
                        余额充值</div>
                </div>
                <!--开始选择开始-->
                <div style="clear: both">
                </div>
                <div style="float: left; margin-left: 10px; font-size: 14px; color: black; line-height: 46px;">
                    <div style="float: left;">
                        数量</div>
                    <div style="float: left; margin-top: 8px; color: white; margin-left: 25px; font-size: 12px;"
                        id="order_min">
                        <div>
                            <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/imgdb/bit1.jpg" width="40" height="30" /></div>
                        <div style="margin-top: -57px;">
                            最小</div>
                    </div>
                    <div style="margin-left: 40px; float: left; color: #498FE1; width: 50px;">
                        <font id="myorder">1</font> 手</div>
                    <div style="float: right; margin-top: 8px; color: white; margin-left: 53px; font-size: 12px;"
                        id="order_max">
                        <div>
                            <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/imgdb/bit1.jpg" width="40" height="30" /></div>
                        <div style="margin-top: -57px;">
                            最大</div>
                    </div>
                </div>
                <div style="float: left; color: white; margin-left: 63px; font-size: 12px;" id="order_jian">
                    <div>
                        <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/imgdb/bit1.jpg" width="40" height="30" /></div>
                    <div style="margin-top: -27px; line-height: 17px;">
                        - 1</div>
                </div>
                <div style="float: left; color: white; margin-left: 21px; font-size: 12px;" id="order_jia">
                    <div>
                        <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/imgdb/bit1.jpg" width="40" height="30" /></div>
                    <div style="margin-top: -27px; line-height: 17px;">
                        + 1</div>
                </div>
                <div style="float: left; color: white; margin-left: 22px; font-size: 12px;" id="order_cheng">
                    <div>
                        <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/imgdb/bit1.jpg" width="40" height="30" /></div>
                    <div style="margin-top: -27px; line-height: 17px;">
                        x 2</div>
                </div>
                <div style="float: left; color: white; margin-left: 21px; font-size: 12px;" id="order_chu">
                    <div>
                        <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/imgdb/bit1.jpg" width="40" height="30" /></div>
                    <div style="margin-top: -27px; line-height: 17px;">
                        ÷ 2</div>
                </div>
                <!--开始选择结束-->
                <!--猜大小单双开始-->
                <div style="clear: both">
                </div>
                <div style="float: left; color: white; margin-top: 16px; margin-left: 8px; font-size: 16px;"
                    id="caida">
                    <div>
                        <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/imgdb/bit3.jpg" width="65" height="30" /></div>
                    <div style="margin-top: -27px; line-height: 17px;">
                        猜大</div>
                </div>
                <div style="float: left; color: white; margin-top: 16px; margin-left: 8px; font-size: 16px;"
                    id="caixiao">
                    <div>
                        <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/imgdb/bit3.jpg" width="65" height="30" /></div>
                    <div style="margin-top: -27px; line-height: 17px;">
                        猜小</div>
                </div>
                <div style="float: left; color: white; margin-top: 16px; margin-left: 8px; font-size: 16px;"
                    id="caidan">
                    <div>
                        <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/imgdb/bit4.jpg" width="65" height="30" /></div>
                    <div style="margin-top: -27px; line-height: 17px;">
                        猜单</div>
                </div>
                <div style="float: left; color: white; margin-top: 16px; margin-left: 8px; font-size: 16px;"
                    id="caishuang">
                    <div>
                        <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/imgdb/bit4.jpg" width="65" height="30" /></div>
                    <div style="margin-top: -27px; line-height: 17px;">
                        猜双</div>
                </div>
                <!--猜大小单双结束-->
                <div style="float: left; margin-left: 10px; font-size: 12px; margin-top: 18px; color: #A8A8A8;
                    line-height: 18px;">
                    可用余额</div>
                <div style="float: right; margin-right: 10px; font-size: 12px; margin-top: 18px;
                    color: #ED5758">
                    <font id="money">0.0</font> 元</div>
                <div style="clear: both">
                </div>
                <div style="float: left; margin-left: 10px; font-size: 12px; color: #A8A8A8">
                    预期收益</div>
                <div style="float: right; margin-right: 10px; font-size: 12px; color: #498FE1">
                    <font id="yuqi">10.0</font> 元</div>
                <div style="clear: both">
                </div>
                <div style="float: left; margin-left: 10px; font-size: 12px; color: #A8A8A8">
                    手续费</div>
                <div style="float: right; margin-right: 10px; font-size: 12px; color: #A8A8A8">
                    <font id="shouxu">1.0</font> 元</div>
                <div style="clear: both">
                </div>
                <div style="float: left; margin-left: 5px; font-size: 12px; color: #A8A8A8; margin-top: 5px;
                    line-height: 18px;">
                    <span id="dbtishimsg">每次"猜大"、 "猜小"、 "猜单"、 "猜双" 充值0.1元或提</span></div>
                <div style="float: left; margin-left: 5px; font-size: 12px; color: #A8A8A8;">
                    现1元后,微信交易单号尾数"5 ~ 9"为大、 "0 ~ 4"为小</div>
                <div style="float: left; margin-left: 5px; font-size: 12px; color: #A8A8A8;">
                    微信交易单号尾数"1,3,5,7,9"为单、 "0,2,4,6,8"为双</div>
            </div>
            <div id="shclDefault">
            </div>
            <div style="width: 280px; background: white; border-radius: 2px; left: 20px; top: 80px;
                position: absolute; z-index: 999; height: 328px; line-height: 20px; border-radius: 4px;
                display: none;" id="modal3">
                <div style="text-align: center; margin-top: 30px; font-size: 16px;">
                    夺宝规则
                </div>
                <div style="margin-left: 17px; margin-right: 10px; margin-top: 10px; color: #A8A8A8;
                    text-align: left;">
                    <span id="gz1111">1、每次微信提现都会生成一个唯一交易单号, 该单号公平、 公正、 公开, 仅由微信平台生成。</span></div>
                <div style="margin-left: 17px; margin-right: 10px; color: #A8A8A8; text-align: left;">
                    <span id="gz2222">2、尾数夺宝采集微信提现交易单号的尾数作为夺宝依据, 尾数 5~9 为大、 0~4 为小。</span></div>
                <div style="margin-left: 17px; margin-right: 10px; color: #A8A8A8; text-align: left;">
                    <span id="gz3333">3、猜大猜小后微信提现 1.0元的金额, 提现后微信提现交易单号立刻显示。</span></div>
                <div style="margin-left: 17px; margin-right: 10px; color: #A8A8A8; text-align: left;">
                    4、每手 10 元, 每手 1 元 手续费, 每次夺宝最小 1 手, 最大 20 手。</div>
                <div style="margin-top: 20px; border-top: 1px solid #F0F0F0; color: #00C200; font-size: 16px;
                    line-height: 45px;" id="know">
                    知道了
                </div>
            </div>
            <div style="width: 260px; background: white; border-radius: 2px; left: 30px; top: 80px;
                position: absolute; z-index: 999; height: 326px; line-height: 20px; border-radius: 4px;
                display: none;" id="modal4">
                <div style="text-align: center; margin-top: 30px;">
                    <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/imgdb/4-1.png" width="40" height="40" />
                </div>
                <div style="text-align: center; margin-top: 10px; font-size: 16px;">
                    夺宝成功
                </div>
                <div style="text-align: center; font-size: 14px; color: #A8A8A8; margin-top: 4px;">
                    交易单号
                </div>
                <div style="text-align: center; font-size: 14px; color: #A8A8A8; margin-top: 20px;">
                    <font id="yingqian">32132132131231231231231</font><font id="yinghou" style="font-size: 20px;">9</font>
                </div>
                <div style="text-align: center; font-size: 14px; color: #A8A8A8;">
                    <font id="trend_ying">猜大</font> <font id="caidanum">1</font> 手
                </div>
                <div style="text-align: center; font-size: 14px; color: #ED5758; margin-top: 20px;">
                    盈利 + <font id="caidawin" style="font-size: 30px;">10.0</font> 元
                </div>
                <div style="margin-top: 20px; border-top: 1px solid #F0F0F0; color: #00C200; font-size: 16px;
                    line-height: 45px;" id="caidaknow">
                    确定
                </div>
            </div>
            <div style="width: 260px; background: white; border-radius: 2px; left: 30px; top: 80px;
                position: absolute; z-index: 999; height: 326px; line-height: 20px; border-radius: 4px;
                display: none;" id="modal5">
                <div style="text-align: center; margin-top: 30px;">
                    <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/imgdb/5-1.png" width="40" height="40" />
                </div>
                <div style="text-align: center; margin-top: 10px; font-size: 16px;">
                    夺宝失败
                </div>
                <div style="text-align: center; font-size: 14px; color: #A8A8A8; margin-top: 4px;">
                    交易单号
                </div>
                <div style="text-align: center; font-size: 14px; color: #A8A8A8; margin-top: 20px;">
                    <font id="shibaiqian">32132132131231231231231</font><font id="shibaihou" style="font-size: 20px;">9</font>
                </div>
                <div style="text-align: center; font-size: 14px; color: #A8A8A8; margin-top: 20px;">
                    <font id="trend_shu">猜大</font> <font id="caixiaonum">1</font> 手
                </div>
                <div style="text-align: center; font-size: 14px; color: #1DBAA4; margin-top: 20px;">
                    亏损 - <font id="caixiaowin" style="font-size: 30px;">10.0</font> 元
                </div>
                <div style="margin-top: 20px; border-top: 1px solid #F0F0F0; color: #00C200; font-size: 16px;
                    line-height: 45px;" id="caixiaoknow">
                    确定
                </div>
            </div>
            <div id="hidebg">
            </div>
            <div id="modal6" style="margin-left: -10px; position: absolute; top: 0px; height: 568px;
                background: #B4B4B4; text-align: center; display: none;">
                <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/imgdb/bgbgtx.jpg" width="320" id="yanzhengimgs" />
                <button style="height: 40px; width: 240px; color: #00C200; position: relative; border: 0px;
                    border-radius: 8px; font-size: 16px; background: white; top: -90px;" id="okok">
                    知道了</button>
            </div>
            <style>
                .divewm
                {
                    background: #fff;
                    padding: 10px;
                    border-radius: 3px;
                    box-shadow: 0 0 8px #777;
                    position: absolute;
                    top: 10%;
                    left: 6%;
                    width: 80%;
                    z-index: 100000;
                }
                .ttl
                {
                    border: 1px solid #f25f55;
                    overflow: hidden;
                    text-align: center;
                }
                .ttl .fl
                {
                    background: #f25f55;
                    float: left;
                    padding: 8px 0;
                    color: #fff;
                    width: 20%;
                    font-size: 10px;
                }
                .ttl .fr
                {
                    float: left;
                    padding: 5px 10px;
                    width: 70%;
                    text-align: left;
                }
                .eimg
                {
                    text-align: center;
                }
                .eimg #qrcode img
                {
                    width: 50%;
                    margin: 0 auto;
                    margin-bottom: 10px;
                }
                .jt
                {
                    display: block;
                    margin: 0 auto;
                    width: 10%;
                }
                .dksys
                {
                    color: #fff;
                    display: block;
                    background: #3cb034;
                    text-decoration: none;
                    padding: 10px;
                    text-align: center;
                    border-radius: 3px;
                    border: 1px solid #1f8f17;
                }
                .dksys img
                {
                    vertical-align: middle;
                    margin-right: 2px;
                }
                .dbbg2
                {
                    background: rgba(0,0,0,0.3);
                    position: fixed;
                    width: 100%;
                    height: 100%;
                    z-index: 10;
                    top: 0;
                    left: 0;
                    z-index: 10;
                }
            </style>
            
            <div id="ewmbg" style="display: none">
                <!-- <p>
                        长按图片，点击保存图片</p>
                    <p>
                        返回微信，点击扫一扫，选择相册完成充值</p>
                    <p>
                        支付金额增加到账户余额里</p> -->
            </div>
            <div class="jiazaiquan">
                <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/img/6-1.png" alt="" style="display: none;">
            </div>
            <div id="modal7" style="display: none;">
                
                <div class="divewm">
                    <div class="divtx">
                        <p style="background: #ff3a42">
                            <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/img/chongzhioico.png" width="35px"></p>
                    </div>
                    <div class="divdb2">
                        <h4>
                            根据微信<span>充值</span>生成唯一订单尾数作为依据，尾数0~4为小，5~9为大。</h4>
                    </div>
                    <!-- <div class="ttl">
                    <div class="fl">第一步</div>
                    <div class="fr">长按二维码，保存图片</div>
               </div> -->
                    <div class="eimg">
                        <!-- <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/img/jiantou.png" alt="" class="jt" style="margin-top: 5px;"> -->
                        <div id="qrcode">
                        </div>
                    </div>
                    <!-- <div class="ttl">
                    <div class="fl" style="padding: 26px 0;">第二步</div>
                    <div class="fr">点击下方按钮，点击右上角【相册】选中刚才保存的二维码，点完成</div>
                </div> -->
                    <div style="margin: 5px 0 10px">
                        <!-- <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/img/jiantou.png" alt="" class="jt"> -->
                        <!-- <a href="" class="dksys">
                    <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/img/sys.png" alt="" width="20px;">
                    点击打开【微信扫一扫】</a> -->
                        <a class="dksys" id="oneScan" href="javascript:(0);">
                            <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/img/sys.png" alt="" width="20px;">
                            点击打开【微信扫一扫】</a>
                        <p style="color: #ff3a42; font-size: 12px;">
                            长按二维码保存图片，打开扫一扫进行充值，支付金额增加到账户余额里</p>
                        <!--  <p style="color: #3cb034"></p> -->
                    </div>
                </div>
                <!-- <a class="dksys" id="oneScan" href="javascript:(0);">点击打开【微信扫一扫】</a> -->
                <!--  <style>
                    .dksys
                    {
                        position: relative;
                        z-index: 33300;
                        color: Red;
                    }
                </style> -->
                <div class="dbbg2">
                </div>
            </div>
            <script>
                $('.dbbg2').click(function () {
                    //flag = 0;
                    //$('#modal7').fadeOut(300);
                    //$('.dbbg2').fadeOut(300);
                    window.location = window.location;
                });
            </script>
            <style>
                #modal7 img
                {
                    /* width: 165px;
                    height: 165px; background: red;
                    position: absolute;
                    z-index: 1000;
                    left: 25%;
                    top: 20%;*/
                }
                #ewmbg
                {
                    width: 100%;
                    height: 100%;
                    background: rgba(0,0,0,0.5);
                    position: fixed;
                    top: 0;
                    left: 0;
                    z-index: 1;
                }
                #ewmbg p
                {
                    font-size: 20px;
                    color: #fff;
                    position: relative;
                    z-index: 999;
                    letter-spacing: 1px;
                    text-shadow: 0 0 6px #000;
                    top: 55%;
                }
            </style>
            <script>
                $('#ewmbg').on('click', function () {
                    //$('#modal7').fadeOut(300);
                    window.location = window.location;
                });
            </script>
            
            <button style="background: transparent; width: 68px; height: 28px; border: 1px solid #337AB7;
                color: #337AB7; border-radius: 4px; font-size: 10px; float: right; margin-right: 16px;
                margin-top: 10px;" id="ruheyanzheng">
                如何验证</button>
            <div id="quanquan">
            </div>
            <div style="font-size: 12px; color: #A8A8A8; float: left; margin-left: 10PX; margin-top: 10PX;
                margin-bottom: 10px;">
                最近 10 次 夺宝记录</div>
        </div>
    </div>
    <div style="width: 100%; top: 150px; position: absolute; z-index: 888;">
        <div style="background: #303031; border-radius: 2px; margin: 0 auto; padding: 11px 22px 11px 22px;
            color: white; display: none;" id="modal2">
            操作成功
        </div>
    </div>
    <style>
        .dbbg
        {
            position: fixed;
            background: rgba(0,0,0,0.15);
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: none;
            z-index: 99;
        }
        .divdb
        {
            position: fixed;
            width: 80%;
            left: 10%;
            top: 10%;
            background: #fff;
            border-radius: 6px; /*box-shadow: 0 0 8px #333;*/ /*border-top: 3px solid #f25f55;*/
            z-index: 100;
        }
        .divdb2
        {
            margin: 8px;
            padding-bottom: 5px; /*border-bottom: 1px solid #ccc;*/
        }
        .divdb2 h4
        {
            font-weight: 500;
            font-size: 13px;
            margin: 0;
            color: #000;
            margin: 0 8px;
        }
        .divdb2 h4 span
        {
            color: red;
        }
        .divtbl
        {
            margin: 10px;
        }
        .divtbl table td
        {
            text-align: left;
        }
        .divtbl table td:nth-child(1)
        {
            width: 60%;
            padding: 4px 30px;
            color: #9d9d9d;
        }
        .divtbl table td:nth-child(2)
        {
            padding: 4px 0px;
            font-weight: 600;
            color: #9d9d9d;
        }
        .qdbtn
        {
            text-align: center;
            margin: 20px 0;
        }
        .qdbtn button
        {
            display: block;
            width: 90%;
            background: #3cb034;
            color: #fff;
            margin: 0 auto;
            text-decoration: none;
            line-height: 36px;
            border-radius: 3px;
            border: 1px solid #3cb034;
            font-size: 14px;
            font-family: "微软雅黑";
        }
        .divtx
        {
            margin-top: 20px;
        }
        .divtx p
        {
            border-radius: 100px;
            display: inline-block;
            background: #3cb034;
            width: 60px;
            height: 60px;
        }
        .divtx p img
        {
            margin-top: 16px;
        }
    </style>
    <!--下单猜大弹窗提现提示-->
    <div class="dbbg">
    </div>
    <div id="modalxiadan_caida" style="display: none;">
        <div class="divdb">
            <div class="divtx">
                <p>
                    <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/img/qianbao.png" width="35px"></p>
            </div>
            <div class="divdb2">
                <h4>
                    根据微信<span>提现1元</span>生成唯一订单尾数作为依据，尾数0~4为小，5~9为大。</h4>
            </div>
            <div class="divtbl">
                <table width="100%">
                    <tr>
                        <td>
                            数量：
                        </td>
                        <td>
                            <span id="caida_txnum">1</span>手
                        </td>
                    </tr>
                    <tr>
                        <td>
                            猜大小：
                        </td>
                        <td>
                            <span id="caida_txtrend">大</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            手续费：
                        </td>
                        <td>
                            <span id="caida_txsxf">1.00</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            预期收益：
                        </td>
                        <td>
                            <span id="caida_txshouyi">10.00</span>
                        </td>
                    </tr>
                </table>
                <div class="qdbtn">
                    <button id="caida_queding">
                        确 定</button>
                </div>
            </div>
        </div>
    </div>
    <!--下单猜大弹窗提现提示-->
    <!--下单猜小弹窗提现提示-->
    <div class="dbbg">
    </div>
    <div id="modalxiadan_caixiao" style="display: none;">
        <div class="divdb">
            <div class="divtx">
                <p>
                    <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/img/qianbao.png" width="35px"></p>
            </div>
            <div class="divdb2">
                <h4>
                    根据微信<span>提现1元</span>生成唯一订单尾数作为依据，尾数0~4为小，5~9为大。</h4>
            </div>
            <div class="divtbl">
                <table width="100%">
                    <tr>
                        <td>
                            数量：
                        </td>
                        <td>
                            <span id="caixiao_txnum">1</span>手
                        </td>
                    </tr>
                    <tr>
                        <td>
                            猜大小：
                        </td>
                        <td>
                            <span id="caixiao_txtrend">小</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            手续费：
                        </td>
                        <td>
                            <span id="caixiao_txsxf">1.00</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            预期收益：
                        </td>
                        <td>
                            <span id="caixiao_txshouyi">10.00</span>
                        </td>
                    </tr>
                </table>
                <div class="qdbtn">
                    <button id="caixiao_queding">
                        确 定</button>
                </div>
            </div>
        </div>
    </div>
    <!--下单猜小弹窗提现提示-->
    <!--猜单开始-->
    <div class="dbbg">
    </div>
    <div id="modalxiadan_caidan" style="display: none;">
        <div class="divdb">
            <div class="divtx">
                <p>
                    <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/img/qianbao.png" width="35px"></p>
            </div>
            <div class="divdb2">
                <h4>
                    根据微信<span>提现1元</span>生成唯一订单尾数作为依据，尾数1、3、5、7、9为单。</h4>
            </div>
            <div class="divtbl">
                <table width="100%">
                    <tr>
                        <td>
                            数量：
                        </td>
                        <td>
                            <span id="caidan_txnum">1</span>手
                        </td>
                    </tr>
                    <tr>
                        <td>
                            猜单双：
                        </td>
                        <td>
                            <span id="caidan_txtrend">单</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            手续费：
                        </td>
                        <td>
                            <span id="caidan_txsxf">1.00</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            预期收益：
                        </td>
                        <td>
                            <span id="caidan_txshouyi">10.00</span>
                        </td>
                    </tr>
                </table>
                <div class="qdbtn">
                    <button id="caidan_queding">
                        确 定</button>
                </div>
            </div>
        </div>
    </div>
    <!--猜单结束-->
    <!--猜双开始-->
    <div class="dbbg">
    </div>
    <div id="modalxiadan_caishuang" style="display: none;">
        <div class="divdb">
            <div class="divtx">
                <p>
                    <img src="/qqonline_ex/themes/simplebootx_pig_fake/Public/img/qianbao.png" width="35px"></p>
            </div>
            <div class="divdb2">
                <h4>
                    根据微信<span>提现1元</span>生成唯一订单尾数作为依据，尾数0、2、4、6、8为双。</h4>
            </div>
            <div class="divtbl">
                <table width="100%">
                    <tr>
                        <td>
                            数量：
                        </td>
                        <td>
                            <span id="caishuang_txnum">1</span>手
                        </td>
                    </tr>
                    <tr>
                        <td>
                            猜单双：
                        </td>
                        <td>
                            <span id="caishuang_txtrend">双</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            手续费：
                        </td>
                        <td>
                            <span id="caishuang_txsxf">1.00</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            预期收益：
                        </td>
                        <td>
                            <span id="caishuang_txshouyi">10.00</span>
                        </td>
                    </tr>
                </table>
                <div class="qdbtn">
                    <button id="caishuang_queding">
                        确 定</button>
                </div>
            </div>
        </div>
    </div>
    <!--猜双结束-->
    <script>
        $('.dbbg').click(function () {
            $('.dbbg').fadeOut(300);
            $('#modalxiadan_caixiao').fadeOut(300);
            $('#modalxiadan_caida').fadeOut(300);
            $('#modalxiadan_caidan').fadeOut(300);
            $('#modalxiadan_caishuang').fadeOut(300);
        });
    </script>
    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript" src="/qqonline_ex/themes/simplebootx_pig_fake/Public/jsdb/qrcode.js"></script>
    <script type="text/javascript">
    var caiji_delay = <?php echo ($caiji_delay); ?>;
    var base_price = <?php echo ($lottery_single_price); ?>;
    var price_mul = [<?php echo ($lottery_price_mul); ?>];
    var price_ratio = '<?php echo ($lottery_price_ratio); ?>';
    var cur_ratio = {
    	big_ratio:<?php echo ($ratio["big_ratio"]); ?>,
    	mid_ratio:<?php echo ($ratio["mid_ratio"]); ?>,
    	small_ratio:<?php echo ($ratio["small_ratio"]); ?>,
    	odd_ratio:<?php echo ($ratio["odd_ratio"]); ?>,
    	event_ratio:<?php echo ($ratio["event_ratio"]); ?>
    }; 
    
    function get_wallet()
    {
        $.ajax({
            type: 'post',
            dataType: 'json',
            async: false,
            url: 'index.php?g=Qqonline&m=index&a=ajax_get_wallet',
            success: function (data) {
                console.log(JSON.stringify(data));
                if (data.ret == 1) {
                    //判断code是否为空
                   $('#money').html(data.info.money);
                } else {
                   // location.href = 'http://nmxns.guangjt.cnquan?id=' + $.cookie('user_qudao');
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                //if (XMLHttpRequest.status == 401) {
                //  alert('系统错误，请关闭重新登录');
                //}
            }
        });
    }
    
    get_wallet();
    </script>
    <script>
    $("#order_jia").tap(function () {
        add_count();
    });
    $("#order_jian").tap(function () {
        sub_count();
    });
    $("#order_max").tap(function () {
        max();
    })
    $("#order_min").tap(function () {
        min();
    })
    $("#order_cheng").tap(function () {
        mul();
    })
    $("#order_chu").tap(function () {
        div();
    })
    </script>
    <!--footer-->
    <div style="border-top: #F0F0F0 1px solid; height: 45px; width: 100%; line-height: 44px;
        background: white; position: fixed; bottom: 0px; text-align: center; font-size: 16px;"
        onclick="location.href='/'">
        返回首页
    </div>
    <script src="/qqonline_ex/themes/simplebootx_pig_fake/Public/js/newduobao.app.js" type="text/javascript"></script>
</body>
</html>