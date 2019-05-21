<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/4/27
 * Time: 22:44
 */

namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $code = 400;
    public $msg = '微信服务器接口调用失败';
    public $errorCode = 999;
}