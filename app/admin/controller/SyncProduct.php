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

class SyncProduct extends SqlApiBase
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

      $i = 0;
      while ($i < count($sql_data)) {
        //获取本地相同id数据列表
        $local_data = Db::name('cate')
          ->where('id', $sql_data[$i]['id'])
          ->find();
        if (empty($local_data)) {
          //查询本地要是没有则写入一条新数据
          if ($sql_data[$i]['parentid'] == 0) {
            $new_local_data = [
              'id' => $sql_data[$i]['id'], //原类id
              'cate_name' => $sql_data[$i]['name'], //名称
              'en_name' => $sql_data[$i]['name'], //名称
              'parent_id' => 8, //父id
              'module_id' => 22, //所属模组
              'status' => 1, //状态
              'create_time' => time() //时间
            ];
          } else {
            $new_local_data = [
              'id' => $sql_data[$i]['id'], //原类id
              'cate_name' => $sql_data[$i]['name'], //名称
              'en_name' => $sql_data[$i]['name'], //名称
              'parent_id' => $sql_data[$i]['parentid'], //父id
              'module_id' => 22, //所属模组
              'status' => 1, //状态
              'create_time' => time() //时间
            ];
          }
          Db::name('cate')->insert($new_local_data);
          echo '第' . $i . '条数据不存在，已写入新的数据！！';
        } else {
          //查询本地已存在则查询数据是否一致
          if (
            $local_data['cate_name'] == $sql_data[$i]['name'] //对比名称
            // and $local_data['id'] == $sql_data[$i]['id'] //对比原id
            // and $local_data['parent_id'] == $sql_data[$i]['parentid'] //对比原父id
          ) {
            echo '第' . $i . '条数据存在，没有同步';
          } else {
            Db::name('cate')
              ->save([
                'id' => $sql_data[$i]['id'],
                'cate_name' => $sql_data[$i]['name'],
                'en_name' => $sql_data[$i]['name'], //名称
                'parent_id' => $sql_data[$i]['parentid'],
                'update_time' => time(),
                'module_id' => 22, //
                'status' => 1, //状态
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
