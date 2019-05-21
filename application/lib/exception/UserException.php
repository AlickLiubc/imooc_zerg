<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/2/8
 * Time: 0:52
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;

    public $msg = '用户不存在';

    public $errorCode = 60000;
}