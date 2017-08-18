<?php
namespace Qqonline\Controller;

use Common\Controller\HomebaseController;

class ControlController extends HomebaseController
{

    private $lottery_db = null;

    function _initialize()
    {
        parent::_initialize();
        
        $this->lottery_db = M('lottery');
    }

    function control($lottery, $memo, $control_method)
    {
        $model = M('lottery');
        
        $lottery_order_model = M('lottery_order');
        
        // 获得赔率
        $lottery_ratio_db = M('lottery_ratio');
        $lottery_ratio = $lottery_ratio_db->where()->find();
        
        if ($lottery['status'] == 0 || $lottery['status'] == 1) {
            // 控制赔率
            $buy = array();
            
            // 计算赔率,已出结果
            $r = array();
            $r['0_-1'] = 0;
            $r['0_0'] = 0;
            $r['0_1'] = 0;
            $r['0_10'] = 0;
            $r['0_11'] = 0;
            $r['1_0'] = 0;
            $r['1_1'] = 0;
            $r['1_2'] = 0;
            $r['1_3'] = 0;
            $r['1_4'] = 0;
            $r['1_10'] = 0;
            $r['1_11'] = 0;
            $r['1_12'] = 0;
            for ($j = 0; $j <= 9; $j ++) {
                $r['2_' . $j] = 0;
            }
            
            $r['0_-1'] = (1 - $lottery_ratio['small_ratio']);
            $r['0_0'] = (1 - $lottery_ratio['mid_ratio']);
            $r['0_1'] = (1 - $lottery_ratio['big_ratio']);
            $r['0_10'] = (1 - $lottery_ratio['odd_ratio']); // 单
            $r['0_11'] = (1 - $lottery_ratio['event_ratio']); // 双
            $r['1_0'] = (1 - $lottery_ratio['num2_ratio']);
            $r['1_1'] = (1 - $lottery_ratio['num2_ratio']);
            $r['1_2'] = (1 - $lottery_ratio['num2_ratio']);
            $r['1_3'] = (1 - $lottery_ratio['num2_ratio']);
            $r['1_4'] = (1 - $lottery_ratio['num2_ratio']);
            $r['1_10'] = (1 - $lottery_ratio['num3_ratio']);
            $r['1_11'] = (1 - $lottery_ratio['num3_ratio']);
            $r['1_12'] = (1 - $lottery_ratio['num3_ratio']);
            
            for ($j = 0; $j <= 9; $j ++) {
                $r['2_' . $j] = (1 - $lottery_ratio['num_ratio']);
            }
            
            $result_from = 'total_result';
            if ($lottery['status'] != 2)
                $result_from = 'result';
            
            $buy['0_-1'] = $lottery_order_model->where("no='" . $lottery['no'] . "' and buy_method=0 and `0_-1`=1")
                ->field('sum(price/buy_type_count) as total_price, count(id) as total_count, sum((price-win)/buy_type_count) as total_result')
                ->find();
            $buy['0_-1']['result'] = $buy['0_-1']['total_price'] * $r['0_-1'];
            $buy['0_-1']['total_result'] = round($buy['0_-1'][$result_from], 3);
            $buy['0_0'] = $lottery_order_model->where("no='" . $lottery['no'] . "' and buy_method=0 and `0_0`=1")
                ->field('sum(price/buy_type_count) as total_price, count(id) as total_count, sum((price-win)/buy_type_count) as total_result')
                ->find();
            $buy['0_0']['result'] = $buy['0_0']['total_price'] * $r['0_0'];
            $buy['0_0']['total_result'] = round($buy['0_0'][$result_from], 3);
            $buy['0_1'] = $lottery_order_model->where("no='" . $lottery['no'] . "' and buy_method=0 and `0_1`=1")
                ->field('sum(price/buy_type_count) as total_price, count(id) as total_count, sum((price-win)/buy_type_count) as total_result')
                ->find();
            $buy['0_1']['result'] = $buy['0_1']['total_price'] * $r['0_1'];
            $buy['0_1']['total_result'] = round($buy['0_1'][$result_from], 3);
            $buy['0_10'] = $lottery_order_model->where("no='" . $lottery['no'] . "' and buy_method=0 and `0_10`=1")
                ->field('sum(price/buy_type_count) as total_price, count(id) as total_count, sum((price-win)/buy_type_count) as total_result')
                ->find();
            $buy['0_10']['result'] = $buy['0_10']['total_price'] * $r['0_10'];
            $buy['0_10']['total_result'] = round($buy['0_1'][$result_from], 3);
            $buy['0_11'] = $lottery_order_model->where("no='" . $lottery['no'] . "' and buy_method=0 and `0_11`=1")
                ->field('sum(price/buy_type_count) as total_price, count(id) as total_count, sum((price-win)/buy_type_count) as total_result')
                ->find();
            $buy['0_11']['result'] = $buy['0_11']['total_price'] * $r['0_11'];
            $buy['0_11']['total_result'] = round($buy['0_1'][$result_from], 3);
            
            for ($j = 0; $j <= 4; $j ++) {
                $buy['1_' . $j] = $lottery_order_model->where("no='" . $lottery['no'] . "' and buy_method=1 and `1_" . $j . "`=1")
                    ->field('sum(price/buy_type_count) as total_price, count(id) as total_count, sum((price-win)/buy_type_count) as total_result')
                    ->find();
                $buy['1_' . $j]['result'] = $buy['1_' . $j]['total_price'] * $r['1_' . $j];
                $buy['1_' . $j]['total_result'] = round($buy['1_' . $j][$result_from], 3);
            }
            
            for ($j = 10; $j <= 12; $j ++) {
                $buy['1_' . $j] = $lottery_order_model->where("no='" . $lottery['no'] . "' and buy_method=1 and `1_" . $j . "`=1")
                    ->field('sum(price/buy_type_count) as total_price, count(id) as total_count, sum((price-win)/buy_type_count) as total_result')
                    ->find();
                $buy['1_' . $j]['result'] = $buy['1_' . $j]['total_price'] * $r['1_' . $j];
                $buy['1_' . $j]['total_result'] = round($buy['1_' . $j][$result_from], 3);
            }
            
            for ($j = 0; $j <= 9; $j ++) {
                $buy['2_' . $j] = $lottery_order_model->where("no='" . $lottery['no'] . "' and buy_method=2 and `2_" . $j . "`=1")
                    ->field('sum(price/buy_type_count) as total_price, count(id) as total_count, sum((price-win)/buy_type_count) as total_result')
                    ->find();
                $buy['2_' . $j]['result'] = $buy['2_' . $j]['total_price'] * $r['2_' . $j];
                $buy['2_' . $j]['total_result'] = round($buy['2_' . $j][$result_from], 3);
            }
            
            // 做预测
            // 计算所有数的数值
            $num = array();
            for ($j = 0; $j <= 9; $j ++)
                $num[$j] = $buy['2_' . $j]['result'];
                
                // 计算数组
            $num['0'] += $buy['1_0']['result'] + $buy['1_10']['result'] + $buy['0_-1']['result'] + $buy['0_11']['result'];
            $num['1'] += $buy['1_0']['result'] + $buy['1_10']['result'] + $buy['0_-1']['result'] + $buy['0_10']['result'];
            $num['2'] += $buy['1_1']['result'] + $buy['1_10']['result'] + $buy['0_-1']['result'] + $buy['0_11']['result'];
            $num['3'] += $buy['1_1']['result'] + $buy['1_11']['result'] + $buy['0_-1']['result'] + $buy['0_10']['result'];
            $num['4'] += $buy['1_2']['result'] + $buy['1_11']['result'] + $buy['0_-1']['result'] + $buy['0_11']['result'];
            $num['5'] += $buy['1_2']['result'] + $buy['1_11']['result'] + $buy['0_1']['result'] + $buy['0_10']['result'];
            $num['6'] += $buy['1_3']['result'] + $buy['1_12']['result'] + $buy['0_1']['result'] + $buy['0_11']['result'];
            $num['7'] += $buy['1_3']['result'] + $buy['1_12']['result'] + $buy['0_1']['result'] + $buy['0_10']['result'];
            $num['8'] += $buy['1_4']['result'] + $buy['1_12']['result'] + $buy['0_1']['result'] + $buy['0_11']['result'];
            $num['9'] += $buy['1_4']['result'] + $buy['0_1']['result'] + $buy['0_10']['result'];
            
            arsort($num);
            
            $num_arr = array_keys($num);
            
            $level_control = intval(C('CONTROL_LEVEL'));
            
            if ($control_method == 1 || $control_method == 2) // 放水,则按照从高到底来放,数字越大,越狠
{
                $rand_level = rand(0, 4);
                if ($level_control == 4) {
                    if (rand(0, 100) < 70)
                        $levle_control = rand(2, 4);
                } else 
                    if ($level_control == 3) {
                        if (rand(0, 100) < 50)
                            $levle_control = rand(2, 4);
                    } else 
                        if ($level_control == 2) {
                            if (rand(0, 100) < 30)
                                $levle_control = rand(2, 4);
                        } else 
                            if ($level_control == 1) {
                                if (rand(0, 100) < 20)
                                    $levle_control = rand(2, 4);
                            }
                $last_num = $num_arr[5 + $rand_level];
            } else {
                $rand_level = rand(0, 4);
                if ($level_control == 4) {
                    if (rand(0, 100) < 70)
                        $rand_level = rand(2, 4);
                } else 
                    if ($level_control == 3) {
                        if (rand(0, 100) < 50)
                            $rand_level = rand(2, 4);
                    } else 
                        if ($level_control == 2) {
                            if (rand(0, 100) < 30)
                                $rand_level = rand(2, 4);
                        } else 
                            if ($level_control == 1) {
                                if (rand(0, 100) < 20)
                                    $rand_level = rand(2, 4);
                            }
                $last_num = $num_arr[4 - $rand_level];
            }
            
            $data = array(
                'last_num' => $last_num,
                'control_memo' => $memo
            );
            
            $this->lottery_db->where("id=" . $lottery['id'])->save($data);
            
            $this->ajaxReturn(array(
                'ret' => 1,
                'msg' => '设置中奖个位数【' . $last_num . '】成功,备注:' . $memo
            ));
        } else {
            $this->ajaxReturn(array(
                'ret' => - 1,
                'msg' => '已经开奖，不能设置了'
            ));
        }
    }

