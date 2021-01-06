<?php
/**
 * +----------------------------------------------------------------------
 * | 栏目管理验证器
* +----------------------------------------------------------------------
*DATETIME: 2020/02/05
*/
namespace app\admin\validate;

use think\Validate;

class Cate extends Validate
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
        'cate_name|栏目名称' => [
            'require' => 'require',
            'max' => '255',
        ],
        'en_name|英文名称' => [
            'max' => '255',
        ],
        'cate_folder|栏目目录' => [
            'max' => '255',
            'unique' => 'cate'
        ],
        'module_id|所属模块' => [
            'require' => 'require',
        ],
        'url|外部链接' => [
            'max' => '255',
        ],
        'image|栏目图片' => [
            'max' => '255',
        ],
        'ico_image|ICO图片' => [
            'max' => '255',
        ],
        'title|SEO标题' => [
            'max' => '255',
        ],
        'keywords|SEO关键字' => [
            'max' => '255',
        ],
        'description|SEO描述' => [
            'max' => '255',
        ],
        'template_list|列表模板' => [
            'max' => '255',
        ],
        'template_show|详情模版' => [
            'max' => '255',
        ],
        'page_size|分页条数' => [
            'max' => '5',
            'number' => 'number',
        ]
    ];
}