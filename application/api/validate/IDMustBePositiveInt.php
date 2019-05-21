<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/2/5
 * Time: 16:48
 */

namespace app\api\validate;

class IDMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|IsPositiveInteger'
    ];

    protected $message =[
        'id' =>  'id必须是正整数'
    ];
}