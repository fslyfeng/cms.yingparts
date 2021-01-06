<?php
/**
 * +----------------------------------------------------------------------
 * | 字典数据验证器
* +----------------------------------------------------------------------
*DATETIME: 2020/07/10
*/
namespace app\admin\validate;

use think\Validate;

class Dictionary extends Validate
{
    protected $rule = [
        'dict_label|字典标签' => [
            'require' => 'require',
            'max' => '100',
        ],
        'dict_value|字典键值' => [
            'require' => 'require',
        ],
        'dict_type|字典类型' => [
            'require' => 'require',
            'max' => '5',
        ],
        'remark|备注' => [
            'max' => '200',
        ],
        'sort|排序' => [
            'require' => 'require',
            'max' => '5',
            'number' => 'number',
        ],
        'status|状态' => [
            'require' => 'require',
        ]
    ];
}