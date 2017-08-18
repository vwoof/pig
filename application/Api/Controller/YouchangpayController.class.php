<?php
namespace Api\Controller;

use Common\Controller\HomebaseController;

class YouchangpayController extends HomebaseController {
private $wx_pay_db = null;
    private $wx_mch_db = null;
	function _initialize(){
		parent::_initialize();
		
		$this->wx_pay_db = M('wx_pay');
		$this->wx_mch_db = M('wx_mch');
	}
	
	private function notify_order2312($order_sn, $total_fee)
	{
		require_once SITE_PATH . "/wxpay/log.php";
		
		$logHandler = new \CLogFileHandler("logs/deal_" . date('Y-m-d') . '.log');
		$log = \Log::Init($logHandler, 15);
		
		$order_db = M('recharge_order');
		
		$order = $order_db->where("id=$order_sn")->find();
		
		if (intval($order['price']) * 100 != $total_fee)
		{
			$data = array(
					'status' => 2,
					'memo' => '错误金额:' . $total_fee,
					
			);
			$this->wx_pay_db->where('from_order_sn=' . $order_sn)->save($data);
			
			\Log::DEBUG('支付失败，金额对不上');
			return;
		}
		
		$recharge_db = M('recharge_order');
		$wallet_db = M('wallet');
		
		if ($order != null && $order['status'] == 0) {
			if ($recharge_db->where("id=$order_sn")->setField('status', 1)) {
				$wallet = $wallet_db->where("user_id=" . $order['user_id'])->find();
				
				$wallet_db->where("user_id=" . $order['user_id'])->setInc("money", $order['price']);
				
				$wallet_change_db = M('wallet_change_log');
				
				$data = array(
						'user_id' => $order['user_id'],
						'object_id' => $order['id'],
						'type' => 0,
						'divide_ratio' => 0,
						'fee' => floatval($order['price']),
						'create_time' => date('Y-m-d H:i:s'),
						'memo' => '充值'
				);
				
				$wallet_change_db->add($data);
				
				\Log::DEBUG("notify_callback:$order_sn,ok");
			} else {
				\Log::DEBUG("notify_callback:$order_sn,repeat");
			}
		} else {
			\Log::DEBUG("notify_callback:$order_sn,repeat | null!");
		}
	}
        
        // 微信支付结果异步回调
        public function notify_wx() {
            require_once SITE_PATH . "/wxpay/log.php";
            
            $logHandler= new \CLogFileHandler("logs/".date('Y-m-d').'.log');
            $log = \Log::Init($logHandler, 15);

            $xml = file_get_contents('php://input');
            \Log::DEBUG('YouchangpayController:' . $xml);

            libxml_disable_entity_loader(true);
            $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
            
            if ($values['return_code'] == 'SUCCESS')
            {
                $transaction_id = $values['transaction_id'];
                $total_fee = intval($values['total_fee']);
                $out_trade_no = $values['out_trade_no'];
                
                $this->deal_order2312($out_trade_no, $transaction_id, $total_fee);
            }
            else
            {
                echo "FAIL";
            }
        }
        
        // 处理订单
        private function deal_order2312($order_sn, $transition_id, $total_fee)
        {
            \Log::DEBUG('YouchangpayController:' . $order_sn);
            
            $order = $this->wx_pay_db->where("order_sn='$order_sn'")->find();
            
            if ($order['status'] == 0)
            {
                // 判断金额是否正确
                if (intval($order['price']) != $total_fee)
                {
                    $data = array(
                        'id' => $order['id'],
                        'status' => 2,
                    	'from_source' => 'UCHANG:' .C('YOUCHANG_MCHID'),
                        'memo' => '错误金额:' . $total_fee,
                        'transition_id' => $transition_id
                    );
                    $this->wx_pay_db->where('id=' . $order['id'])->save($data);
                    
                    echo 'ok';
                    
                    return;
                }
                
                $data = array(
                    'id' => $order['id'],
                    'status' => 1,
                	'from_source' => 'UCHANG:' .C('YOUCHANG_MCHID'),
                    'transition_id' => $transition_id
                );
                $this->wx_pay_db->where('id=' . $order['id'])->save($data);
                
                $this->notify_order2312($order['from_order_sn'], $total_fee);
                
                // 调用远程接口
                
                /*
                $mch = $this->wx_mch_db->where("id=" . $order['mch'])->find();
                
                \Log::DEBUG( json_encode($mch) );
                
                $notify_url = $mch['return_url'] . '&order_sn=' . $order['from_order_sn'] . '&total_fee=' . $total_fee;
                
                $ch = curl_init();
                $timeout = 5;
                curl_setopt ($ch, CURLOPT_URL, $notify_url);
                curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                $html = curl_exec($ch);
                curl_close($ch);
                
                \Log::DEBUG('call:' . $notify_url);
                \Log::DEBUG('call:' . $html);
                
                if ($html)
                    $this->wx_pay_db->where("order_sn='$order_sn'")->setField('is_ok', 1);
                */
                echo 'OK';
            }
            else
            {
                echo "FAIL";
            }
        }
}
