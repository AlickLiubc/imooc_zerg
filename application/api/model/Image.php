<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/2/7
 * Time: 1:36
 */

namespace app\api\model;

use think\Model;

class Image extends BaseModel
{
    protected $hidden = [
        'id', 'from', 'delete_time', 'update_time'
    ];

    public function getUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }
}