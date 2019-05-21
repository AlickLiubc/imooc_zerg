<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/2/7
 * Time: 1:36
 */

namespace app\api\model;

class Category extends BaseModel
{
    protected $hidden = [
        'delete_time', 'update_time', 'topic_img_id'
    ];

    public function img()
    {
        return $this->belongsTo('image', 'topic_img_id', 'id');
    }
}