<?php
/**
 * +----------------------------------------------------------------------
 * | 产品模块验证器
 * +----------------------------------------------------------------------
*/
namespace app\admin\validate;

use think\Validate;

class Product extends Validate
{
    protected $rule = [
        'sort|排序' => [
            'require' => 'require',
            'max' => '8',
            'number' => 'number',
        ],
        'status|状态' => [
            'require' => 'require',
            'max' => '1',
        ],
        'cate_id|栏目' => [
            'require' => 'require',
        ],
        'title|名称' => [
            'require' => 'require',
        ],
        'hits|点击次数' => [
            'number' => 'number',
        ],
        'template|模板' => [
            'max' => '30',
        ]
    ];
}