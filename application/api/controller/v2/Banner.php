<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/2/3
 * Time: 21:49
 */

namespace app\api\controller\v2;

use app\api\validate\IDMustBePositiveInt;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerMissException;
use think\Exception;

class Banner
{
    /**
     * 获取指定id的banner信息
     * @url /banner/:id
     * @http GET
     * @id banner的id号
     *
     */
    public function getBanner($id)
    {
        return 'This is v2 version.';
    }
}