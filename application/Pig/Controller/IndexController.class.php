<?php
namespace Pig\Controller;

use Common\Controller\MemberbaseController;

class IndexController extends MemberbaseController {
    private $wallet_db = null;
    private $lottery_db = null;
    private $lottery_ratio_db = null;
	function _initialize(){
		parent::_initialize();
		
		$this->wallet_db = M('wallet');
		$this->lottery_db = M('lottery');
		$this->lottery_ratio_db = M('lottery_ratio');
	}
	
    // 主页
	public function index() {
		
		$this->assign($this->user);
		
		$wallet = $this->wallet_db->where("user_id=" . $this->userid)->find();
		$open_lottery = $this->lottery_db->where("status=0 and open_time>now()")->order('open_time asc')->find();

		$this->assign('open_lottery', $open_lottery);
		
		$lastest_lottery = $this->lottery_db->where("status=1")->order("open_time desc")->find();
		
		$this->assign('lastest_lottery', $lastest_lottery);
		
		$lastest_lottery = $this->lottery_db->where("status=1")->order("open_time desc")->limit(0, 2)->select();
		$lottery_ratio = $this->lottery_ratio_db->where()->order('id desc')->find();
		
		// 客服
		$servicer_db = M('servicer');
		$servicer = $servicer_db->where()->order("id desc")->find();
		
		$smeta = json_decode($servicer['smeta'],true);
		
		$this->assign('servicer_qr', sp_get_asset_upload_path($smeta['thumb']));
		
		$this->assign('recharge_prices', C('RECHARGE_PRICES'));
		$this->assign('lottery_single_price', C('LOTTERY_SINGLE_PRICE'));
		$this->assign('lottery_ratio', $lottery_ratio);
		$this->assign('lastest_lottery', $lastest_lottery);
		$this->assign('wallet', $wallet);
		if ($_SESSION['is_tips'] != 1)
		{
		    $this->assign('is_tips', 0);
		    $_SESSION['is_tips'] = 1;
		}
		else
		{
		    $this->assign('is_tips', 1);
		}
		
		if (C('IS_STOPPED') == '1')
		{
			if (session('is_admin_enter') == '0')
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
		
		$this->display(":index");
    }
    
    // 教程
    public function jiaocheng()
    {
    	$this->display(':jiaocheng');
    }
    
    // 代理
    public function daili1()
    {
    	$this->assign('ratio1', C('COMMISION_DIVIDE_RATIO'));
    	$this->assign('ratio2', C('COMMISION_DIVIDE_RATIO2'));
    	$this->assign('ratio3', C('COMMISION_DIVIDE_RATIO3'));
    	$this->assign('ratio4', C('COMMISION_DIVIDE_RATIO4'));
    	$this->assign('ratio5', C('COMMISION_DIVIDE_RATIO5'));
    	$this->display(':daili1');
    }
    
    private function channels_user_ids($child_channels)
    {
    	$str = '';
    	for ($i=0; $i<count($child_channels); $i++)
    	{
    		if ($i==0)
    			$str = $child_channels[$i]['admin_user_id'];
    		else
    			$str = $str . ',' .  $child_channels[$i]['admin_user_id'];
    	}
    	return $str;
    }
    
    // 佣金
    public function daili2()
    {
    	$channel_db = M('channels a');
    	
    	$my_channel = $channel_db->where("admin_user_id=$this->userid")->find();
    	
    	$child_channels1 = $channel_db->where("parent_id=" . $my_channel['id'])->select();
    	$child_channels2 = $channel_db->join('__CHANNELS__ b on b.id=a.parent_id', 'left')
    	->where("b.parent_id=" . $my_channel['id'])->select();
    	$child_channels3 = $channel_db->join('__CHANNELS__ b on b.id=a.parent_id', 'left')
    	->join('__CHANNELS__ c on c.id=b.parent_id', 'left')
    	->where("c.parent_id=" . $my_channel['id'])->select();
    	$child_channels4 = $channel_db->join('__CHANNELS__ b on b.id=a.parent_id', 'left')
    	->join('__CHANNELS__ c on c.id=b.parent_id', 'left')
    	->join('__CHANNELS__ d on d.id=c.parent_id', 'left')
    	->where("d.parent_id=" . $my_channel['id'])->select();
    	$child_channels5 = $channel_db->join('__CHANNELS__ b on b.id=a.parent_id', 'left')
    	->join('__CHANNELS__ c on c.id=b.parent_id', 'left')
    	->join('__CHANNELS__ d on d.id=c.parent_id', 'left')
    	->join('__CHANNELS__ e on e.id=d.parent_id', 'left')
    	->where("e.parent_id=" . $my_channel['id'])->select();
    	
    	$this->assign('level1_childusers', count($child_channels1));
    	$this->assign('level2_childusers', count($child_channels2));
    	$this->assign('level3_childusers', count($child_channels3));
    	$this->assign('level4_childusers', count($child_channels4));
    	$this->assign('level5_childusers', count($child_channels5));
    	
    	$ids1 = $this->channels_user_ids($child_channels1);
    	$ids2 = $this->channels_user_ids($child_channels2);
    	$ids3 = $this->channels_user_ids($child_channels3);
    	$ids4 = $this->channels_user_ids($child_channels4);
    	$ids5 = $this->channels_user_ids($child_channels5);
    	
    	$wallet_change_log_db = M('wallet_change_log a');
    	
    	$total1 = 0;
    	if (count($child_channels1) > 0)
    	    $total1 = $wallet_change_log_db->join('__LOTTERY_ORDER__ b on b.id=a.object_id', 'left')->where("a.type=4 and b.user_id in ($ids1)")->sum('fee');
    	$total2 = 0;
    	if (count($child_channels2) > 0)
    	    $total2 = $wallet_change_log_db->join('__LOTTERY_ORDER__ b on b.id=a.object_id', 'left')->where("a.type=4 and b.user_id in ($ids2)")->sum('fee');
    	$total3 = 0;
    	if (count($child_channels3) > 0)
    	    $total3 = $wallet_change_log_db->join('__LOTTERY_ORDER__ b on b.id=a.object_id', 'left')->where("a.type=4 and b.user_id in ($ids3)")->sum('fee');
    	$total4 = 0;
    	if (count($child_channels4) > 0)
    	    $total4 = $wallet_change_log_db->join('__LOTTERY_ORDER__ b on b.id=a.object_id', 'left')->where("a.type=4 and b.user_id in ($ids4)")->sum('fee');
    	$total5 = 0;
    	if (count($child_channels5) > 0)
    	    $total5 = $wallet_change_log_db->join('__LOTTERY_ORDER__ b on b.id=a.object_id', 'left')->where("a.type=4 and b.user_id in ($ids5)")->sum('fee');
    	
    	if ($total1 == null)
    	    $total1 = 0;
    	if ($total2 == null)
    	    $total2 = 0;
    	if ($total3 == null)
    	    $total3 = 0;
    	if ($total4 == null)
    	    $total4 = 0;
    	if ($total5 == null)
    	    $total5 = 0;
    	
    	$this->assign('total1', round($total1, 2));
    	$this->assign('total2', round($total2, 2));
    	$this->assign('total3', round($total3, 2));
    	$this->assign('total4', round($total4, 2));
    	$this->assign('total5', round($total5, 2));
    	
    	$this->display(':daili2');
    }
    
    // 下线
    public function daili3()
    {
    	$this->display(':daili3');
    }
    
    // 进入游戏
    public function newduobao()
    {
    	$lottery_ratio = $this->lottery_ratio_db->where()->order('id desc')->find();
    	$this->assign('ratio', $lottery_ratio);
    	$this->assign('lottery_single_price', C('LOTTERY_SINGLE_PRICE'));
    	$this->assign('recharge_prices', C('RECHARGE_PRICES'));
    	$this->assign('lottery_price_ratio', C('LOTTERY_PRICE_RATIO'));
    	
    	$this->display(':newduobao');
    }
    
    // 如何验证
    public function chakandanhao()
    {
    	$this->display(':chakandanhao');
    }
    
    // 充值
    public function newchongzhi()
    {
        // 列举出来可以充值的金额列表
        $this->assign('recharge_prices', C('RECHARGE_PRICES'));
        
        $wallet = $this->wallet_db->where("user_id=" . $this->userid)->find();
        $this->assign('wallet', $wallet);
        
    	$this->display(':newchongzhi');
    }
    
    // 提现
    public function txselect()
    {
    	$wallet = $this->wallet_db->where("user_id=" . $this->userid)->find();
    	$this->assign('wallet', $wallet);
    	$this->assign('base_price', C('DRAWCASH_BASE_PRICE'));
    	$this->assign('max_times', C('DRAWCASH_TIMES_PER_DAY'));
    	
    	$this->display(':txselect');
    }
    
    // 代理佣金提现
    public function dailiyongjintixian()
    {
    	$wallet = $this->wallet_db->where("user_id=" . $this->userid)->find();
    	$this->assign('wallet', $wallet);
    	$this->assign('base_price', C('DRAWCASH_BASE_PRICE'));
    	$this->assign('max_times', C('DRAWCASH_TIMES_PER_DAY'));
    	
    	$this->display(':dailiyongjintixian');
    }
    
    // 我的
    public function newmy()
    {
    	$this->display(':newmy');
    }
    
    // 夺宝记录
    public function newjiaoyimingxi()
    {
    	$this->display(':newjiaoyimingxi');
    }
    
    // 夺宝资金
    public function newzijinmingxi()
    {
    	$this->display(':newzijinmingxi');
    }
    
    // 常见问题
    public function help()
    {
    	$this->display(':help');
    }
    
    // 夺宝规则
    public function jiaoyiguize()
    {
    	$this->display(':jiaoyiguize');
    }
    
    // 充值相关
    public function chongzhixiangguan()
    {
    	$this->display(':chongzhixiangguan');
    }
    
    // 提现相关
    public function tixianxiangguan()
    {
    	$this->display(':tixianxiangguan');
    }
    
    // 每日签到
    public function signed()
    {
        $wallet_change_log_db = M('wallet_change_log');
        
        $total_fee = $wallet_change_log_db->where("user_id=$this->userid and `type`=6")->sum('fee');
        
        $this->assign('total_bonus', $total_fee);
        
    	$this->display(':signed');
    }
    
    // 联系客服
    public function lxKF()
    {
    	// 客服
    	$servicer_db = M('servicer');
    	$servicer = $servicer_db->where()->order("id desc")->find();
    	
    	$smeta = json_decode($servicer['smeta'],true);
    	
    	$this->assign('servicer_qr', sp_get_asset_upload_path($smeta['thumb']));
    	
    	$this->display(':lxKF');
    }
}
