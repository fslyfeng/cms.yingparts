<?php
/**
 * +----------------------------------------------------------------------
 * | 系统设置分组验证器
* +----------------------------------------------------------------------
*DATETIME: 2019/05/15
*/
namespace app\admin\validate;

use think\Validate;

class SystemGroup extends Validate
{
    protected $rule = [
        'name|分组名称' => [
            'require' => 'require',
            'max'     => '255',
            'unique'  => 'system_group',
        ],
        'sort|排序' => [
            'require' => 'require',
            'number'  => 'number',
        ],
    ];
}