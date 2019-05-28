<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/5/28
 * Time: 23:38
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code = 404;

    public $msg = '订单不存在，请检查ID';

    public $errorCode = 80000;
}