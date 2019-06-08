<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/5/27
 * Time: 22:48
 */

namespace app\api\service;

use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\model\UserAddress;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;
use app\api\model\Order as OrderModel;
use think\Db;
use think\Exception;

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

        $status = $this->getOrderStatus();

        if ( !$status['pass'] ) {
            $status['orderId'] = -1;
            return $status;
        }

        // 开始创建订单
        $orderSnap = $this->snapOrder($status);

        $order = $this->createOrder($orderSnap);
        $order['status'] = true;
        return $order;
    }

    private function createOrder($snap)
    {
        Db::startTrans();
        try {
            $orderNo = self::makeOrderNo();
            $order = new OrderModel();
            $order->order_no = $orderNo;
            $order->user_id = $this->uid;
            $order->total_price = $snap['orderPrice'];
            $order->snap_img = $snap['snapImg'];
            $order->snap_name = $snap['snapName'];
            $order->total_count = $snap['totalCount'];
            $order->snap_items = json_encode($snap['pStatus']);
            $order->snap_address = $snap['snapAddress'];
            $order->save();

            $orderID = $order->id;
            $create_time = $order->create_time;
            foreach ( $this->oProducts as &$p ) {
                $p['order_id'] = $orderID;
            }

            $orderProduct = new OrderProduct();
            $orderProduct->saveAll($this->oProducts);

            Db::commit();
            return [
                'order_id' => $orderID,
                'order_no' => $orderNo,
                'create_time' => $create_time
            ];
        } catch ( Exception $ex ) {
            Db::rollback();
            throw $ex;
        }
    }

    public static function makeOrderNo()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');

        $orderSn = $yCode[intval(date('Y') - 2017)] . strtoupper(dechex(date('m'))) . date('d')
                    . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));

        return $orderSn;
    }

    // 生成订单快照
    private function snapOrder($status)
    {
        $snap = [
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatus' => [],
            'snapAddress' => null,
            'snapName' => '',
            'snapImg' => ''
        ];

        $snap['orderPrice'] = $status['orderPrice'];
        $snap['totalCount'] = $status['totalCount'];
        $snap['pStatus'] = $status['pStatusArray'];
        $snap['snapAddress'] = json_encode($this->getUserAddress());
        $snap['snapName'] = $this->products[0]['name'];
        $snap['snapImg'] = $this->products[0]['main_img_url'];

        if ( count( $this->products ) > 1 ) {
            $snap['snapName'] .= '等';
        }

        return $snap;
    }

    private function getUserAddress()
    {
        $userAddress = UserAddress::where('user_id', '=', $this->uid)
                                ->find();

        if ( !$userAddress ) {
            throw new UserException([
                'msg' => '用户地址不存在，下单失败！',
                'code' => 60001
            ]);
        }

        return $userAddress->toArray();
    }

    public function checkOrderStock($orderID)
    {
        $oProducts = OrderProduct::where('order_id', '=', $orderID)
                                ->select();

        $this->oProducts = $oProducts;
        $this->products = $this->getProductsByOrder( $oProducts );

        $status = $this->getOrderStatus();

        return $status;
    }

    private function getOrderStatus()
    {
        $status = [
            'pass' => true,
            'orderPrice' => 0,
            'totalCount' => 0,
            'pStatusArray' => []
        ];

        foreach ( $this->oProducts as $oProduct ) {
            $pStatus = $this->getProductStatus($oProduct['product_id'], $oProduct['count'], $this->products);

            if ( !$pStatus['haveStock'] ) {
                $status['pass'] = false;
            }

            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['count'];

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

            $pStatus['id'] = $product['id'];
            $pStatus['count'] = $oCount;
            $pStatus['name'] = $product['name'];
            $pStatus['totalPrice'] = $product['price'] * $oCount;

            if ( $product['stock'] - $oCount >= 0 ) {
                $pStatus['haveStock'] = true;
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