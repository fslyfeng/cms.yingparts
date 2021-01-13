<?php

/**
 * +----------------------------------------------------------------------
 * | Sql产品导入Mysql中
 * +----------------------------------------------------------------------
 */

namespace app\admin\controller;
//加载多语言
use think\facade\Lang;

class Sql extends SqlApiBase
{
  public function index($page = 1, $table_name = 'spxx')
  {
    //获取数据列表
    $data = \think\facade\Db::connect('read_sql')->table($table_name)->paginate([
      'list_rows' => $this->pageSize,
      'page' => $page,
    ]);;
    // 判断是否有数据
    if ($data->isEmpty()) {
      return $this->create(
        [],
        Lang::get('code.No Content'),
        204
      );
    } else {
      return $this->create(
        $data,
        Lang::get('code.OK'),
        200
      );
    }
  }
}
