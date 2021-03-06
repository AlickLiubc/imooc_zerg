<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/2/3
 * Time: 21:49
 */

namespace app\api\controller\v1;

use app\api\validate\IDCollection;
use app\api\model\Theme as ThemeModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ThemeException;
use think\Exception;

class Theme
{
    /**
     *
     * @url /theme?ids=id1,id2,id3...
     * @http GET
     * @return 一组theme模型
     *
     */
    public function getSimpleList($ids = '')
    {
        (new IDCollection())->goCheck();
        $ids = explode(',', $ids);
        $result = ThemeModel::with('topicImg,headImg')->select($ids);
        if ( !$result ) {
            throw new ThemeException();
        }

        return $result;
    }

    public function getComplexOne($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $theme = ThemeModel::getThemeWithProducts($id);
        if ( !$theme ) {
            throw new ThemeException();
        }

        return $theme;
    }
}