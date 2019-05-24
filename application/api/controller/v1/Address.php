<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/5/15
 * Time: 23:01
 */

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\model\User as UserModel;
use app\api\service\Token as TokenService;
use app\api\validate\AddressNew;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;
use think\Controller;

class Address extends BaseController
{
    protected $beforeActionList = [
        'checkPrimaryScope' => [ 'only' => 'createOrUpdateAddress' ]
    ];

//    protected $beforeActionList = [
//        'first' => [ 'only => 'second,third' ]
//    ];
//
//    protected function first()
//    {
//        echo 'first';
//    }
//
//    public function second()
//    {
//        echo 'second';
//    }
//
//    public function third()
//    {
//        echo 'third';
//    }

    public function createOrUpdateAddress()
    {
        $validate = new AddressNew();
        $validate->goCheck();
        // 根据Token来获取uid
        // 根据uid来查找用户数据，判断用户是否存在，如果不存在抛出异常
        // 根据用户从客户端提交而来的地址信息
        // 根据用户地址信息是否存在，从而判断是添加地址还是更新地址
        $uid = TokenService::getCurrentUid();

        $user = UserModel::get($uid);
        if ( !$user ) {
            throw new UserException();
        } else {
            $dataArray = $validate->getDataByRule(input('post.'));
            $userAddress = $user->address;
            if ( !$userAddress ) {
                $user->address()->save($dataArray);
            } else {
                $user->address->save($dataArray);
            }
        }

//        return 'success';
        return json(new SuccessMessage(), 201);
    }
}