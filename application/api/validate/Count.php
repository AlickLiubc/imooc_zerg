<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/2/5
 * Time: 16:48
 */

namespace app\api\validate;

class Count extends BaseValidate
{
    protected $rule = [
        'count' => 'IsPositiveInteger|between:1,15'
    ];
}