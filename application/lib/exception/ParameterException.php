<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/2/8
 * Time: 0:52
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 400;

    public $msg = '参数错误';

    public $errorCode = 10000;
}