<?php

/**
 * +----------------------------------------------------------------------
 * | Category验证器
 * +----------------------------------------------------------------------
 */

namespace app\admin\validate;

use think\Validate;

class Category extends Validate
{
    protected $rule = [
        'template|模板' => [
            'max' => '30',
        ],
        'description|描述' => [
            'max' => '255',
        ],
        'status|状态' => [
            'require' => 'require',
            'max' => '1',
        ],
        'cate_id|栏目' => [
            'require' => 'require',
        ],
        'hits|点击次数' => [
            'number' => 'number',
        ],
        'sort|排序' => [
            'require' => 'require',
            'max' => '8',
            'number' => 'number',
        ]
    ];
}
