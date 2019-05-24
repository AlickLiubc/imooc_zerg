<?php

/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/5/25
 * Time: 0:44
 */
namespace app\api\controller;

use app\api\service\Token as TokenService;
use think\Controller;

class BaseController extends Controller
{
    protected function checkPrimaryScope()
    {
        TokenService::needPrimaryScope();
    }

    protected function checkExclusiveScope()
    {
        TokenService::needExclusiveScope();
    }
}