    function get_commision($no)
    {
        $order_db = M('lottery_order');
        
        $channel_db = M('channels');
        
        // 有效日期
        $n = C('COMMISION_VALID_TIME');
        
        $total_fee = 0;
        
        $orders = $order_db->alias('a')
            ->join('__CHANNELS__ b on b.admin_user_id=a.user_id', 'left')
            ->
        // 是来自与哪个渠道,检测是否超过时效
        where("a.no='$no'")
            ->field('a.*, b.admin_user_id as channel_user_id, b.divide_ratio as channel_divide_ratio,b.parent_channels')
            ->select();
        
        for ($i = 0; $i < count($orders); $i ++) {
            // 获取这笔订单的所有可以分的渠道佣金
            $order = $orders[$i];
            
            $fee = floatval($order['price']); // - floatval($order['win']);
            
            if ($fee <= 0)
                continue;
            
            if ($order['parent_channels'] != null) {
                // 所有父渠道
                $parent_channels = $channel_db->where('id in (' . $order['parent_channels'] . ')')->select();
                
                $level_ratio = C('COMMISION_DIVIDE_RATIO5');
                
                for ($j = count($parent_channels); $j --; $j >= 0) {
                    // 这里需要过滤已经不纳入佣金的渠道
                    if ($j == 0)
                        $level_ratio = C('COMMISION_DIVIDE_RATIO');
                    else 
                        if ($j == 1)
                            $level_ratio = C('COMMISION_DIVIDE_RATIO2');
                        else 
                            if ($j == 2)
                                $level_ratio = C('COMMISION_DIVIDE_RATIO3');
                            else 
                                if ($j == 3)
                                    $level_ratio = C('COMMISION_DIVIDE_RATIO4');
                                else
                                    $level_ratio = C('COMMISION_DIVIDE_RATIO5');
                    
                    $parent_channel = $parent_channels[$j];
                    
                    $ratio = $level_ratio;
                    
                    $total_fee += $ratio * $fee / 100.0;
                }
            }
        }
        
        return $total_fee;
    }
    
