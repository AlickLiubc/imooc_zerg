<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/5/27
 * Time: 22:48
 */

namespace app\api\service;

use app\api\model\Product;

class Order
{
    // 真实的商品信息（包括库存量）
    protected $products;

    // 订单的商品列表，也就是客户端传递过来的products参数
    protected $oProducts;

    protected $uid;

    public function place($oProducts, $uid)
    {
        // oProducts和products做对比
        // products从数据库中查询出来
        $this->oProducts = $oProducts;
        $this->uid = $uid;
        $this->products = $this->getProductsByOrder($oProducts);
    }

    // 根据订单信息查找真实的商品信息
    private function getProductsByOrder($oProducts)
    {
//        foreach ( $oProducts as $oProduct ) {
//            // 循环查询数据库
//        }

        $oPIDS = [];

        foreach ( $oProducts as $item ) {
            array_push($oPIDS, $item['product_id']);
        }

        $products = Product::all($oPIDS)
                        ->visible(['id', 'name', 'price', 'stock', 'main_img_url'])
                        ->toArray();

        return $products;
    }


}