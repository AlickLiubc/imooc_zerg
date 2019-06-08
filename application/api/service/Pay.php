<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/6/7
 * Time: 11:32
 */

namespace app\api\service;

use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use think\Exception;
use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;


class Pay
{
    private $orderID;

    private $orderNO;

    function __construct($orderID)
    {
        if ( !$orderID ) {
            throw new Exception('订单号不得为NULL!');
        }

        $this->$orderID = $orderID;
    }

    public function pay()
    {
        // 订单号可能不存在
        // 订单号确实是存在的，但是订单号和当前用户不匹配
        // 订单号有可能已经被支付过了
        $this->checkOrderValid();
        $order = new OrderService();
        $status = $order->checkOrderStock($this->orderID);
        if ( !$status['pass'] ) {
            return $status;
        }
    }

    public function makePreOrder()
    {
        
    }

    private function checkOrderValid()
    {
        $order = OrderModel::where('id', '=', $this->orderID)
                            ->find();

        if ( !$order ) {
            throw new OrderException();
        }

        if ( !Token::isValidOperate($order->user_id) ) {
            throw new OrderException([
                'msg' => '订单与用户不匹配',
                'errorCode' => 10003
            ]);
        }

        if ( $order->status != OrderStatusEnum::UNPAID ) {
            throw new OrderException([
                'msg' => '订单已支付过了',
                'errorCode' => 80003,
                'code' => 400
            ]);
        }

        $this->orderNO = $order->order_no;

        return true;
    }
}