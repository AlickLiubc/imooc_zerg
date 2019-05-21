<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/5/12
 * Time: 21:18
 */

namespace app\api\model;


class ProductProperty extends  BaseModel
{
    protected $hidden = ['id', 'delete_time', 'product_id'];

}