    // 启动控制
    function ajax_control()
    {
        $lottery = $this->lottery_db->where()
            ->order('id desc')
            ->find();
        
        if ($lottery['last_num'] != '' && $lottery['last_num'] != null) {
            $this->ajaxReturn(array(
                'ret' => - 1,
                'msg' => '已经指定号码,不能控盘'
            ));
            return;
        }
        
        $lottery_order_model = M('lottery_order');
        
        $control_method = intval(C('CONTROL_METHOD'));
        
        $need_control = false;
        if ($control_method == 0)
            $this->ajaxReturn(array(
                'ret' => - 1,
                msg => '系统设置不控制'
            ));
        else {
            $total_count = $lottery_order_model->where("no='" . $lottery['no'] . "'")->count();
            
            if ($control_method == 1 || $control_method == 3) // 根据次数
{
                $temp = sp_get_cmf_settings('method1_control_ratio_times_temp');
                
                if ($temp == null)
                    $temp = 0;
                
                $temp ++;
                
                // 判断次数是否达到
                if ($temp >= C('METHOD1_CONTROL_RATIO_TIMES')) {
                    $temp = 0;
                    $need_control = true;
                    
                    $memo = '达到次数:' . C('METHOD1_CONTROL_RATIO_TIMES');
                } else {
                    $need_control = false;
                    
                    $memo = '当前次数:' . $temp . '/' . C('METHOD1_CONTROL_RATIO_TIMES');
                }
                
                sp_set_cmf_setting(array(
                    'method1_control_ratio_times_temp' => $temp
                ));
            } else // 根据开奖概率
{
                $current_day_stat = $lottery_order_model->where("`no`<>'" . $lottery['no'] . "' and TO_DAYS(create_time)=TO_DAYS(now())")
                    ->field('count(*) as total_count, sum(price) as total_price, sum(price-win) as total_result')
                    ->find();
                
                // 佣金
                $wallet_change_log_db = M('wallet_change_log a');
                $curday_commission = $wallet_change_log_db->where("a.type=4 and TO_DAYS(a.create_time)=TO_DAYS(now())")->sum('fee');
                if ($curday_commission == null)
                    $curday_commission = 0;
                
                $win_ratio = 0;
                if ($current_day_stat['total_price'] > 0)
                    $win_ratio = round(($current_day_stat['total_result'] - $curday_commission) * 100.0 / $current_day_stat['total_price'], 3);
                
                if ($control_method == 2) // 放水
{
                    if ($win_ratio >= C('METHOD2_CONTROL_WINS')) {
                        $need_control = true;
                        
                        $memo = '(放水|控盘)当前盈率:' . $win_ratio . '%,目标盈率' . C('METHOD2_CONTROL_WINS') . '%,总投注:' . $current_day_stat['total_price'] . ',总获利:' . $current_day_stat['total_result'];
                    } else {
                        
                        if (C('CONTROL_CHANGE_ENABLED') == '1') {
                            
                            $control_method = 4;
                            
                            $need_control = true;
                            
                            $memo = '(放水|转抽水)当前盈率:' . $win_ratio . '%,目标盈率' . C('METHOD2_CONTROL_WINS') . '%,总投注:' . $current_day_stat['total_price'] . ',总获利:' . $current_day_stat['total_result'];
                        } else {
                            $need_control = false;
                            
                            $memo = '(放水|不控盘)当前盈率:' . $win_ratio . '%,目标盈率' . C('METHOD2_CONTROL_WINS') . '%,总投注:' . $current_day_stat['total_price'] . ',总获利:' . $current_day_stat['total_result'];
                        }
                    }
                } else {
                    if ($win_ratio < C('METHOD2_CONTROL_WINS')) {
                        $need_control = true;
                        
                        $memo = '(抽水|控盘)当前盈率:' . $win_ratio . '%,目标盈率' . C('METHOD2_CONTROL_WINS') . '%,总投注:' . $current_day_stat['total_price'] . ',总获利:' . $current_day_stat['total_result'];
                    } else {
                        $need_control = false;
                        
                        $memo = '(抽水|不控盘)当前盈率:' . $win_ratio . '%/' . C('METHOD2_CONTROL_WINS') . '%,总投注:' . $current_day_stat['total_price'] . ',总获利:' . $current_day_stat['total_result'];
                    }
                }
            }
            
            if ($total_count < 1) {
                $need_control = false;
            }
            
            if ($need_control)
                $this->control($lottery, $memo, $control_method);
            else
                $this->ajaxReturn(array(
                    'ret' => - 1,
                    'msg' => $memo
                ));
        }
    }

