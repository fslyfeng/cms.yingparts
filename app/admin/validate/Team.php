<?php
/**
 * +----------------------------------------------------------------------
 * | 团队模块验证器
* +----------------------------------------------------------------------
*DATETIME: 2020/07/10
*/
namespace app\admin\validate;

use think\Validate;

class Team extends Validate
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
        'title|标题' => [
            'require' => 'require',
        ],
        'hits|点击次数' => [
            'number' => 'number',
        ],
        'template|模板' => [
            'max' => '30',
        ],
        'area|区域' => [
            'max' => '4',
        ],
        'sex|性别' => [
            'max' => '4',
        ]
    ];
}