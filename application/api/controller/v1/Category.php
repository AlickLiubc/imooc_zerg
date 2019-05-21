<?php
/**
 * Created by PhpStorm.
 * User: liubc
 * Date: 2019/2/3
 * Time: 21:49
 */

namespace app\api\controller\v1;

use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;

class Category
{
    public function getAllCategories()
    {
        $categories = CategoryModel::all([], 'img');

        if ( $categories->isEmpty() ) {
            throw new CategoryException();
        }

        return $categories;
    }
}