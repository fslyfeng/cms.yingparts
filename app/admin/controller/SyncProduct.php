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
    $sql_data = Db::connect('read_sql')->table('spxx')->paginate([
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
        $local_data = Db::name('product')
          ->where('id', $sql_data[$i]['id'])
          ->find();
        if (empty($local_data)) {
          //查询本地要是没有则写入一条新数据
          if ($sql_data[$i]['id'] != "00000000") {
            $new_local_data = [
              'id' => $sql_data[$i]['id'], //原id
              'cate_id' => $sql_data[$i]['lbid'], //原分类id
              'title' => $sql_data[$i]['spmc'], //名称
              'author' => '管理员',
              'source' => '本站',
              'image' => '/uploads/images/no_image.png', //设置pic
              'status' => 1, //状态
              'create_time' => time() //时间
            ];
            Db::name('product')->insert($new_local_data);
            echo '第' . $i . '条数据不存在，已写入新的数据！！';
          }
        } else {
          //     //查询本地已存在则查询数据是否一致
          if (
            $local_data['title'] == $sql_data[$i]['spmc'] //对比名称
            and $local_data['id'] == $sql_data[$i]['id'] //对比原id
            //       // and $local_data['parent_id'] == $sql_data[$i]['parentid'] //对比原父id
          ) {
            echo '第' . $i . '条数据存在，没有同步';
          } else {
            //更新产品数据项
            Db::name('product')
              ->save([
                'id' => $sql_data[$i]['id'], //原id
                'cate_id' => $sql_data[$i]['lbid'], //原分类id
                'title' => $sql_data[$i]['spmc'], //名称
                'author' => '管理员',
                'source' => '本站',
                'status' => 1, //状态
                'update_time' => time(),
                'status' => 1, //状态
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
