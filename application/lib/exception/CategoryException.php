<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/2/8
 * Time: 0:52
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $code = 404;

    public $msg = '指定类目不存在，请检查参数';

    public $errorCode = 50000;
}