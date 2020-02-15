<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/4/17
 * Time: 15:06
 */

namespace app\api\controller\v1;

use app\api\service\UserToken;
use app\api\validate\TokenGet;
use app\api\service\Token as TokenService;
use app\lib\exception\ParameterException;

class Token
{
    public function getToken($code = '')
    {
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        $token = $ut->get();
        return [
            'token' => $token
        ];
    }

    public function verifyToken($token = '')
    {
        if (!$token) {
            throw new ParameterException(['msg' => 'token不允许为空']);
        }
        $isValid = TokenService::verifyToken($token);
        return [
            'isValid' => $isValid
        ];
    }
}