    public function ajax_get_hostnames()
    {
        $db = M('hostnames');
        $lists = $db->where('`status`=1')->select();
        
        $this->ajaxReturn(array(
            'ret' => 1,
            'lists' => $lists
        ));
    }

    public function ajax_load_data()
    {
        $model = M("lottery a");
        
        $lottery_order_model = M('lottery_order a');
        
        $wallet_change_log_db = M('wallet_change_log a');
        
        // 获得赔率
        $lottery_ratio_db = M('lottery_ratio');
        $lottery_ratio = $lottery_ratio_db->where()->find();
        
        $current_lottery = $model->where()
            ->order("id desc")
            ->find();
        
        $curday_stat = $lottery_order_model->where("TO_DAYS(a.create_time)=TO_DAYS(now()) and no<>'" . $current_lottery['no'] . "'")
            ->field('sum(a.price) as total_price, sum(a.win) as total_win')
            ->find();
        $curday_total_price = $curday_stat['total_price'] == null ? 0 : $curday_stat['total_price'];
        $curday_commission = $wallet_change_log_db->where("a.type=4 and TO_DAYS(a.create_time)=TO_DAYS(now())")->sum('fee');
        if ($curday_commission == null)
            $curday_commission = 0;
        $curday_total_win = $curday_stat['total_win'] == null ? 0 : $curday_stat['total_win'];
        $curday_total = $curday_total_price - $curday_total_win - $curday_commission;
        
        // 做预测
        $buy = array();
        
        // 计算赔率,已出结果
        $r = array();
        $r['0_-1'] = 0;
        $r['0_0'] = 0;
        $r['0_1'] = 0;
        $r['0_10'] = 0;
        $r['0_11'] = 0;
        $r['1_0'] = 0;
        $r['1_1'] = 0;
        $r['1_2'] = 0;
        $r['1_3'] = 0;
        $r['1_4'] = 0;
        $r['1_10'] = 0;
        $r['1_11'] = 0;
        $r['1_12'] = 0;
        for ($j = 0; $j <= 9; $j ++)
            $r['2_' . $j] = 0;
        
        $r['0_-1'] = (1 - $lottery_ratio['small_ratio']);
        $r['0_0'] = (1 - $lottery_ratio['mid_ratio']);
        $r['0_1'] = (1 - $lottery_ratio['big_ratio']);
        $r['0_10'] = (1 - $lottery_ratio['odd_ratio']);
        $r['0_11'] = (1 - $lottery_ratio['event_ratio']);
        $r['1_0'] = (1 - $lottery_ratio['num2_ratio']);
        $r['1_1'] = (1 - $lottery_ratio['num2_ratio']);
        $r['1_2'] = (1 - $lottery_ratio['num2_ratio']);
        $r['1_3'] = (1 - $lottery_ratio['num2_ratio']);
        $r['1_4'] = (1 - $lottery_ratio['num2_ratio']);
        $r['1_10'] = (1 - $lottery_ratio['num3_ratio']);
        $r['1_11'] = (1 - $lottery_ratio['num3_ratio']);
        $r['1_12'] = (1 - $lottery_ratio['num3_ratio']);
        
        for ($j = 0; $j <= 9; $j ++)
            $r['2_' . $j] = (1 - $lottery_ratio['num_ratio']);
        
        $result_from = 'result';
        
        $buy['0_-1'] = $lottery_order_model->where("no='" . $current_lottery['no'] . "' and buy_method=0 and `0_-1`=1")
            ->field('IFNULL(sum(price/buy_type_count),0) as total_price, count(id) as total_count, sum((price-win)/buy_type_count) as total_result')
            ->find();
        $buy['0_-1']['result'] = $buy['0_-1']['total_price'] * $r['0_-1'];
        $buy['0_-1']['total_result'] = round($buy['0_-1'][$result_from], 3);
        $buy['0_0'] = $lottery_order_model->where("no='" . $current_lottery['no'] . "' and buy_method=0 and `0_0`=1")
            ->field('IFNULL(sum(price/buy_type_count),0) as total_price, count(id) as total_count, sum((price-win)/buy_type_count) as total_result')
            ->find();
        $buy['0_0']['result'] = $buy['0_0']['total_price'] * $r['0_0'];
        $buy['0_0']['total_result'] = round($buy['0_0'][$result_from], 3);
        $buy['0_1'] = $lottery_order_model->where("no='" . $current_lottery['no'] . "' and buy_method=0 and `0_1`=1")
            ->field('IFNULL(sum(price/buy_type_count),0) as total_price, count(id) as total_count, sum((price-win)/buy_type_count) as total_result')
            ->find();
        $buy['0_1']['result'] = $buy['0_1']['total_price'] * $r['0_1'];
        $buy['0_1']['total_result'] = round($buy['0_1'][$result_from], 3);
        $buy['0_10'] = $lottery_order_model->where("no='" . $current_lottery['no'] . "' and buy_method=0 and `0_10`=1")
            ->field('IFNULL(sum(price/buy_type_count),0) as total_price, count(id) as total_count, sum((price-win)/buy_type_count) as total_result')
            ->find();
        $buy['0_10']['result'] = $buy['0_01']['total_price'] * $r['0_10'];
        $buy['0_10']['total_result'] = round($buy['0_10'][$result_from], 3);
        $buy['0_11'] = $lottery_order_model->where("no='" . $current_lottery['no'] . "' and buy_method=0 and `0_11`=1")
            ->field('IFNULL(sum(price/buy_type_count),0) as total_price, count(id) as total_count, sum((price-win)/buy_type_count) as total_result')
            ->find();
        $buy['0_11']['result'] = $buy['0_11']['total_price'] * $r['0_11'];
        $buy['0_11']['total_result'] = round($buy['0_11'][$result_from], 3);
        
        for ($j = 0; $j <= 4; $j ++) {
            $buy['1_' . $j] = $lottery_order_model->where("no='" . $current_lottery['no'] . "' and buy_method=1 and `1_" . $j . "`=1")
                ->field('IFNULL(sum(price/buy_type_count),0) as total_price, count(id) as total_count, sum((price-win)/buy_type_count) as total_result')
                ->find();
            $buy['1_' . $j]['result'] = $buy['1_' . $j]['total_price'] * $r['1_' . $j];
            $buy['1_' . $j]['total_result'] = round($buy['1_' . $j][$result_from], 3);
        }
        
        for ($j = 10; $j <= 12; $j ++) {
            $buy['1_' . $j] = $lottery_order_model->where("no='" . $current_lottery['no'] . "' and buy_method=1 and `1_" . $j . "`=1")
                ->field('IFNULL(sum(price/buy_type_count),0) as total_price, count(id) as total_count, sum((price-win)/buy_type_count) as total_result')
                ->find();
            $buy['1_' . $j]['result'] = $buy['1_' . $j]['total_price'] * $r['1_' . $j];
            $buy['1_' . $j]['total_result'] = round($buy['1_' . $j][$result_from], 3);
        }
        
        for ($j = 0; $j <= 9; $j ++) {
            $buy['2_' . $j] = $lottery_order_model->where("no='" . $current_lottery['no'] . "' and buy_method=2 and `2_" . $j . "`=1")
                ->field('IFNULL(sum(price/buy_type_count),0) as total_price, count(id) as total_count, sum((price-win)/buy_type_count) as total_result')
                ->find();
            $buy['2_' . $j]['result'] = $buy['2_' . $j]['total_price'] * $r['2_' . $j];
            $buy['2_' . $j]['total_result'] = round($buy['2_' . $j][$result_from], 3);
        }
        
        $current_lottery['buy'] = $buy;
        
        $current_lottery['total_count'] = $lottery_order_model->where("no='" . $current_lottery['no'] . "'")->count();
        $current_lottery['total_price'] = $lottery_order_model->where("no='" . $current_lottery['no'] . "'")->sum('price');
        if ($current_lottery['status'] == 2) {
            $current_lottery['total_result'] = '盈余:' . $lottery_order_model->where("no='" . $current_lottery['no'] . "'")->sum('price-win');
            
            // 统计佣金
            
            $current_lottery['total_commission'] = $wallet_change_log_db->join('__LOTTERY_ORDER__ b on b.id=a.object_id', 'left')
                ->where("a.type=4 and b.no='" . $current_lottery['no'] . "'")
                ->sum('fee');
        } else {
            // 做预测
            // 计算所有数的数值
            $num = array();
            for ($j = 0; $j <= 9; $j ++)
                $num[$j] = $buy['2_' . $j]['result'];
                
                // 计算数组
            $num['0'] += $buy['1_0']['result'] + $buy['1_10']['result'] + $buy['0_-1']['result'] + $buy['0_11']['result'];
            $num['1'] += $buy['1_0']['result'] + $buy['1_10']['result'] + $buy['0_-1']['result'] + $buy['0_10']['result'];
            $num['2'] += $buy['1_1']['result'] + $buy['1_10']['result'] + $buy['0_-1']['result'] + $buy['0_11']['result'];
            $num['3'] += $buy['1_1']['result'] + $buy['1_11']['result'] + $buy['0_-1']['result'] + $buy['0_10']['result'];
            $num['4'] += $buy['1_2']['result'] + $buy['1_11']['result'] + $buy['0_-1']['result'] + $buy['0_11']['result'];
            $num['5'] += $buy['1_2']['result'] + $buy['1_11']['result'] + $buy['0_1']['result'] + $buy['0_10']['result'];
            $num['6'] += $buy['1_3']['result'] + $buy['1_12']['result'] + $buy['0_1']['result'] + $buy['0_11']['result'];
            $num['7'] += $buy['1_3']['result'] + $buy['1_12']['result'] + $buy['0_1']['result'] + $buy['0_10']['result'];
            $num['8'] += $buy['1_4']['result'] + $buy['1_12']['result'] + $buy['0_1']['result'] + $buy['0_11']['result'];
            $num['9'] += $buy['1_4']['result'] + $buy['0_1']['result'] + $buy['0_10']['result'];
            
            arsort($num);
            
            $num_arr = array_keys($num);
            
            $current_lottery['total_result'] = '0【选择个位:' . $num_arr[0] . '';
            
            for ($j = 0; $j < count($num_arr); $j ++) {
                $html = '<button onclick="set_number(' . $current_lottery['id'] . ',' . $num_arr[$j] . ')">&nbsp;' . $num_arr[$j] . '&nbsp;</button>';
                if ($j == 0)
                    $current_lottery['number'] = $html;
                else
                    $current_lottery['number'] .= '&nbsp;&nbsp;' . $html;
            }
            
            $current_lottery['total_commission'] = $this->get_commision($current_lottery['no']);
        }
        
        $win_ratio = 0;
        if ($curday_total_price > 0)
            $win_ratio = round($curday_total * 100.0 / $curday_total_price, 3);
        
        $this->ajaxReturn(array(
            'ret' => 1,
            'current_lottery' => $current_lottery,
            'curday_total_price' => $curday_total_price,
            'curday_total_price' => $curday_total_price,
            'curday_total_win' => $curday_total_win,
            'curday_commission' => $curday_commission,
            'win_ratio' => $win_ratio,
            'curday_total' => $curday_total
        ));
    }
    
