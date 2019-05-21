<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/2/2
 * Time: 16:06
 */

namespace app\sample\controller;

use think\Request;

class Test
{
    // http://z.cn/sample/Test/hello
    // D:\Server\xampp\appache\conf\extra
    // httpd-vhosts.conf
    // C:\Windows\Systerm32\Drivers\etc
    public function hello(Request $request)
    {
//        $all = Request::instance()->route();
        // 助手函数
//        $all = input('get.');
        $all = $request->get();
        var_dump($all);

//        $id = Request::instance()->param('id');
//        $name = Request::instance()->param('name');
//        $age = Request::instance()->param('age');

//        echo $id;
//        echo '|';
//        echo $name;
//        echo '|';
//        echo $age;
        // return 'hello, qiyue';
    }
}