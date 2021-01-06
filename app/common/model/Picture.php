<?php
/**
 * +----------------------------------------------------------------------
 * | 图片模块模型
* +----------------------------------------------------------------------
*DATETIME: 2020/07/10
*/
namespace app\common\model;

// 引入框架内置类
use think\facade\Request;

// 引入构建器
use app\common\facade\MakeBuilder;

class Picture extends Base
{
    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';


    public function cate()
    {
        return $this->belongsTo('Cate', 'cate_id');
    }public function article()
    {
        return $this->belongsTo('Article', 'guanlian');
    }

    // 获取列表
    public static function getList($where = array(), $pageSize, $order = ['sort', 'id' => 'desc'])
    {
        $list = self::where($where)
            ->order($order)
            ->paginate([
                'query'     => Request::get(),
                'list_rows' => $pageSize,
            ]);
        foreach ($list as $k => $v) {
            if ($list[$k]['cate_id']) {
                $v['cate_id'] = $v->cate->getData('cate_name');
            }if ($list[$k]['guanlian']) {
                $v['guanlian'] = $v->article->getData('title');
            }
        }
        return MakeBuilder::changeTableData($list, 'Picture');
    }

    // 导出列表
    public static function getExport($where = array(), $order = ['sort', 'id' => 'desc'])
    {
        $list = self::where($where)
            ->order($order)
            ->select();
        foreach ($list as $k => $v) {
            if ($list[$k]['cate_id']) {
                $v['cate_id'] = $v->cate->getData('cate_name');
            }if ($list[$k]['guanlian']) {
                $v['guanlian'] = $v->article->getData('title');
            }
        }
        return MakeBuilder::changeTableData($list, 'Picture');
    }

}