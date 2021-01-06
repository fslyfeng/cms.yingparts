<?php
/**
 * +----------------------------------------------------------------------
 * | 系统设置分组模型
* +----------------------------------------------------------------------
*DATETIME: 2019/05/15
*/
namespace app\common\model;

use think\facade\Request;

class SystemGroup extends Base
{
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    // 一对多获取系统设置
    public function systems()
    {
        return $this->hasMany('System', 'group_id');
    }

    // 获取列表
    public static function getList($where = array(), $pageSize, $order = ['sort', 'id'=>'desc']){
        $list = self::where($where)
            ->order($order)
            ->paginate([
                'query'     => Request::get(),
                'list_rows' => $pageSize,
            ]);
        return $list;
    }

}