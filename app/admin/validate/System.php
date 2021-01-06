<?php
/**
 * +----------------------------------------------------------------------
 * | 系统设置验证器
* +----------------------------------------------------------------------
*DATETIME: 2020/07/10
*/
namespace app\admin\validate;

use think\Validate;

class System extends Validate
{
    protected $rule = [
        'copyright|版权信息' => [
            'max' => '255',
        ],
        'upload_driver|上传驱动' => [
            'require' => 'require',
        ],
        'upload_file_size|文件限制' => [
            'max' => '50',
        ],
        'upload_image_size|图片限制' => [
            'max' => '50',
        ]
    ];
}