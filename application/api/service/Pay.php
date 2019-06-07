<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/6/7
 * Time: 11:32
 */

namespace app\api\service;

use think\Exception;

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

    }
}