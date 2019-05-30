<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/5/30
 * Time: 22:41
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = [ 'user_id', 'delete_time', 'update_time' ];
}