<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/2/7
 * Time: 1:36
 */

namespace app\api\model;

class Product extends BaseModel
{
    protected $hidden = [
        'delete_time', 'category_id', 'from',
        'create_time', 'update_time', 'pivot'
    ];

    public function imgs()
    {
        return $this->hasMany('ProductImage', 'product_id', 'id');
    }

    public function properties()
    {
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }

    public function getMainImgUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }

    public static function getMostRecent($count)
    {
        $products = self::limit($count)
                        ->order('create_time desc')
                        ->select();

        return $products;
    }

    public static function getProductsByCategoryId($categoryId)
    {
        $products = self::where('category_id', '=', $categoryId)->select();

        return $products;
    }

    public static function getProductDetail($id)
    {
        // Query
        $product = self::with([
                'imgs' => function ($query) {
                    $query->with(['imgUrl'])
                         ->order('order', 'asc');
                }
            ])
            ->with(['properties'])
            ->find($id);

        return $product;
    }
}