    // 定时打款
    public function ajax_complete_drawcash()
    {
        require_once SITE_PATH . "/wxpay/lib/WxTransfers.Config.php";
        require_once SITE_PATH . "/wxpay/lib/WxTransfers.Api.php";
        
        $model = M('drawcash');
        
        \WxTransfersConfig::$APPID = C('APPID');
        \WxTransfersConfig::$APPSECRET = C('APPSECRET');
        \WxTransfersConfig::$MCHID = C('MCHID');
        \WxTransfersConfig::$KEY = C('MCH_KEY');
        
        // 这里打款
        $path = \WxTransfersConfig::getRealPath(); // 证书文件路径
        $config['wxappid'] = \WxTransfersConfig::$APPID;
        $config['mch_id'] = \WxTransfersConfig::$MCHID;
        $config['key'] = \WxTransfersConfig::$KEY;
        $config['PARTNERKEY'] = \WxTransfersConfig::$KEY;
        $config['api_cert'] = $path . \WxTransfersConfig::SSLCERT_PATH;
        $config['api_key'] = $path . \WxTransfersConfig::SSLKEY_PATH;
        $config['rootca'] = $path . \WxTransfersConfig::SSLROOTCA;
        
        $wxtran = new \WxTransfers($config);
        
        $wxtran->setLogFile('./logs/transfers.log'); // 日志地址
        
        $user_db = M('users');
        
        $lists = $model->where("status in (0,1) and need_check=0 and openid<>'' and type=0")->select();
        
        $has_process = array();
        
        $total_prices = 0;
        for ($i = 0; $i < count($lists); $i ++) {
            $apply = $lists[$i];
            
            if (in_array('' . $apply['user_id'], $has_process, true)) {
                $model->where("id=" . $apply['id'])->setField('return_msg', $wxtran->error);
                
                $ret_data = array(
                    'status' => 3,
                    'return_msg' => '同一周期出现多个提现!',
                    'completed_time' => date("Y-m-d H:i:s")
                );
                
                $model->where("id=" . $apply['id'])->save($ret_data);
                
                continue;
            }
            
            $user = $user_db->where("id=" . $apply['user_id'])->find();
            
            $total_prices += $apply['price'] * (1.0 - floatval(C('DRAWCASH_RATIO')) * 0.01) * 100;
            
            // 转账
            $data = array(
                'openid' => $apply['openid'],
                'check_name' => 'NO_CHECK', // 是否验证真实姓名参数
                're_user_name' => $user['id'], // 姓名
                'amount' => intval($apply['price'] * (1.0 - floatval(C('DRAWCASH_RATIO')) * 0.01) * 100),
                'desc' => '提现', // 描述
                'spbill_create_ip' => $wxtran->getServerIp()
            ); // 服务器IP地址
            
            $wxtran->transfers($data);
            
            if ($wxtran->error == '') {
                // 记录已经处理的记录
                array_push($has_process, '' . $apply['user_id']);
                
                $wxtran->log('partner_trade_no:' . $wxtran->getPartnerTradeNo());
                
                $ret_data = array(
                    'trade_no' => $wxtran->getPartnerTradeNo(),
                    'status' => 2,
                    'completed_time' => date("Y-m-d H:i:s")
                );
                
                $model->where("id=" . $apply['id'])->save($ret_data);
            } else {
                $ret_data = array(
                    'return_msg' => $wxtran->error,
                    'status' => 3,
                    'completed_time' => date("Y-m-d H:i:s")
                );
                
                $model->where("id=" . $apply['id'])->save($ret_data);
            }
        }
        
        $this->ajaxReturn(array(
            'ret' => 1,
            'msg' => '共打款:' . count($lists) . '次,共' . $total_prices . '元'
        ));
    }
    
