<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/2/5
 * Time: 16:48
 */

namespace app\api\validate;

use think\Validate;

class TestValidate extends Validate
{
    protected $rule = [
        'name' => 'require|max:10',
        'email' => 'email'
    ];
}