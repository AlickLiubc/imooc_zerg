<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/2/8
 * Time: 0:52
 */

namespace app\lib\exception;


class ThemeException extends BaseException
{
    public $code = 404;

    public $msg = '指定主题不存在，请检查主题ID';

    public $errorCode = 30000;
}