<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/4/17
 * Time: 15:19
 */

namespace app\api\model;


class User extends BaseModel
{
    public function address()
    {
        return $this->hasOne('UserAddress', 'user_id', 'id');
    }

    public static function getByOpenID($openid)
    {
        $user = self::where('openid', '=', $openid)
                    ->find();

        return $user;
    }
}