<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/4/17
 * Time: 15:19
 */

namespace app\api\model;


class UserAddress extends BaseModel
{
    protected $hidden = [ 'id', 'user_id', 'delete_time' ];
}