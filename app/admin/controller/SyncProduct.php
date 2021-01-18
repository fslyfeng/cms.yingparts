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
  public function index()
  {
    //获取远程sql产品分类数据列表
    $sql_data = Db::connect('read_sql')->table('spxx')->select();
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
        //查询库存
        $stock = Db::connect('read_sql')->table('kc')->where('spid', $sql_data[$i]['id'])->find();
        $stock  ? $stock = $stock['sl'] : $stock = 0;
        //查询状态
        $sql_data[$i]['jy'] == 0 ? $status = 1 : $status = 0;
        //插入数据
        if (empty($local_data)) {
          //查询本地要是没有则写入一条新数据
          if ($sql_data[$i]['id'] != "00000000") {
            $new_local_data = [
              'id' => $sql_data[$i]['id'], //原id
              'cate_id' => $sql_data[$i]['lbid'], //原分类id
              'title' => $sql_data[$i]['spmc'], //名称
              'unit' => $sql_data[$i]['dw'], //产品单位
              'standard' => $sql_data[$i]['ggxh'], //规格型号
              'color' => $sql_data[$i]['ys'], //颜色
              'price' => $sql_data[$i]['sj'], //售价
              'bar_code' => $sql_data[$i]['sptm'], //条码
              'stock' => $stock, //库存
              'image' => '/uploads/images/no_image.png', //设置pic
              'author' => '管理员',
              'source' => '本站',
              'status' => $status, //状态
              'create_time' => time() //时间
            ];
            Db::name('product')->insert($new_local_data);

            echo '第' . $i . '条数据不存在，已写入新的数据！！';
          }
        } else {
          //查询本地已存在则查询数据是否一致
          if (
            $local_data['id'] == $sql_data[$i]['id'] //对比原id
            and $local_data['title'] == $sql_data[$i]['spmc'] //对比名称
            and $local_data['unit'] == $sql_data[$i]['dw'] //对比单位
            and $local_data['standard'] == $sql_data[$i]['ggxh'] //对比规格型号
            and $local_data['color'] == $sql_data[$i]['ys']  //对比颜色
            and $local_data['price'] == $sql_data[$i]['sj']  //对比售价
            and $local_data['bar_code'] == $sql_data[$i]['sptm']  //对比条码
            and $local_data['stock'] == $stock //对比库存
            and $local_data['status'] == $status //对比状态
          ) {
            echo '第' . $i . '条数据存在，没有同步';
          } else {
            //更新产品数据项
            Db::name('product')
              ->save([
                'id' => $sql_data[$i]['id'], //原id
                'cate_id' => $sql_data[$i]['lbid'], //原分类id
                'title' => $sql_data[$i]['spmc'], //名称
                'unit' => $sql_data[$i]['dw'], //产品单位
                'standard' => $sql_data[$i]['ggxh'], //规格型号
                'color' => $sql_data[$i]['ys'], //颜色
                'price' => $sql_data[$i]['sj'], //售价
                'bar_code' => $sql_data[$i]['sptm'], //条码
                'stock' => $stock, //库存
                'author' => '管理员',
                'source' => '本站',
                'status' => $status, //状态
                'update_time' => time()
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
