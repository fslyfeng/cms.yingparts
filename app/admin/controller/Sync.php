<?php

/**
 * +----------------------------------------------------------------------
 * | Sql产品导入Mysql中
 * +----------------------------------------------------------------------
 */

namespace app\admin\controller;
//加载多语言
use think\facade\Lang;

class sync extends SqlApiBase
{
  public function index($page = 1, $table_name = 'lb')
  {
    //获取Sql数据列表
    $Sql_data = \think\facade\Db::connect('read_sql')->table($table_name)->paginate([
      'list_rows' => $this->pageSize,
      'page' => $page,
    ]);;
    // 判断是否有数据
    if ($Sql_data->isEmpty()) {
      return $this->create(
        [],
        Lang::get('code.No Content'),
        204
      );
    } else {
      return $this->create(
        $Sql_data,
        Lang::get('code.OK'),
        200
      );
    }
  }
}