    // 定时完成打款投注
    public function ajax_complete_drawcash_pig()
    {
        require_once SITE_PATH . "/wxpay/lib/WxTransfers.Config.php";
        require_once SITE_PATH . "/wxpay/lib/WxTransfers.Api.php";
    
        $model = M('drawcash');
    
        \WxTransfersConfig::$APPID = C('APPID');
        \WxTransfersConfig::$APPSECRET = C('APPSECRET');
        \WxTransfersConfig::$MCHID = C('MCHID');
        \WxTransfersConfig::$KEY = C('MCH_KEY');
    
        // 这里打款
        $path = \WxTransfersConfig::getRealPath(); // 证书文件路径
        $config['wxappid'] = \WxTransfersConfig::$APPID;
        $config['mch_id'] = \WxTransfersConfig::$MCHID;
        $config['key'] = \WxTransfersConfig::$KEY;
        $config['PARTNERKEY'] = \WxTransfersConfig::$KEY;
        $config['api_cert'] = $path . \WxTransfersConfig::SSLCERT_PATH;
        $config['api_key'] = $path . \WxTransfersConfig::SSLKEY_PATH;
        $config['rootca'] = $path . \WxTransfersConfig::SSLROOTCA;
    
        $wxtran = new \WxTransfers($config);
    
        $wxtran->setLogFile('./logs/transfers_pig.log'); // 日志地址
    
        $user_db = M('users');
    
        $lists = $model->alias('a')
        ->join('__LOTTERY__ b on b.no=a.params', 'left')
        ->where("a.status in (0,1) and a.openid<>'' and a.type=1")
        ->field('a.*,b.status as lottery_status')
        ->select();
    
        $has_process = array();
        
        $lottery_db = M('lottery');
    
        $total_prices = 0;
        for ($i = 0; $i < count($lists); $i ++) {
            $apply = $lists[$i];
            
            if ($apply['lottery_status'] != 1)
            {
                $action_log = M('user_action_log');
                $log_data = array(
                    'user_id' => $this->user_id,
                    'action' => 'hack',
                    'params' => '该彩票已经处理完毕:' . $apply['params'],
                    'ip' => get_client_ip(0, true),
                    'create_time' => date('Y-m-d H:i:s')
                );
                $action_log->add($log_data);
                continue;
            }

            $user = $user_db->where("id=" . $apply['user_id'])->find();
    
            $total_prices += $apply['price'] * (1.0 - floatval(C('DRAWCASH_RATIO')) * 0.01) * 100;
    
            // 转账
            $data = array(
                'openid' => $apply['openid'],
                'check_name' => 'NO_CHECK', // 是否验证真实姓名参数
                're_user_name' => $user['id'], // 姓名
                'amount' => intval($apply['price'] * (1.0 - floatval(C('DRAWCASH_RATIO')) * 0.01) * 100),
                'desc' => '提现', // 描述
                'spbill_create_ip' => $wxtran->getServerIp()
            ); // 服务器IP地址
    
            $wxtran->transfers($data);
    
            if ($wxtran->error == '') {
                // 记录已经处理的记录
                array_push($has_process, '' . $apply['user_id']);
    
                $wxtran->log('partner_trade_no:' . $wxtran->getPartnerTradeNo() . ',id:' . $apply['id']);
    
                $ret_data = array(
                    'trade_no' => $wxtran->getPaymentNo(),
                    'status' => 2,
                    'completed_time' => date("Y-m-d H:i:s")
                );
    
                $model->where("id=" . $apply['id'])->save($ret_data);
                
                // 这里生产彩票数据
                $wxtran->log('处理订单尾号数据:' . $apply['params'] . ',号码:' . $wxtran->getPaymentNo());
                
                    $lottery = $lottery_db->where("no='" . $apply['params'] . "'")->find();
                    if ($lottery['status'] == 1)
                    {
                        $data = array(
                            //'number' => substr($wxtran->getPaymentNo(), - 9),
                            'number' => '' . $wxtran->getPaymentNo(),
                            'status' => 1
                        );
                    
                        $lottery_db->where("id=" . $lottery['id'])->save($data);
                        
                        $wxtran->log('处理订单尾号数据:' . $apply['params'] . ',完毕');
                    }
            } else {
                $ret_data = array(
                    'return_msg' => $wxtran->error,
                    'status' => 3,
                    'completed_time' => date("Y-m-d H:i:s")
                );
    
                $model->where("id=" . $apply['id'])->save($ret_data);
            }
        }
    
        $this->ajaxReturn(array(
            'ret' => 1,
            'msg' => '共打款:' . count($lists) . '次,共' . $total_prices . '元'
        ));
    }
    
