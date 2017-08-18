<?php

/**
 * 渠道管理
*/
namespace Agent\Controller;
use Common\Controller\AdminbaseController;
class RechargeadminController extends AdminbaseController {
    function index() {

        $model=M("recharge_order a");
        
        $where = "1";
        
        if (isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '')
        {
            $where .= ' and a.user_id=' . $_REQUEST['user_id'];
        }
        
        if (isset($_REQUEST['id']) && $_REQUEST['id'] != '')
        {
        	$where .= ' and a.id=' . $_REQUEST['id'];
        }
        
        
        if (isset($_REQUEST['status']) && $_REQUEST['status'] != '')
            $where .= ' and a.status=' . $_REQUEST['status'];
            if (isset($_REQUEST['start_ymd']) && $_REQUEST['start_ymd'] != null) {
            $start_date = $_REQUEST['start_ymd'];
            $date_format = '%Y-%m-%d';
            $date_arrs = explode('-', $start_date);
            if (count($date_arrs) == 2) {
                $date_format = '%Y-%m';
            }
            
            $where .= " and DATE_FORMAT( a.create_time,'" . $date_format . "')>='" . $start_date . "'";
        }
        
        if (isset($_REQUEST['order_sn']) && $_REQUEST['order_sn'] != '')
            $where .= ' and a.order_sn like "%' . $_REQUEST['order_sn'] . '%"';
        
        if (isset($_REQUEST['end_ymd']) && $_REQUEST['end_ymd'] != null) {
            $end_date = $_REQUEST['end_ymd'];
            $date_format = '%Y-%m-%d';
            $date_arrs = explode('-', $end_date);
            if (count($date_arrs) == 2) {
                $date_format = '%Y-%m';
            }
            
            $where .= " and DATE_FORMAT( a.create_time,'" . $date_format . "')<='" . $end_date . "'";
        }
     
        $count=$model
        ->join('__USERS__ b on b.id=a.user_id', 'left')
        ->where($where)
        ->count();
        $page = $this->page($count, 20);
        $lists = $model
        ->join('__USERS__ b on b.id=a.user_id', 'left')
        ->join('__WX_PAY__ c on c.from_order_sn=a.id')
        ->where($where)
        ->order("id DESC")
        ->field('a.*,b.user_nicename,c.price as real_price, c.status as real_status, c.is_ok,c.transition_id')
        ->limit($page->firstRow . ',' . $page->listRows)
        ->select();
        
        for ($i=0; $i<count($lists); $i++)
        {
        	if ($lists[$i]['real_price'] > 0)
        	{
        		$lists[$i]['real_price'] = $lists[$i]['real_price'];// / 100;
        		$lists[$i]['real_price_det'] = $lists[$i]['real_price'] - $lists[$i]['price'];
        	}
        }
        
        $this->assign('filter', $_REQUEST);
        $this->assign('lists', $lists);
        $this->assign("page", $page->show('Admin'));
    
        $this->display();
    }
    
    function wallet_change_index() {
    	
    	$model=M("wallet_change_log a");
    	
    	$where = "1";
    	
    	if (isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '')
    	{
    		$where .= ' and a.user_id=' . $_REQUEST['user_id'];
    	}
    	
    	if (isset($_REQUEST['status']) && $_REQUEST['status'] != '')
    		$where .= ' and a.status=' . $_REQUEST['status'];
    		if (isset($_REQUEST['start_ymd']) && $_REQUEST['start_ymd'] != null) {
    			$start_date = $_REQUEST['start_ymd'];
    			$date_format = '%Y-%m-%d';
    			$date_arrs = explode('-', $start_date);
    			if (count($date_arrs) == 2) {
    				$date_format = '%Y-%m';
    			}
    			
    			$where .= " and DATE_FORMAT( a.create_time,'" . $date_format . "')>='" . $start_date . "'";
    		}
    		
    			
    			if (isset($_REQUEST['end_ymd']) && $_REQUEST['end_ymd'] != null) {
    				$end_date = $_REQUEST['end_ymd'];
    				$date_format = '%Y-%m-%d';
    				$date_arrs = explode('-', $end_date);
    				if (count($date_arrs) == 2) {
    					$date_format = '%Y-%m';
    				}
    				
    				$where .= " and DATE_FORMAT( a.create_time,'" . $date_format . "')<='" . $end_date . "'";
    			}
    			
    			$count=$model
    			->join('__USERS__ b on b.id=a.user_id', 'left')
    			->where($where)
    			->count();
    			$page = $this->page($count, 20);
    			$lists = $model
    			->join('__USERS__ b on b.id=a.user_id', 'left')
    			->where($where)
    			->order("id DESC")
    			->field('a.*,b.user_nicename')
    			->limit($page->firstRow . ',' . $page->listRows)
    			->select();
    			
    			$recharge_order_model = M('recharge_order a');
    			
    			for ($i=0; $i<count($lists); $i++)
    			{
    				if ($lists[$i]['type'] == 0)
    				{
    					$order = $recharge_order_model
    					->join('__WX_PAY__ c on c.from_order_sn=a.id')
    					->where("a.id=" . $lists[$i]['object_id'])
    					->field("a.price,c.price as real_price")
    					->find();
    					
    					$lists[$i]['memo'] .= ',实际支付:' . $order['real_price']. '分';
    				}
    			}
    			
    			$this->assign('filter', $_REQUEST);
    			$this->assign('lists', $lists);
    			$this->assign("page", $page->show('Admin'));
    			
    			$this->display();
    }
}
