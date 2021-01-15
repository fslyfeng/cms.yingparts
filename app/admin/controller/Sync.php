<?php

/**
 * +----------------------------------------------------------------------
 * | sql产品导入Mysql中
 * +----------------------------------------------------------------------
 */

namespace app\admin\controller;

use \think\facade\Db;
//加载多语言
use think\facade\Lang;

class sync extends SqlApiBase
{
  public function index($page = 1)
  {
    //获取远程sql产品分类数据列表
    $sql_data = Db::connect('read_sql')->table('lb')->paginate([
      'list_rows' => $this->pageSize,
      'page' => $page,
    ]);
    if ($sql_data->isEmpty()) {
      //没有数据输出
      return $this->create(
        [],
        Lang::get('code.No Content'),
        204
      );
    } else {
      // return $this->create(
      //   $sql_data,
      //   Lang::get('code.OK'),
      //   200
      // );
      $i = 0;
      while ($i < count($sql_data)) {
        //获取本地相同id数据列表
        $local_data = Db::name('cate')
          ->where('lb_id', $sql_data[$i]['id'])
          ->find();
        if (empty($local_data)) {
          //查询本地要是没有则写入一条新数据
          $new_local_data = [
            'lb_id' => $sql_data[$i]['id'],
            'cate_name' => $sql_data[$i]['name'],
            'parent_id' => $sql_data[$i]['parentid'],
            'status' => 1,
            'create_time' => time()
          ];
          Db::name('cate')->insert($new_local_data);
          echo '第' . $i . '条数据不存在，已写入新的数据！！';
        } else {
          //查询本地已存在则查询数据是否一致
          if (
            $local_data['lb_id'] == $sql_data[$i]['id']
            and $local_data['cate_name'] == $sql_data[$i]['name']
            and $local_data['parent_id'] == $sql_data[$i]['parentid']
          ) {
            echo '第' . $i . '条数据存在，没有同步';
          } else {
            Db::name('cate')
              ->save([
                'lb_id' => $sql_data[$i]['id'],
                'cate_name' => $sql_data[$i]['name'],
                'parent_id' => $sql_data[$i]['parentid'],
                'update_time' => time(),
                'id' => $local_data['id']
              ]);
            echo '第' . $i . '条数据不相同，已写入新的数据！';
          }
        }
        echo '<br>';
        $i++;
      }
    }
  }
}
