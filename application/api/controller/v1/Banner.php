<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/2/3
 * Time: 21:49
 */

namespace app\api\controller\v1;

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
        // AOP 面向切面编程
        (new IDMustBePositiveInt())->goCheck();

//        try {
            $banner = BannerModel::getBannerByID($id);
        // get,find,all,select
            if ( !$banner ) {
                throw new BannerMissException();
                // throw new Exception('服务器内部错误！');
            }

//        } catch ( Exception $ex ) {
//            $err = [
//                'code' => 10001,
//                'err_msg' => $ex->getMessage()
//            ];
//
//            return json($err, 400);
//        }

        return $banner;
        // 独立验证
        // 验证器
//        $data = [
//            'id' => $id,
//        ];

//        $validate = new Validate([
//            'name' => 'require|max:10',
//            'email' => 'email'
//        ]);

//        $validate = new IDMustBePositiveInt();
//
//        $result = $validate->batch()->check($data);
//
//        if ( $result ) {
//
//        } else {
//
//        }
    }
}