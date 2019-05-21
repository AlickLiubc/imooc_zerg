<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/2/8
 * Time: 0:52
 */

namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    public $code = 403;

    public $msg = '权限不够';

    public $errorCode = 10001;
}