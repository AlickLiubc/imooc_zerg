<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/2/7
 * Time: 1:36
 */

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{
    protected function prefixImgUrl($value, $data)
    {
        $finalUrl = $value;
        if ( $data['from'] == 1 ) {
            $finalUrl = config('setting.img_prefix') . $finalUrl;
        }
        return $finalUrl;
    }
}