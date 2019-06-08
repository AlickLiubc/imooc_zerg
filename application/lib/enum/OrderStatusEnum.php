<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/6/8
 * Time: 23:01
 */

namespace app\lib\enum;


class OrderStatusEnum
{
    // 待支付
    const UNPAID = 1;

    // 已支付
    const PAID = 2;

    // 已发货
    const  DELIVERED = 3;

    // 已发货，但库存不足
    const PAID_BUT_OUT_OF = 4;
}