    function get_msg($url){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_TIMEOUT,5);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        $data = curl_exec($ch);
        if($data){
            curl_close($ch);
            return $data;
        }else {
            $error = curl_errno($ch);
            curl_close($ch);
            return false;
        }
    }
    
    public function ajax_check_hostname($id) {
        
        $this->ajaxReturn(array(
            'ret' => - 1,
            'msg' => '停止检测'
        ));
        return;
        
        include_once 'wxpay/DomainDetech.php';
        $db = M('hostnames');
        $host = $db->where('id=' . $id)->find();
        
        $detech_url = $host['hostname']; //填写你要检测的域
        
        $domain_obj = new \DomainDetech('0', '1');
        
        $cret = $domain_obj->http_request('http://' . $detech_url . '/check_hostname.txt', null, 10);
        
        if ($cret != 'ok')
        {
            $data = array(
                'update_time' => date('Y-m-d H:i:s'),
                'status' => 2
            );
            $db->where('id=' . $id)->save($data);
        
            $this->ajaxReturn(array(
                'ret' => - 1,
                'msg' => '域名配置错误'
            ));            
            return;
        }        
    
        $api_url = "http://vip.weixin139.com/weixin/wx_domain.php?user=735999&key=7e477bbdb11a01199ea96ed41c7dda90&domain=".$detech_url;
        $content = $this->get_msg($api_url);
        $data = json_decode($content,true);
        
        if ($data['status'] == 0)
        {
            $data = array(
                'update_time' => date('Y-m-d H:i:s'),
                'status' => 1
            );
            $db->where('id=' . $id)->save($data);
    
            $this->ajaxReturn(array(
                'ret' => - 1,
                'msg' => '域名检测正常'
            ));            
        }
        else if ($data['status']==2)
        {
            $data = array(
                'update_time' => date('Y-m-d H:i:s'),
                'status' => -1
            );
            $db->where('id=' . $id)->save($data);

            $this->ajaxReturn(array(
                'ret' => - 1,
                'msg' => '域名被封'
            ));            
        }
        else
        {
            $this->ajaxReturn(array(
                'ret' => - 1,
                'msg' => "API检测其他错误:" . json_encode($data)
            ));            
        }
    }

    public function ajax_check_hostname2($id)
    {
        include_once 'wxpay/DomainDetech.php';
        $app_id = 'o3KnIv3tEWIfo7S_Ll6axTAqwraU';
        $app_secret = 'aa325103'; // 填写你设置的密码
        
        $domain_obj = new \DomainDetech($app_id, $app_secret);
        
        $db = M('hostnames');
        $hosts = $db->where('status=1')->select();
        
        for ($i = 0; $i < count($hosts); $i ++) {
            $host = $hosts[$i];
            
            // 单个域名查询
            $detech_url = 'http://' . $host['hostname']; // 填写你要检测的域
            
            $cret = $domain_obj->http_request($detech_url . '/check_hostname.txt', null, 10);
            
            if ($cret != 'ok') {
                $data = array(
                    'update_time' => date('Y-m-d H:i:s'),
                    'status' => 2
                );
                $db->where('id=' . $host['id'])->save($data);
                continue;
            }
            
            $rs = $domain_obj->run($detech_url);
            
            $ret = $rs; // json_decode($rs, true);
            
            if ($ret['status'] == 401) {
                echo "API授权已过期";
                return;
            } else 
                if ($ret['status'] == 1) {
                    $data = array(
                        'update_time' => date('Y-m-d H:i:s'),
                        'status' => 1
                    );
                    $db->where('id=' . $host['id'])->save($data);
                } else 
                    if ($ret['status'] == - 1) {
                        $data = array(
                            'update_time' => date('Y-m-d H:i:s'),
                            'status' => - 1
                        );
                        $db->where('id=' . $host['id'])->save($data);
                    } else {
                        echo "域名检测[$detech_url]其他错误:" . $ret['status'];
                        
                        return;
                    }
        }
    }
}
