<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/6/7
 * Time: 11:10
 */

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\IDMustBePositiveInt;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => [ 'only' => 'getPreOrder' ]
    ];

    public function getPreOrder($id = '')
    {
        (new IDMustBePositiveInt())->goCheck();
    }
}