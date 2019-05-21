<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/5/12
 * Time: 21:14
 */

namespace app\api\model;


class ProductImage extends  BaseModel
{
    protected $hidden = ['img_id', 'delete_time', 'product_id'];

    public function imgUrl()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}