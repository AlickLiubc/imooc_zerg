<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/2/8
 * Time: 0:52
 */

namespace app\lib\exception;


class SuccessMessage extends BaseException
{
    public $code = 201;

    public $msg = 'ok';

    public $errorCode = 0;
}