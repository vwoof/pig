<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

	<link href="/qqonline_ex/public/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/qqonline_ex/public/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/qqonline_ex/public/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/qqonline_ex/public/simpleboot/font-awesome/4.4.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <style>
		form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
		.table-actions{margin-top: 5px; margin-bottom: 5px;padding:0px;}
		.table-list{margin-bottom: 0px;}
	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/qqonline_ex/public/simpleboot/font-awesome/4.4.0/css/font-awesome-ie7.min.css">
	<![endif]-->
	<script type="text/javascript">
	//全局变量
	var GV = {
	    ROOT: "/qqonline_ex/",
	    WEB_ROOT: "/qqonline_ex/",
	    JS_ROOT: "public/js/",
	    APP:'<?php echo (MODULE_NAME); ?>'/*当前应用名*/
	};
	</script>
    <script src="/qqonline_ex/public/js/jquery.js"></script>
    <script src="/qqonline_ex/public/js/wind.js"></script>
    <script src="/qqonline_ex/public/simpleboot/bootstrap/js/bootstrap.min.js"></script>
    <script>
    	$(function(){
    		$("[data-toggle='tooltip']").tooltip();
    	});
    </script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?>
</head>
<body>
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#A" data-toggle="tab"><?php echo L('WEB_SITE_INFOS');?></a></li>
			<li><a href="#B" data-toggle="tab"><?php echo L('SEO_SETTING');?></a></li>
			<li><a href="#C" data-toggle="tab"><?php echo L('URL_SETTING');?></a></li>
			<li><a href="<?php echo U('route/index');?>"><?php echo L('URL_OPTIMIZATION');?></a></li>
			<!-- <li><a href="#D" data-toggle="tab"><?php echo L('UCENTER_SETTING');?></a></li> -->
			<li><a href="#E" data-toggle="tab"><?php echo L('COMMENT_SETTING');?></a></li>
			<li><a href="#F" data-toggle="tab"><?php echo L("USERNAME_FILTER");?></a></li>
			<li><a href="#G" data-toggle="tab">全局设置</a></li>
			<li><a href="#K" data-toggle="tab">登录设置</a></li>
			<li><a href="#H" data-toggle="tab">提现（支付）设置</a></li>
			<li><a href="#H2" data-toggle="tab">(威富通)支付设置</a></li>
			<li><a href="#H2_1" data-toggle="tab">(威富通)QQ钱包支付设置</a></li>
			<li><a href="#H3" data-toggle="tab">(优畅)微信支付设置</a></li>
			<li><a href="#H4" data-toggle="tab">(优畅)阿里支付设置</a></li>
			<li><a href="#H5" data-toggle="tab">(百富通)支付设置</a></li>
			<li><a href="#I" data-toggle="tab">投注设置</a></li>
			<li><a href="#J" data-toggle="tab">提现设置</a></li>
			<li><a href="#L" data-toggle="tab">控盘设置</a></li>
			<li><a href="#M" data-toggle="tab">开奖设置</a></li>
		</ul>
		<form class="form-horizontal js-ajax-forms" action="<?php echo U('setting/site_post');?>" method="post">
			<fieldset>
				<div class="tabbable">
					<div class="tab-content">
						<div class="tab-pane active" id="A">
							<fieldset>
								<div class="control-group">
									<label class="control-label"><?php echo L('WEBSITE_NAME');?></label>
									<div class="controls">
										<input type="text" name="options[site_name]" value="<?php echo ($site_name); ?>"><span class="form-required">*</span>
										<?php if($option_id): ?>
										<input type="hidden" name="option_id" value="<?php echo ($option_id); ?>">
										<?php endif; ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">后台地址加密码：</label>
									<div class="controls">
										<input type="text" name="options[site_admin_url_password]" value="<?php echo ($site_admin_url_password); ?>" id="js-site-admin-url-password"><span class="form-required">*</span>
										<span class="help-block" style="color: red;">设置加密码后必须通过以下地址访问后台,请劳记此地址，为了安全，您也可以定期更换此加密码!</span>
										<?php $site_admin_url_password =C("SP_SITE_ADMIN_URL_PASSWORD"); ?>
										<?php if(!empty($site_admin_url_password)): ?><span class="help-block">后台地址：<span id="js-site-admin-url"><?php echo sp_get_host();?>/qqonline_ex?g=admin&upw=<?php echo C('SP_SITE_ADMIN_URL_PASSWORD');?></span></span><?php endif; ?>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo L('WEBSITE_THEME');?></label>
									<div class="controls">
										<select name="options[site_tpl]">
											<?php if(is_array($templates)): foreach($templates as $key=>$vo): $tpl_selected=$site_tpl==$vo?"selected":""; ?>
											<option value="<?php echo ($vo); ?>" <?php echo ($tpl_selected); ?>><?php echo ($vo); ?></option><?php endforeach; endif; ?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo L('ENABLE_MOBILE_THEME');?>：</label>
									<div class="controls">
										<?php $mobile_tpl_enabled_checked=empty($mobile_tpl_enabled)?'':'checked'; ?>
										<label class="checkbox inline"><input type="checkbox" name="options[mobile_tpl_enabled]" value="1" <?php echo ($mobile_tpl_enabled_checked); ?>></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo L('WEBSITE_ADMIN_THEME');?></label>
									<div class="controls">
										<?php $site_adminstyle=empty($site_adminstyle)?'flat':$site_adminstyle; ?>
										<select name="options[site_adminstyle]">
											<?php if(is_array($adminstyles)): foreach($adminstyles as $key=>$vo): $adminstyle_selected=$site_adminstyle==$vo?"selected":""; ?>
											<option value="<?php echo ($vo); ?>" <?php echo ($adminstyle_selected); ?>><?php echo ($vo); ?></option><?php endforeach; endif; ?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo L('HTML_CACHE');?>：</label>
									<div class="controls">
										<?php $html_cache_on_checked=empty($html_cache_on)?'':'checked'; ?>
										<label class="checkbox inline"><input type="checkbox" name="options[html_cache_on]" value="1" <?php echo ($html_cache_on_checked); ?>></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo L('WEBSITE_ICP');?></label>
									<div class="controls">
										<input type="text" name="options[site_icp]" value="<?php echo ($site_icp); ?>">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo L('WEBMASTER_EMAIL');?></label>
									<div class="controls">
										<input type="text" name="options[site_admin_email]" value="<?php echo ($site_admin_email); ?>">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo L("WEBSITE_STATISTICAL_CODE");?></label>
									<div class="controls">
										<textarea name="options[site_tongji]" rows="5" cols="57"><?php echo ($site_tongji); ?></textarea>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo L('WEBSITE_COPYRIGHT_INFOMATION');?></label>
									<div class="controls">
										<textarea name="options[site_copyright]" rows="5" cols="57"><?php echo ($site_copyright); ?></textarea>
									</div>
								</div>
							</fieldset>
						</div>
						<div class="tab-pane" id="B">
							<fieldset>
								<div class="control-group">
									<label class="control-label"><?php echo L('WEBSITE_SEO_TITLE');?></label>
									<div class="controls">
										<input type="text" name="options[site_seo_title]" value="<?php echo ($site_seo_title); ?>">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo L('WEBSITE_SEO_KEYWORDS');?></label>
									<div class="controls">
										<input type="text" name="options[site_seo_keywords]" value="<?php echo ($site_seo_keywords); ?>">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo L('WEBSITE_SEO_DESCRIPTION');?></label>
									<div class="controls">
										<textarea name="options[site_seo_description]" rows="5" cols="57"><?php echo ($site_seo_description); ?></textarea>
									</div>
								</div>
							</fieldset>
						</div>
						<div class="tab-pane" id="C">
							<fieldset>
								<div class="control-group">
									<label class="control-label"><?php echo L('URL_MODE');?></label>
									<div class="controls">
										<?php $urlmodes=array( "0"=>L('URL_NORMAL_MODE'), "1"=>L('URL_PATHINFO_MODE'), "2"=>L('URL_REWRITE_MODE')); ?>
										<select name="options[urlmode]">
											<?php if(is_array($urlmodes)): foreach($urlmodes as $key=>$vo): $urlmode_selected=$key==$urlmode?"selected":""; ?>
											<option value="<?php echo ($key); ?>" <?php echo ($urlmode_selected); ?>><?php echo ($vo); ?></option><?php endforeach; endif; ?>
										</select>
										<span class="form-required">* <?php echo L('URL_MODE_HELP_TEXT');?></span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo L('URL_REWRITE_SUFFIX');?></label>
									<div class="controls">
										<input type="text" name="options[html_suffix]" value="<?php echo ($html_suffix); ?>">
										<span class="form-required"><?php echo L('URL_REWRITE_SUFFIX_HELP_TEXT');?></span>
									</div>
								</div>
							</fieldset>
						</div>
						<div class="tab-pane" id="E">
							<fieldset>
								<div class="control-group">
									<label class="control-label"><?php echo L('COMMENT_CHECK');?></label>
									<div class="controls">
										<?php $comment_need_checked=empty($comment_need_check)?"":"checked"; ?>
										<input type="checkbox" class="js-check" name="options[comment_need_check]" value="1" <?php echo ($comment_need_checked); ?>>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label"><?php echo L('COMMENT_TIME_INTERVAL');?></label>
									<div class="controls">
										<input type="number" name="options[comment_time_interval]" value="<?php echo ((isset($comment_time_interval) && ($comment_time_interval !== ""))?($comment_time_interval):60); ?>" style="width:40px;"><?php echo L('SECONDS');?>
									</div>
								</div>
							</fieldset>
						</div>
						<div class="tab-pane" id="F">
							<fieldset>
								<div class="control-group">
									<label class="control-label"><?php echo L('SPECAIL_USERNAME');?></label>
									<div class="controls">
										<textarea name="cmf_settings[banned_usernames]" rows="5" cols="57"><?php echo ($cmf_settings["banned_usernames"]); ?></textarea>
									</div>
								</div>
							</fieldset>
						</div>
						<div class="tab-pane" id="G">
							<fieldset>
								<div class="control-group">
									<label class="control-label">静态资源cdn地址</label>
									<div class="controls">
										<input type="text" name="cdn_settings[cdn_static_root]" value="<?php echo ($cdn_settings["cdn_static_root"]); ?>">
										<span class="help-block">
											不能以/结尾；设置这个地址后，请将ThinkCMF下的静态资源文件放在其下面；<br>
											ThinkCMF下的静态资源文件大致包含以下(如果你自定义后，请自行增加)：<br>
											admin/themes/simplebootx/Public/assets<br>
											public<br>
											themes/simplebootx/Public/assets<br>
											例如未设置cdn前：jquery的访问地址是/public/js/jquery.js, 设置cdn是后它的访问地址就是：静态资源cdn地址+/public/js/jquery.js
											
										</span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">充值金额列表(用英文逗号隔开)</label>
									<div class="controls">
										<input type="text" name="options[recharge_prices]" value="<?php echo ($recharge_prices); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">测试登录渠道编号</label>
									<div class="controls">
										<input type="text" name="options[test_channel]" value="<?php echo ($test_channel); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">服务器是否停止</label>
									<div class="controls">
										<?php $is_stopped_checked=empty($is_stopped)?'':'checked'; ?>
										<label class="checkbox inline"><input type="checkbox" name="options[is_stopped]" value="1" <?php echo ($is_stopped_checked); ?>></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">停止提现申请</label>
									<div class="controls">
										<?php $is_stopped_drawcash_checked=empty($is_stopped_drawcash)?'':'checked'; ?>
										<label class="checkbox inline"><input type="checkbox" name="options[is_stopped_drawcash]" value="1" <?php echo ($is_stopped_drawcash_checked); ?>></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">停止投注</label>
									<div class="controls">
										<?php $is_stopped_lottery_checked=empty($is_stopped_lottery)?'':'checked'; ?>
										<label class="checkbox inline"><input type="checkbox" name="options[is_stopped_lottery]" value="1" <?php echo ($is_stopped_lottery_checked); ?>></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">停止充值</label>
									<div class="controls">
										<?php $is_stopped_recharge_checked=empty($is_stopped_recharge)?'':'checked'; ?>
										<label class="checkbox inline"><input type="checkbox" name="options[is_stopped_recharge]" value="1" <?php echo ($is_stopped_recharge_checked); ?>></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">停止后跳转地址</label>
									<div class="controls">
										<input type="text" name="options[stop_gourl]" value="<?php echo ($stop_gourl); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">禁止登录后跳转地址</label>
									<div class="controls">
										<input type="text" name="options[ban_gourl]" value="<?php echo ($ban_gourl); ?>" style="width:300px;"/>
									</div>
								</div>
							</fieldset>
						</div>
						<div class="tab-pane" id="H">
							<fieldset>
								<div class="control-group">
									<label class="control-label">是否启用</label>
									<div class="controls">
										<?php $wxpay_enabled_checked=empty($wxpay_enabled)?'':'checked'; ?>
										<label class="checkbox inline"><input type="checkbox" name="options[wxpay_enabled]" value="1" <?php echo ($wxpay_enabled_checked); ?>></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">是否测试</label>
									<div class="controls">
										<?php $wxpay_test_enabled_checked=empty($wxpay_test_enabled)?'':'checked'; ?>
										<label class="checkbox inline"><input type="checkbox" name="options[wxpay_test_enabled]" value="1" <?php echo ($wxpay_test_enabled_checked); ?>></label>
									</div>
								</div>								
								<div class="control-group">
									<label class="control-label">商家Appid(支付平台需要填写)</label>
									<div class="controls">
										<input type="text" name="options[appid]" value="<?php echo ($appid); ?>" style="width:300px;"/>
									</div>
								</div>			
								<div class="control-group">
									<label class="control-label">商家AppSecret(支付平台需要填写)</label>
									<div class="controls">
										<input type="text" name="options[appsecret]" value="<?php echo ($appsecret); ?>" style="width:300px;"/>
									</div>
								</div>					
								<div class="control-group">
									<label class="control-label">商家帐号(支付平台需要填写)</label>
									<div class="controls">
										<input type="text" name="options[mchid]" value="<?php echo ($mchid); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">商家终端号</label>
									<div class="controls">
										<input type="text" name="options[term_id]" value="<?php echo ($term_id); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">商家key(支付平台需要填写)</label>
									<div class="controls">
										<input type="text" name="options[mch_key]" value="<?php echo ($mch_key); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">支付请求URL</label>
									<div class="controls">
										<input type="text" name="options[pay_url]" value="<?php echo ($pay_url); ?>" style="width:300px;"/>
									</div>
								</div>								
								<div class="control-group">
									<label class="control-label">前端跳转地址</label>
									<div class="controls">
										<input type="text" name="options[page_url]" value="<?php echo ($page_url); ?>" style="width:300px;"/>
									</div>
								</div>	
								<div class="control-group">
									<label class="control-label">提现二次授权地址</label>
									<div class="controls">
										<input type="text" name="options[tixian_openid_url]" value="<?php echo ($tixian_openid_url); ?>" style="width:300px;"/>
									</div>
								</div>						
							</fieldset>
						</div>
						<div class="tab-pane" id="H2">
							<fieldset>
								<div class="control-group">
									<label class="control-label">是否启用</label>
									<div class="controls">
										<?php $wft_enabled_checked=empty($wft_enabled)?'':'checked'; ?>
										<label class="checkbox inline"><input type="checkbox" name="options[wft_enabled]" value="1" <?php echo ($wft_enabled_checked); ?>></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">是否测试</label>
									<div class="controls">
										<?php $wft_test_enabled_checked=empty($wft_test_enabled)?'':'checked'; ?>
										<label class="checkbox inline"><input type="checkbox" name="options[wft_test_enabled]" value="1" <?php echo ($wft_test_enabled_checked); ?>></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">第三方商家Appid(支付平台需要填写)</label>
									<div class="controls">
										<input type="text" name="options[wft_appid]" value="<?php echo ($wft_appid); ?>" style="width:300px;"/>
									</div>
								</div>			
								<div class="control-group">
									<label class="control-label">第三方商家AppSecret(支付平台需要填写)</label>
									<div class="controls">
										<input type="text" name="options[wft_appsecret]" value="<?php echo ($wft_appsecret); ?>" style="width:300px;"/>
									</div>
								</div>					
								<div class="control-group">
									<label class="control-label">商家帐号(支付平台需要填写)</label>
									<div class="controls">
										<input type="text" name="options[wft_mchid]" value="<?php echo ($wft_mchid); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">商家key(支付平台需要填写)</label>
									<div class="controls">
										<input type="text" name="options[wft_mch_key]" value="<?php echo ($wft_mch_key); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">商家终端号</label>
									<div class="controls">
										<input type="text" name="options[wft_term_id]" value="<?php echo ($wft_term_id); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">支付请求URL</label>
									<div class="controls">
										<input type="text" name="options[wft_pay_url]" value="<?php echo ($wft_pay_url); ?>" style="width:300px;"/>
									</div>
								</div>								
								<div class="control-group">
									<label class="control-label">前端跳转地址</label>
									<div class="controls">
										<input type="text" name="options[wft_page_url]" value="<?php echo ($wft_page_url); ?>" style="width:300px;"/>
									</div>
								</div>							
							</fieldset>
						</div>
						<div class="tab-pane" id="H2_1">
							<fieldset>
								<div class="control-group">
									<label class="control-label">是否启用</label>
									<div class="controls">
										<?php $wft_qq_enabled_checked=empty($wft_qq_enabled)?'':'checked'; ?>
										<label class="checkbox inline"><input type="checkbox" name="options[wft_qq_enabled]" value="1" <?php echo ($wft_qq_enabled_checked); ?>></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">是否测试</label>
									<div class="controls">
										<?php $wft_qq_test_enabled_checked=empty($wft_qq_test_enabled)?'':'checked'; ?>
										<label class="checkbox inline"><input type="checkbox" name="options[wft_qq_test_enabled]" value="1" <?php echo ($wft_qq_test_enabled_checked); ?>></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">第三方商家Appid(支付平台需要填写)</label>
									<div class="controls">
										<input type="text" name="options[wft_qq_appid]" value="<?php echo ($wft_qq_appid); ?>" style="width:300px;"/>
									</div>
								</div>			
								<div class="control-group">
									<label class="control-label">第三方商家AppSecret(支付平台需要填写)</label>
									<div class="controls">
										<input type="text" name="options[wft_qq_appsecret]" value="<?php echo ($wft_qq_appsecret); ?>" style="width:300px;"/>
									</div>
								</div>					
								<div class="control-group">
									<label class="control-label">商家帐号(支付平台需要填写)</label>
									<div class="controls">
										<input type="text" name="options[wft_qq_mchid]" value="<?php echo ($wft_qq_mchid); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">商家key(支付平台需要填写)</label>
									<div class="controls">
										<input type="text" name="options[wft_qq_mch_key]" value="<?php echo ($wft_qq_mch_key); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">商家终端号</label>
									<div class="controls">
										<input type="text" name="options[wft_qq_term_id]" value="<?php echo ($wft_qq_term_id); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">支付请求URL</label>
									<div class="controls">
										<input type="text" name="options[wft_qq_pay_url]" value="<?php echo ($wft_qq_pay_url); ?>" style="width:300px;"/>
									</div>
								</div>								
								<div class="control-group">
									<label class="control-label">前端跳转地址</label>
									<div class="controls">
										<input type="text" name="options[wft_qq_page_url]" value="<?php echo ($wft_qq_page_url); ?>" style="width:300px;"/>
									</div>
								</div>							
							</fieldset>
						</div>
						<div class="tab-pane" id="H3">
							<fieldset>
								<div class="control-group">
									<label class="control-label">是否启用</label>
									<div class="controls">
										<?php $youchang_enabled_checked=empty($youchang_enabled)?'':'checked'; ?>
										<label class="checkbox inline"><input type="checkbox" name="options[youchang_enabled]" value="1" <?php echo ($youchang_enabled_checked); ?>></label>
									</div>
								</div>	
								<div class="control-group">
									<label class="control-label">是否测试</label>
									<div class="controls">
										<?php $youchang_test_enabled_checked=empty($youchang_test_enabled)?'':'checked'; ?>
										<label class="checkbox inline"><input type="checkbox" name="options[youchang_test_enabled]" value="1" <?php echo ($youchang_test_enabled_checked); ?>></label>
									</div>
								</div>																
								<div class="control-group">
									<label class="control-label">第三方商家Appid(支付平台需要填写)</label>
									<div class="controls">
										<input type="text" name="options[youchang_appid]" value="<?php echo ($youchang_appid); ?>" style="width:300px;"/>
									</div>
								</div>			
								<div class="control-group">
									<label class="control-label">第三方商家AppSecret(支付平台需要填写)</label>
									<div class="controls">
										<input type="text" name="options[youchang_appsecret]" value="<?php echo ($youchang_appsecret); ?>" style="width:300px;"/>
									</div>
								</div>					
								<div class="control-group">
									<label class="control-label">商家帐号(支付平台需要填写)</label>
									<div class="controls">
										<input type="text" name="options[youchang_mchid]" value="<?php echo ($youchang_mchid); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">商家key(支付平台需要填写)</label>
									<div class="controls">
										<input type="text" name="options[youchang_mch_key]" value="<?php echo ($youchang_mch_key); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">商家终端号</label>
									<div class="controls">
										<input type="text" name="options[youchang_term_id]" value="<?php echo ($youchang_term_id); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">支付请求URL</label>
									<div class="controls">
										<input type="text" name="options[youchang_pay_url]" value="<?php echo ($youchang_pay_url); ?>" style="width:300px;"/>
									</div>
								</div>								
								<div class="control-group">
									<label class="control-label">前端跳转地址</label>
									<div class="controls">
										<input type="text" name="options[youchang_page_url]" value="<?php echo ($youchang_page_url); ?>" style="width:300px;"/>
									</div>
								</div>
							</fieldset>
						</div>
						<div class="tab-pane" id="H4">
							<fieldset>
								<div class="control-group">
									<label class="control-label">是否启用</label>
									<div class="controls">
										<?php $youchang_ali_enabled_checked=empty($youchang_ali_enabled)?'':'checked'; ?>
										<label class="checkbox inline"><input type="checkbox" name="options[youchang_ali_enabled]" value="1" <?php echo ($youchang_ali_enabled_checked); ?>></label>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">是否测试</label>
									<div class="controls">
										<?php $youchang_ali_test_enabled_checked=empty($youchang_ali_test_enabled)?'':'checked'; ?>
										<label class="checkbox inline"><input type="checkbox" name="options[youchang_ali_test_enabled]" value="1" <?php echo ($youchang_ali_test_enabled_checked); ?>></label>
									</div>
								</div>											
								<div class="control-group">
									<label class="control-label">商家帐号(支付平台需要填写)</label>
									<div class="controls">
										<input type="text" name="options[youchang_ali_mchid]" value="<?php echo ($youchang_ali_mchid); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">商家key(支付平台需要填写)</label>
									<div class="controls">
										<input type="text" name="options[youchang_ali_mch_key]" value="<?php echo ($youchang_ali_mch_key); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">商家终端号</label>
									<div class="controls">
										<input type="text" name="options[youchang_ali_term_id]" value="<?php echo ($youchang_ali_term_id); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">支付请求URL</label>
									<div class="controls">
										<input type="text" name="options[youchang_ali_pay_url]" value="<?php echo ($youchang_ali_pay_url); ?>" style="width:300px;"/>
									</div>
								</div>								
								<div class="control-group">
									<label class="control-label">前端跳转地址</label>
									<div class="controls">
										<input type="text" name="options[youchang_ali_page_url]" value="<?php echo ($youchang_ali_page_url); ?>" style="width:300px;"/>
									</div>
								</div>
							</fieldset>
						</div>
						<div class="tab-pane" id="H5">
							<fieldset>
								<div class="control-group">
									<label class="control-label">是否启用</label>
									<div class="controls">
										<?php $bft_enabled_checked=empty($bft_enabled)?'':'checked'; ?>
										<label class="checkbox inline"><input type="checkbox" name="options[bft_enabled]" value="1" <?php echo ($bft_enabled_checked); ?>></label>
									</div>
								</div>	
								<div class="control-group">
									<label class="control-label">是否测试</label>
									<div class="controls">
										<?php $bft_test_enabled_checked=empty($bft_test_enabled)?'':'checked'; ?>
										<label class="checkbox inline"><input type="checkbox" name="options[bft_test_enabled]" value="1" <?php echo ($bft_test_enabled_checked); ?>></label>
									</div>
								</div>																
								<div class="control-group">
									<label class="control-label">第三方商家Appid(支付平台需要填写)</label>
									<div class="controls">
										<input type="text" name="options[bft_appid]" value="<?php echo ($bft_appid); ?>" style="width:300px;"/>
									</div>
								</div>			
								<div class="control-group">
									<label class="control-label">第三方商家signKey(支付平台需要填写)</label>
									<div class="controls">
										<input type="text" name="options[bft_signkey]" value="<?php echo ($bft_signkey); ?>" style="width:300px;"/>
									</div>
								</div>					
								<div class="control-group">
									<label class="control-label">第三方商家destKey(支付平台需要填写)</label>
									<div class="controls">
										<input type="text" name="options[bft_destkey]" value="<?php echo ($bft_destkey); ?>" style="width:300px;"/>
									</div>
								</div>	
								<div class="control-group">
									<label class="control-label">商家终端号</label>
									<div class="controls">
										<input type="text" name="options[bft_term_id]" value="<?php echo ($bft_term_id); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">支付请求URL</label>
									<div class="controls">
										<input type="text" name="options[bft_pay_url]" value="<?php echo ($bft_pay_url); ?>" style="width:300px;"/>
									</div>
								</div>	
								<div class="control-group">
									<label class="control-label">支付请求URL(支付宝)</label>
									<div class="controls">
										<input type="text" name="options[bft_pay_url_ali]" value="<?php echo ($bft_pay_url_ali); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">支付回调服务器白名单(用;隔开)</label>
									<div class="controls">
										<input type="text" name="options[bft_server_ip]" value="<?php echo ($bft_server_ip); ?>" style="width:300px;"/>
									</div>
								</div>	
							</fieldset>
						</div>
						<div class="tab-pane" id="K">
							<fieldset>
								<div class="control-group">
									<label class="control-label">登录Appid(登录平台需要填写)</label>
									<div class="controls">
										<input type="text" name="options[login_appid]" value="<?php echo ($login_appid); ?>" style="width:300px;"/>
									</div>
								</div>			
								<div class="control-group">
									<label class="control-label">登录AppSecret(登录平台需要填写)</label>
									<div class="controls">
										<input type="text" name="options[login_appsecret]" value="<?php echo ($login_appsecret); ?>" style="width:300px;"/>
									</div>
								</div>						
								<div class="control-group">
									<label class="control-label">登录请求url</label>
									<div class="controls">
										<input type="text" name="options[login_url]" value="<?php echo ($login_url); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">登录KEY密钥</label>
									<div class="controls">
										<input type="text" name="options[login_key]" value="<?php echo ($login_key); ?>" style="width:300px;"/>
									</div>
								</div>						
							</fieldset>
						</div>
						<div class="tab-pane" id="I">
							<fieldset>
								<div class="control-group">
									<label class="control-label">投注手续费(1表示1元,5%表示5%的手续费)</label>
									<div class="controls">
										<input type="text" name="options[lottery_price_ratio]" value="<?php echo ($lottery_price_ratio); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">单注投注金额</label>
									<div class="controls">
										<input type="number" name="options[lottery_single_price]" value="<?php echo ($lottery_single_price); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">投注手数列表</label>
									<div class="controls">
										<input type="text" name="options[lottery_price_mul]" value="<?php echo ($lottery_price_mul); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">单注投注最大金额</label>
									<div class="controls">
										<input type="number" name="options[lottery_single_price_max]" value="<?php echo ($lottery_single_price_max); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">新注册用户赠送金币</label>
									<div class="controls">
										<input type="number" name="options[beginner_money_gift]" value="<?php echo ($beginner_money_gift); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">计算佣金有效时间(小时)</label>
									<div class="controls">
										<input type="number" name="options[commision_valid_time]" value="<?php echo ($commision_valid_time); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">佣金提成比例(一级用户)</label>
									<div class="controls">
										<input type="number" name="options[commision_divide_ratio]" value="<?php echo ($commision_divide_ratio); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">佣金提成比例(二级用户)</label>
									<div class="controls">
										<input type="number" name="options[commision_divide_ratio2]" value="<?php echo ($commision_divide_ratio2); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">佣金提成比例(三级用户)</label>
									<div class="controls">
										<input type="number" name="options[commision_divide_ratio3]" value="<?php echo ($commision_divide_ratio3); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">佣金提成比例(四级用户)</label>
									<div class="controls">
										<input type="number" name="options[commision_divide_ratio4]" value="<?php echo ($commision_divide_ratio4); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">佣金提成比例(五级及以下用户)</label>
									<div class="controls">
										<input type="number" name="options[commision_divide_ratio5]" value="<?php echo ($commision_divide_ratio5); ?>" style="width:300px;"/>
									</div>
								</div>		
							</fieldset>
						</div>
						<div class="tab-pane" id="J">
							<fieldset>
								<div class="control-group">
									<label class="control-label">最低提现额度</label>
									<div class="controls">
										<input type="number" name="options[drawcash_base_price]" value="<?php echo ($drawcash_base_price); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">提现达到充值金额多少才允许提现(0~100)%</label>
									<div class="controls">
										<input type="number" name="options[drawcash_lottery_price_ratio]" value="<?php echo ($drawcash_lottery_price_ratio); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">提现超过充值额度时候转成需要审核</label>
									<div class="controls">
										<input type="number" name="options[drawcash_over_recharges_need_check]" value="<?php echo ($drawcash_over_recharges_need_check); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">每日提现次数</label>
									<div class="controls">
										<input type="number" name="options[drawcash_times_per_day]" value="<?php echo ($drawcash_times_per_day); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">单笔超过提现额度,需要审核</label>
									<div class="controls">
										<input type="number" name="options[drawcash_max_price_per_day]" value="<?php echo ($drawcash_max_price_per_day); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">提现手续费(0.0~100.0)</label>
									<div class="controls">
										<input type="number" name="options[drawcash_ratio]" value="<?php echo ($drawcash_ratio); ?>" style="width:300px;"/>%
									</div>
								</div>						
							</fieldset>
						</div>
						<div class="tab-pane" id="L">
							<fieldset>
								<div class="control-group">
									<label class="control-label">控盘设置</label>
									<div class="controls">
										<select id="control_method" name="options[control_method]">
											<option value="0" selected>不控盘</option>
											<option value="1">按次数放水</option>
											<option value="2">按盈率放水</option>
											<option value="3">按次数抽水</option>
											<option value="4">按盈率抽水</option>
										</select>
									</div>
								</div>
								<script>
								document.getElementById('control_method').value = "<?php echo ((isset($control_method) && ($control_method !== ""))?($control_method):0); ?>";
								</script>
								<div class="control-group">
									<label class="control-label">放水低于盈率自动抽水</label>
									<div class="controls">
										<?php $control_change_enabled_checked=empty($control_change_enabled)?'':'checked'; ?>
										<label class="checkbox inline"><input type="checkbox" name="options[control_change_enabled]" value="1" <?php echo ($control_change_enabled_checked); ?>></label>
									</div>
								</div>									
								<div class="control-group">
									<label class="control-label">控盘力度(0-最低,4-最高)</label>
									<div class="controls">
										<input type="number" name="options[control_level]" value="<?php echo ($control_level); ?>" style="width:300px;"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">盈率基准控盘(【放水】高于盈率控盘,【抽水】低于盈率控盘)</label>
									<div class="controls">
										<input type="number" name="options[method2_control_wins]" value="<?php echo ($method2_control_wins); ?>" style="width:300px;"/>%
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">按次数来控盘</label>
									<div class="controls">
										<input type="number" name="options[method1_control_ratio_times]" value="<?php echo ($method1_control_ratio_times); ?>" style="width:300px;"/>
									</div>
								</div>				
							</fieldset>
						</div>
						<div class="tab-pane" id="M">
							<fieldset>
								<div class="control-group">
									<label class="control-label">数据整理时长（最低5秒）</label>
									<div class="controls">
										<input type="number" name="options[caiji_delay]" value="<?php echo ($caiji_delay); ?>" style="width:300px;"/>
									</div>
								</div>												
							</fieldset>
						</div>
					</div>
				</div>

				<div class="form-actions">
					<button type="submit" class="btn btn-primary  js-ajax-submit"><?php echo L("SAVE");?></button>
				</div>
			</fieldset>
		</form>

	</div>
	<script type="text/javascript" src="/qqonline_ex/public/js/common.js"></script>
	<script>
		/////---------------------
		$(function(){
			$("#urlmode-select").change(function(){
				if($(this).val()==1){
					alert("更改后，若发现前台链接不能正常访问，可能是您的服务器不支持PATHINFO，请先修改data/conf/config.php文件的URL_MODEL为0保证网站正常运行,在配置服务器PATHINFO功能后再更新为PATHINFO模式！");
				}
				
				if($(this).val()==2){
					alert("更改后，若发现前台链接不能正常访问，可能是您的服务器不支持REWRITE，请先修改data/conf/config.php文件的URL_MODEL为0保证网站正常运行，在开启服务器REWRITE功能后再更新为REWRITE模式！");
				}
			});
			$("#js-site-admin-url-password").change(function(){
				$(this).data("changed",true);
			});
		});
		Wind.use('validate', 'ajaxForm', 'artDialog', function() {
			//javascript
			var form = $('form.js-ajax-forms');
			//ie处理placeholder提交问题
			if ($.browser && $.browser.msie) {
				form.find('[placeholder]').each(function() {
					var input = $(this);
					if (input.val() == input.attr('placeholder')) {
						input.val('');
					}
				});
			}
			//表单验证开始
			form.validate({
				//是否在获取焦点时验证
				onfocusout : false,
				//是否在敲击键盘时验证
				onkeyup : false,
				//当鼠标掉级时验证
				onclick : false,
				//验证错误
				showErrors : function(errorMap, errorArr) {
					//errorMap {'name':'错误信息'}
					//errorArr [{'message':'错误信息',element:({})}]
					try {
						$(errorArr[0].element).focus();
						art.dialog({
							id : 'error',
							icon : 'error',
							lock : true,
							fixed : true,
							background : "#CCCCCC",
							opacity : 0,
							content : errorArr[0].message,
							cancelVal : "<?php echo L('OK');?>",
							cancel : function() {
								$(errorArr[0].element).focus();
							}
						});
					} catch (err) {
					}
				},
				//验证规则
				rules : {
					'options[site_name]' : {
						required : 1
					},
					'options[site_host]' : {
						required : 1
					},
					'options[site_root]' : {
						required : 1
					}
				},
				//验证未通过提示消息
				messages : {
					'options[site_name]' : {
						required : "<?php echo L('WEBSITE_SITE_NAME_REQUIRED_MESSAGE');?>"
					},
					'options[site_host]' : {
						required : "<?php echo L('WEBSITE_SITE_HOST_REQUIRED_MESSAGE');?>"
					}
				},
				//给未通过验证的元素加效果,闪烁等
				highlight : false,
				//是否在获取焦点时验证
				onfocusout : false,
				//验证通过，提交表单
				submitHandler : function(forms) {
					$(forms).ajaxSubmit({
						url : form.attr('action'), //按钮上是否自定义提交地址(多按钮情况)
						dataType : 'json',
						beforeSubmit : function(arr, $form, options) {

						},
						success : function(data, statusText, xhr, $form) {
							if (data.status) {
								setCookie("refersh_time", 1);
								var admin_url_changed=$("#js-site-admin-url-password").data("changed");
								var message =admin_url_changed?data.info+'<br><span style="color:red;">后台地址已更新(请劳记！)</span>':data.info;
								
								//添加成功
								Wind.use("artDialog", function() {
									art.dialog({
										id : "succeed",
										icon : "succeed",
										fixed : true,
										lock : true,
										background : "#CCCCCC",
										opacity : 0,
										content : message,
										button : [ {
											name : "<?php echo L('OK');?>",
											callback : function() {
												reloadPage(window);
												return true;
											},
											focus : true
										}, {
											name : "<?php echo L('CLOSE');?>",
											callback : function() {
												reloadPage(window);
												return true;
											}
										} ]
									});
								});
							} else {
								alert(data.info);
							}
						}
					});
				}
			});
		});
		////-------------------------
	</script>
</body>
</html>