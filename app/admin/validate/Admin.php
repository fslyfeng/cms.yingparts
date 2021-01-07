<?php
/**
 * +----------------------------------------------------------------------
 * | 管理员列表验证器
* +----------------------------------------------------------------------
*DATETIME: 2020/02/03
*/
namespace app\admin\validate;

use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        'status|状态' => [
            'require' => 'require',
            'max' => '1',
        ],
        'username|用户名' => [
            'require' => 'require',
            'max' => '25',
            'min' => '4',
        ],
        'password|密码' => [
            'max' => '50',
            'min' => '5',
        ],
        'nickname|昵称' => [
            'require' => 'require',
            'max' => '25',
            'min' => '4',
        ],
        'image|头像' => [
            'require' => 'require',
        ]
    ];
}