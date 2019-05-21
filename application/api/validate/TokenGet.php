<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/4/17
 * Time: 15:09
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    protected $rule = [
        'code' => 'require|isNotEmpty'
    ];

    protected $message = [
        'code' => '没有code还想获取Token，做梦哦！'
    ];
}