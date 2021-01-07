<?php
/**
 * +----------------------------------------------------------------------
 * | 广告管理验证器
* +----------------------------------------------------------------------
*DATETIME: 2020/07/10
*/
namespace app\admin\validate;

use think\Validate;

class Ad extends Validate
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
        'type_id|广告位' => [
            'require' => 'require',
        ],
        'name|广告名称' => [
            'require' => 'require',
        ],
        'description|备注' => [
            'max' => '250',
        ]
    ];
}