<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class SettingController extends AdminbaseController{
	
	protected $options_model;
	
	public function _initialize() {
		parent::_initialize();
		$this->options_model = D("Common/Options");
	}
	
	// 网站信息
	public function site(){
	    C(S('sp_dynamic_config'));//加载动态配置
		$option=$this->options_model->where("option_name='site_options'")->find();
		$cmf_settings=$this->options_model->where("option_name='cmf_settings'")->getField("option_value");
		$tpls=sp_scan_dir(C("SP_TMPL_PATH")."*",GLOB_ONLYDIR);
		$noneed=array(".","..",".svn");
		$tpls=array_diff($tpls, $noneed);
		$this->assign("templates",$tpls);
		
		$adminstyles=sp_scan_dir("public/simpleboot/themes/*",GLOB_ONLYDIR);
		$adminstyles=array_diff($adminstyles, $noneed);
		$this->assign("adminstyles",$adminstyles);
		if($option){
			$this->assign(json_decode($option['option_value'],true));
			$this->assign("option_id",$option['option_id']);
		}
		
		$cdn_settings=sp_get_option('cdn_settings');
		
		$this->assign("cdn_settings",$cdn_settings);
		
		$this->assign("cmf_settings",json_decode($cmf_settings,true));
		
		$this->display();
	}
	
	// 网站信息设置提交
	public function site_post(){
		if (IS_POST) {
			if(isset($_POST['option_id'])){
				$data['option_id']=I('post.option_id',0,'intval');
			}
			$options=I('post.options/a');
			
			$configs["SP_SITE_ADMIN_URL_PASSWORD"]=empty($options['site_admin_url_password'])?"":md5(md5(C("AUTHCODE").$options['site_admin_url_password']));
			$configs["SP_DEFAULT_THEME"]=$options['site_tpl'];
			$configs["DEFAULT_THEME"]=$options['site_tpl'];
			$configs["SP_ADMIN_STYLE"]=$options['site_adminstyle'];
			$configs["URL_MODEL"]=$options['urlmode'];
			$configs["URL_HTML_SUFFIX"]=$options['html_suffix'];
			$configs["COMMENT_NEED_CHECK"]=empty($options['comment_need_check'])?0:1;
			$comment_time_interval=intval($options['comment_time_interval']);
			$configs["COMMENT_TIME_INTERVAL"]=$comment_time_interval;
			$_POST['options']['comment_time_interval']=$comment_time_interval;
			$configs["MOBILE_TPL_ENABLED"]=empty($options['mobile_tpl_enabled'])?0:1;
			$configs["HTML_CACHE_ON"]=empty($options['html_cache_on'])?false:true;
			$configs['IS_STOPPED'] = $options['is_stopped'] == '1' ? '1' : '0';
			$configs['IS_STOPPED_DRAWCASH'] = $options['is_stopped_drawcash'] == '1' ? '1' : '0';
			$configs['IS_STOPPED_LOTTERY'] = $options['is_stopped_lottery'] == '1' ? '1' : '0';
			$configs['IS_STOPPED_RECHARGE'] = $options['is_stopped_recharge'] == '1' ? '1' : '0';
			$configs['SIGN_BONUS'] = $options['sign_bonus'];
			$configs['SERVICER_NUMBER'] = $options['servicer_number'];
			$configs['TEST_CHANNEL'] = $options['test_channel'];
			$configs['CAIJI_DELAY'] = $options['caiji_delay'];
			$configs['LOTTERY_SINGLE_PRICE'] = $options['lottery_single_price'];
			$configs['LOTTERY_SINGLE_PRICE_MAX'] = $options['lottery_single_price_max'];
			$configs['RECHARGE_PRICES'] = $options['recharge_prices'];
			$configs['STOP_GOURL'] = $options['stop_gourl'];
			$configs['BAN_GOURL'] = $options['ban_gourl'];
			$configs['LOGIN_APPID'] = $options['login_appid'];
			$configs['LOGIN_APPSECRET'] = $options['login_appsecret'];
			$configs['LOGIN_URL'] = $options['login_url'];
			$configs['LOGIN_KEY'] = $options['login_key'];
			$configs['WXPAY_ENABLED'] = $options['wxpay_enabled'] == '1' ? '1' : '0';
			$configs['WXPAY_TEST_ENABLED'] = $options['wxpay_test_enabled'] == '1' ? '1' : '0';
			$configs['APPID'] = $options['appid'];
			$configs['APPSECRET'] = $options['appsecret'];
			$configs['MCHID'] = $options['mchid'];
			$configs['TERM_ID'] = $options['term_id'];
			$configs['MCH_KEY'] = $options['mch_key'];
			$configs['PAY_URL'] = $options['pay_url'];
			$configs['PAGE_URL'] = $options['page_url'];
			$configs['TIXIAN_OPENID_URL'] = $options['tixian_openid_url'];
			$configs['WFT_ENABLED'] =  $options['wft_enabled'] == '1' ? '1' : '0';
			$configs['WFT_TEST_ENABLED'] = $options['wft_test_enabled'] == '1' ? '1' : '0';
			$configs['WFT_APPID'] = $options['wft_appid'];
			$configs['WFT_APPSECRET'] = $options['wft_appsecret'];
			$configs['WFT_MCHID'] = $options['wft_mchid'];
			$configs['WFT_TERM_ID'] = $options['wft_term_id'];
			$configs['WFT_MCH_KEY'] = $options['wft_mch_key'];
			$configs['WFT_PAY_URL'] = $options['wft_pay_url'];
			$configs['WFT_PAGE_URL'] = $options['wft_page_url'];
			$configs['WFT_QQ_ENABLED'] =  $options['wft_qq_enabled'] == '1' ? '1' : '0';
			$configs['WFT_QQ_TEST_ENABLED'] = $options['wft_qq_test_enabled'] == '1' ? '1' : '0';
			$configs['WFT_QQ_APPID'] = $options['wft_qq_appid'];
			$configs['WFT_QQ_APPSECRET'] = $options['wft_qq_appsecret'];
			$configs['WFT_QQ_MCHID'] = $options['wft_qq_mchid'];
			$configs['WFT_QQ_TERM_ID'] = $options['wft_qq_term_id'];
			$configs['WFT_QQ_MCH_KEY'] = $options['wft_qq_mch_key'];
			$configs['WFT_QQ_PAY_URL'] = $options['wft_qq_pay_url'];
			$configs['WFT_QQ_PAGE_URL'] = $options['wft_qq_page_url'];
			$configs['BFT_ENABLED'] =  $options['bft_enabled'] == '1' ? '1' : '0';
			$configs['BFT_TEST_ENABLED'] = $options['bft_test_enabled'] == '1' ? '1' : '0';
			$configs['BFT_APPID'] = $options['bft_appid'];
			$configs['BFT_SIGNKEY'] = $options['bft_signkey'];
			$configs['BFT_TERM_ID'] = $options['bft_term_id'];
			$configs['BFT_DESTKEY'] = $options['bft_destkey'];
			$configs['BFT_PAY_URL'] = $options['bft_pay_url'];
			$configs['BFT_PAY_URL_ALI'] = $options['bft_pay_url_ali'];
			$configs['BFT_SERVER_IP'] = $options['bft_server_ip'];
			
			$configs['YUBWX_ENABLED'] =  $options['yubwx_enabled'] == '1' ? '1' : '0';
			$configs['YUBWX_TEST_ENABLED'] = $options['yubwx_test_enabled'] == '1' ? '1' : '0';
			$configs['YUBWX_APPID'] = $options['yubwx_appid'];
			$configs['YUBWX_KEY'] = $options['yubwx_key'];
			$configs['YUBWX_TERM_ID'] = $options['yubwx_term_id'];
			$configs['YUBWX_PAY_URL'] = $options['yubwx_pay_url'];
			$configs['YUBWX_GO_URL'] = $options['yubwx_go_url'];
			$configs['YUBWX_SERVER_IP'] = $options['yubwx_server_ip'];
			
			$configs['ZSZF_ENABLED'] =  $options['zszf_enabled'] == '1' ? '1' : '0';
			$configs['ZSZF_TEST_ENABLED'] = $options['zszf_test_enabled'] == '1' ? '1' : '0';
			$configs['ZSZF_APPID'] = $options['zszf_appid'];
			$configs['ZSZF_KEY'] = $options['zszf_key'];
			$configs['ZSZF_TERM_ID'] = $options['zszf_term_id'];
			$configs['ZSZF_PAY_URL'] = $options['zszf_pay_url'];
			$configs['ZSZF_SERVER_IP'] = $options['zszf_server_ip'];
			
			$configs['YOUCHANG_ENABLED'] = $options['youchang_enabled'] == '1' ? '1' : '0';
			$configs['YOUCHANG_TEST_ENABLED'] = $options['youchang_test_enabled'] == '1' ? '1' : '0';
			$configs['YOUCHANG_APPID'] = $options['youchang_appid'];
			$configs['YOUCHANG_APPSECRET'] = $options['youchang_appsecret'];
			$configs['YOUCHANG_MCHID'] = $options['youchang_mchid'];
			$configs['YOUCHANG_TERM_ID'] = $options['youchang_term_id'];
			$configs['YOUCHANG_MCH_KEY'] = $options['youchang_mch_key'];
			$configs['YOUCHANG_PAY_URL'] = $options['youchang_pay_url'];
			$configs['YOUCHANG_PAGE_URL'] = $options['youchang_page_url'];
			$configs['YOUCHANG_ALI_ENABLED'] = $options['youchang_ali_enabled'] == '1' ? '1' : '0';
			$configs['YOUCHANG_ALI_TEST_ENABLED'] = $options['youchang_ali_test_enabled'] == '1' ? '1' : '0';
			$configs['YOUCHANG_ALI_MCHID'] = $options['youchang_ali_mchid'];
			$configs['YOUCHANG_ALI_TERM_ID'] = $options['youchang_ali_term_id'];
			$configs['YOUCHANG_ALI_MCH_KEY'] = $options['youchang_ali_mch_key'];
			$configs['YOUCHANG_ALI_PAY_URL'] = $options['youchang_ali_pay_url'];
			$configs['YOUCHANG_ALI_PAGE_URL'] = $options['youchang_ali_page_url'];
			$configs['COMMISION_VALID_TIME'] = $options['commision_valid_time'];
			$configs['COMMISION_DIVIDE_RATIO'] = $options['commision_divide_ratio'];
			$configs['COMMISION_DIVIDE_RATIO2'] = $options['commision_divide_ratio2'];
			$configs['COMMISION_DIVIDE_RATIO3'] = $options['commision_divide_ratio3'];
			$configs['COMMISION_DIVIDE_RATIO4'] = $options['commision_divide_ratio4'];
			$configs['COMMISION_DIVIDE_RATIO5'] = $options['commision_divide_ratio5'];
			$configs['DRAWCASH_FIRST_BASE_PRICE'] = $options['drawcash_first_base_price'];
			$configs['DRAWCASH_BASE_PRICE'] = $options['drawcash_base_price'];
			$configs['DRAWCASH_MAX_PRICE_PER_DAY'] = $options['drawcash_max_price_per_day'];
			$configs['DRAWCASH_RATIO'] = $options['drawcash_ratio'];
			$configs['DRAWCASH_OVER_RECHARGES_NEED_CHECK'] = $options['drawcash_over_recharges_need_check'];
			$configs['DRAWCASH_LOTTERY_PRICE_RATIO'] = $options['drawcash_lottery_price_ratio'];
			$configs['CONTROL_CHANGE_ENABLED'] = $options['control_change_enabled'];
			$configs['CONTROL_METHOD'] = $options['control_method'];
			$configs['METHOD1_CONTROL_RATIO_TIMES'] = $options['method1_control_ratio_times'];
			$configs['METHOD2_CONTROL_WINS'] = $options['method2_control_wins'];
			$configs['CONTROL_LEVEL'] = $options['control_level'];
			$configs['BEGINNER_MONEY_GIFT'] = $options['beginner_money_gift'];
			$configs['DRAWCASH_TIMES_PER_DAY'] = $options['drawcash_times_per_day'];
			$configs['LOTTERY_PRICE_RATIO'] = $options['lottery_price_ratio'];
			$configs['LOTTERY_PRICE_MUL'] = $options['lottery_price_mul'];
			
			sp_set_dynamic_config($configs);//sae use same function
				
			$data['option_name']="site_options";
			$data['option_value']=json_encode($options);
			if($this->options_model->where("option_name='site_options'")->find()){
				$result=$this->options_model->where("option_name='site_options'")->save($data);
			}else{
				$result=$this->options_model->add($data);
			}
			
			$cmf_settings=I('post.cmf_settings/a');
			$banned_usernames=preg_replace("/[^0-9A-Za-z_\x{4e00}-\x{9fa5}-]/u", ",", $cmf_settings['banned_usernames']);
			$cmf_settings['banned_usernames']=$banned_usernames;

			sp_set_cmf_setting($cmf_settings);
			
			$cdn_settings=I('post.cdn_settings/a');
			sp_set_option('cdn_settings', $cdn_settings);
			
			if ($result!==false) {
				$this->success("保存成功！");
			} else {
				$this->error("保存失败！");
			}
			
		}
	}
	
	// 密码修改
	public function password(){
		$this->display();
	}
	
	// 密码修改提交
	public function password_post(){
		if (IS_POST) {
			if(empty($_POST['old_password'])){
				$this->error("原始密码不能为空！");
			}
			if(empty($_POST['password'])){
				$this->error("新密码不能为空！");
			}
			$user_obj = D("Common/Users");
			$uid=sp_get_current_admin_id();
			$admin=$user_obj->where(array("id"=>$uid))->find();
			$old_password=I('post.old_password');
			$password=I('post.password');
			if(sp_compare_password($old_password,$admin['user_pass'])){
				if($password==I('post.repassword')){
					if(sp_compare_password($password,$admin['user_pass'])){
						$this->error("新密码不能和原始密码相同！");
					}else{
						$data['user_pass']=sp_password($password);
						$data['id']=$uid;
						$r=$user_obj->save($data);
						if ($r!==false) {
							$this->success("修改成功！");
						} else {
							$this->error("修改失败！");
						}
					}
				}else{
					$this->error("密码输入不一致！");
				}
	
			}else{
				$this->error("原始密码不正确！");
			}
		}
	}
	
	// 上传限制设置界面
	public function upload(){
	    $upload_setting=sp_get_upload_setting();
	    $this->assign($upload_setting);
	    $this->display();
	}
	
	// 上传限制设置界面提交
	public function upload_post(){
	    if(IS_POST){
	        $result=sp_set_option('upload_setting',I('post.'));
	        if($result!==false){
	            $this->success('保存成功！');
	        }else{
	            $this->error('保存失败！');
	        }
	    }
	    
	}
	
	// 清除缓存
	public function clearcache(){
		sp_clear_cache();
		$this->display();
	}
	
	
}