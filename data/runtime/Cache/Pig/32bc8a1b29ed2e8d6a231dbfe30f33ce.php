<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="user-scalable=no, width=320">
    <title>代理赚钱</title>
    <link rel="stylesheet" href="/qqonline_ex/themes/simplebootx_pig_fake/Public/cssdb/index.css">
    <script src="/qqonline_ex/themes/simplebootx_pig_fake/Public/jsdb/jquery.min.js" type="application/javascript"></script>
    <script src="/qqonline_ex/themes/simplebootx_pig_fake/Public/jsdb/jquery.cookie.js" type="application/javascript"></script>
</head>
<body align="center">
    <div class="all">
        <div class="content" style="width: 94%;">
            <div style="width: 100%; margin-top: 10px;">
                <a href="<?php echo U('index/daili1');?>">
                    <div style="background: white; color: #A8A8A8; width: 91px; height: 38px; float: left;
                        padding-top: 6px; border-radius: 4px; font-size: 16px; line-height: 34px; border: #EEEEEE 1px solid;">
                        代理</div>
                </a><a href="<?php echo U('index/daili2');?>">
                    <div style="background: white; color: #A8A8A8; width: 91px; height: 38px; float: left;
                        padding-top: 6px; margin-left: 11px; border-radius: 4px; border: #EEEEEE 1px solid;
                        font-size: 16px; line-height: 32px;">
                        佣金</div>
                </a><a href="<?php echo U('index/daili3');?>">
                    <div style="background: #1DBBA4; color: white; width: 93px; height: 40px; float: left;
                        padding-top: 6px; margin-left: 10px; border-radius: 4px; font-size: 16px; line-height: 32px;">
                        下线</div>
                </a>
            </div>
            <div class="clear">
            </div>
            <div id="daili">
                <!--
                <div style="width:100%; border:1px solid #F0F0F0; padding-bottom:12px;box-sizing: border-box;margin-top:10px;background:white;border-radius:4px; float:left;font-size:12px;">
                    <div style="margin-top:10px; margin-left:10px;">
                        <span style="float:left; font-size:16px;">138****8888</span>
                        <span style="float:right; margin-right:10px; color:#007AFF; margin-top:2px;font-size:12px;">2 手</span>
                    </div>
                    <div class="clear"></div>
                    <div style="margin-top:10px; margin-left:10px;">
                        <span style="float:left; font-size:12px;color:#A8A8A8">2017-01-03 03:22:22</span>
                    </div>
                    <div class="clear"></div>
                </div>
                <div style="width:100%; border:1px solid #F0F0F0; padding-bottom:12px;box-sizing: border-box;margin-top:10px;background:white;border-radius:4px; float:left;font-size:12px;">
                    <div style="margin-top:10px; margin-left:10px;">
                        <span style="float:left; font-size:16px;">138****8888</span>
                        <span style="float:right; margin-right:10px; color:#007AFF; margin-top:2px;font-size:12px;">2 手</span>
                    </div>
                    <div class="clear"></div>
                    <div style="margin-top:10px; margin-left:10px;">
                        <span style="float:left; font-size:12px;color:#A8A8A8">2017-01-03 03:22:22</span>
                    </div>
                    <div class="clear"></div>
                </div>
                -->
            </div>
            <div class="clear">
            </div>
            <div style="text-align: left; margin-left: 10px; margin-top: 10px; font-size: 12px;
                color: #A8A8A8">
                下线注册1级明细显示最新10条</div>
        </div>
    </div>
    <div style="width: 100%; top: 150px; position: absolute; z-index: 999;">
        <div style="background: #303031; border-radius: 20px; margin: 0 auto; padding: 11px 22px 11px 22px;
            color: white; display: none;" id="modal3">
            操作成功
        </div>
    </div>
    <!--footer-->
    <div style="border-top: #F0F0F0 1px solid; height: 45px; width: 100%; line-height: 44px;
        background: white; position: fixed; bottom: 0px; text-align: center; font-size: 16px;"
        onclick="location.href='index.php?g=Pig&m=index&a=index'">
        返回首页
    </div>
    <script>
        $("#d3").click(function () {
            location.href = "<?php echo U('index/newjiaoyimingxi');?>";
        });
        //获取地址栏传参
        function success(title) {
            $("#modal3").fadeIn('fast');
            if (title) {
                $("#modal3").text(title);
            }
            $("#modal3").css('display', 'inline-block');
            $("#modal3").fadeIn('fast');
            window.setTimeout(function () {
                $("#modal3").fadeOut(1000);
            }, 2000);
        }
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: 'index.php?g=Qqonline&m=index&a=ajax_get_daili1',
                data: { 'start': 0, 'limit': 10 },
                success: function (data) {
                	console.log(JSON.stringify(data));
                    if (data.ret == 1) {
                        var html = '';
                        for (var i in data.lists) {
                            html += '<div style="width:100%; border:1px solid #F0F0F0; padding-bottom:12px;box-sizing: border-box;margin-top:10px;background:white;border-radius:4px; float:left;font-size:12px;">' +
						'<div style="margin-top:10px; margin-left:10px;">' +
							'<span style="float:left; font-size:16px;">' + data.lists[i].id + '</span>' +
							//'<span style="float:right; margin-right:10px; color:#007AFF; margin-top:2px;font-size:12px;">' + data.data[i].lot + ' 手</span>' +
						'</div>' +
						'<div class="clear"></div>' +
						'<div style="margin-top:10px; margin-left:10px;">' +
							'<span style="float:left; font-size:12px;color:#A8A8A8">' + data.lists[i].create_time + '</span>' +
						'</div>' +
						'<div class="clear"></div>' +
						'</div>';
                        }
                        $("#daili").append(html);
                    }
                    else {
                        success(data.return_msg);
                    }
                }
            });
    </script>
</body>
</html>