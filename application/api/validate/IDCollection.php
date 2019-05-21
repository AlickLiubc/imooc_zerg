<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/2/5
 * Time: 16:48
 */

namespace app\api\validate;

class IDCollection extends BaseValidate
{
    protected $rule = [
        'ids' => 'require|checkIDs'
    ];

    protected $message = [
        'ids' => 'ids参数必须是以逗号分隔的正整数'
    ];

    // ids = id1,id2...
    protected function checkIDs($value)
    {
        $values = explode(',', $value);
        if ( empty( $values ) ) {
            return false;
        }

        foreach ( $values as $id ) {
            if ( !$this->IsPositiveInteger( $id ) ) {
                return false;
            }
        }

        return true;
    }
}