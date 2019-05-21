<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/2/7
 * Time: 1:36
 */

namespace app\api\model;

use think\Db;
use think\Exception;
use think\Model;

class Banner extends BaseModel
{
    protected $hidden = [
        'id', 'delete_time', 'update_time'
    ];

    public function items()
    {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }

    public static function getBannerByID($id)
    {
        // TODO:根据Banner ID号 获取Banner信息
//        try {
//            1 / 0;
//        } catch (Exception $ex) {
//            // TODO: 可以记录日志
//            throw $ex;
//        }
//
//        return 'this is banner info';
//        return null;

//        $result = Db::query('select * from banner_item where banner_id = ?', [ $id ]);

//        $result = Db::table('banner_item')->where('banner_id', '=', $id)->select();

//        $result = Db::table('banner_item')
//                    ->where(
//                    function($query) use ($id) {
//                        $query->where('banner_id', '=', $id);
//                    })->select();
        // ORM Object Relation Mapping
        // 模型
        // return $result;

        $banner = self::with(['items', 'items.img'])->find($id);

        return $banner;
    }
}