<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/5/27
 * Time: 22:48
 */

namespace app\api\service;

use app\api\model\Product;
use app\lib\exception\OrderException;

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

    private function getOrderStatus()
    {
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'pStatusArray' => []
        ];

        foreach ( $this->oProducts as $oProduct ) {
            $pStatus = $this->getProductStatus($oProduct['product_id'], $oProduct['count'], $this->products);

            if ( !$pStatus['haveStock'] ) {
                $status['pass'] = false;
            }

            $status['orderPrice'] += $pStatus['totalPrice'];

            array_push($status['pStatusArray'], $pStatus);
        }

        return $status;
    }

    private function getProductStatus($oPID, $oCount, $products)
    {
        $pIndex = -1;

        $pStatus = [
            'id' => null,
            'haveStock' => false,
            'count' => 0,
            'name' => '',
            'totalPrice' => 0
        ];

        $array_count = count($products);
        for ( $i = 0; $i < $array_count; $i++ ) {
            if ( $products[$i]['id'] == $oPID ) {
                $pIndex = $i;
            }
        }

        // 客户端传递的product_id有可能根本不存在
        if ( $pIndex == -1 ) {
            throw new OrderException([
                'msg' => 'id为' . $oPID . '的商品不存在，创建订单失败'
            ]);
        } else {
            $product = $products[$pIndex];

            $pStatus = [
                'id' => $product['id'],
                'count' => $oCount,
                'name' => $product['name'],
                'totalPrice' => $product['price'] * $oCount
            ];

            if ( $product['stock'] - $oCount >= 0 ) {
                $pStatus = [
                    'haveStock' => true
                ];
            }
        }

        return $pStatus;
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