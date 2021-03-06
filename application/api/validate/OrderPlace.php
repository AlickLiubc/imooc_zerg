<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/5/25
 * Time: 10:37
 */

namespace app\api\validate;

use app\lib\exception\ParameterException;

class OrderPlace extends BaseValidate
{
    protected $rule = [
        'products' => 'checkProducts'
    ];

    protected $singleRule = [
        'product_id' => 'require|IsPositiveInteger',
        'count' => 'require|IsPositiveInteger'
    ];

    protected function checkProducts( $values )
    {
        if ( !is_array($values) ) {
            throw new ParameterException([
                'msg' => '商品参数不能为空'
            ]);
        }

        if ( empty($values) ) {
            throw new ParameterException([
                'msg' =>'商品参数不正确'
            ]);
        }

        foreach ( $values as $value ) {
            $this->checkProduct($value);
        }

        return true;
    }

    protected function checkProduct($value)
    {
        $validate = new BaseValidate($this->singleRule);
        $result = $validate->check($value);
        if ( !$result ) {
            throw new ParameterException([
                'msg' =>'商品列表参数错误'
            ]);
        }
    }
}