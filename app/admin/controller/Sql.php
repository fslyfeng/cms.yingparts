<?php

/**
 * +----------------------------------------------------------------------
 * | Sql产品导入Mysql中
 * +----------------------------------------------------------------------
 */

namespace app\admin\controller;

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
        'No Content',
        204
      );
    } else {
      return $this->create(
        $data,
        'OK',
        200
      );
    }
  }
}
