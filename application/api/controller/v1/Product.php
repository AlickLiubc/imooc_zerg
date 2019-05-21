<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/2/3
 * Time: 21:49
 */

namespace app\api\controller\v1;

use app\api\validate\Count;
use app\api\model\Product as ProductModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ProductException;

class Product
{
    public function getRecent( $count = 15 )
    {
        (new Count())->goCheck();
        $products = ProductModel::getMostRecent($count);
        if ( $products->isEmpty() ) {
            throw new ProductException();
        }

        $products = $products->hidden(['summary']);

        return $products;
    }

    public function getAllInCategory($id)
    {
        (new IDMustBePositiveInt())->goCheck();

        $products = ProductModel::getProductsByCategoryId($id);

        if ( $products->isEmpty() ) {
            throw new ProductException();
        }

        return $products;
    }

    public function getOne($id)
    {
        (new IDMustBePositiveInt())->goCheck();

        $product = ProductModel::getProductDetail($id);

        if ( !$product ) {
            throw new ProductException();
        }

        return $product;
    }

}