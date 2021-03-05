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

    //查询本地已禁用分类父id
    $local_parent_id_status = Db::name('Cate')->where('status', 0)->column('id');
    //查询本地已禁用分类子id
    $local_child_id_status = Db::name('Cate')->where('parent_id', 'in', $local_parent_id_status)->column('id');

    //获取远程sql产品分类数据列表
    $sql_data = Db::connect('read_sql')->table('spxx')
      ->where('spmc', '<>', '优惠商品')
      // ->where('jy', 0)
      // ->where('lbid', 'notin', $local_parent_id_status)//不在parent_id
      // ->where('lbid', 'notin', $local_child_id_status)//不在cate_id
      ->select();
    if ($sql_data->isEmpty()) {
      //远程没有数据输出
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

      foreach ($sql_data as $key => $value) {
        //获取本地相同id数据列表
        $local_data = Db::name('product')
          ->where('id', $value['id'])
          ->find();
        //查询库存
        $stock = Db::connect('read_sql')->table('kc')->where('spid', $value['id'])->find();
        $stock  ? $stock = $stock['sl'] : $stock = 0;
        //查询禁用状态
        $value['jy'] == 0 ? $status = 1 : $status = 0;
        //查出所类别属父id如禁用就代换为禁用
        foreach ($local_child_id_status as $v) {
          if ($value['lbid'] == $v) {
            $status = 0;
          }
        }
        //条码如空就成为id
        if (empty($value['sptm'])) {
          $value['sptm'] = $value['id'];
        }
        //插入数据
        if (empty($local_data)) {
          //查询本地要是没有则写入一条新数据
          $new_local_data = [
            'id' => $value['id'], //原id
            'cate_id' => $value['lbid'], //原分类id
            'title' => $value['spmc'], //名称
            'unit' => $value['dw'], //产品单位
            'standard' => $value['ggxh'], //规格型号
            'color' => $value['ys'], //颜色
            'price' => $value['sj'], //售价
            'bar_code' => $value['sptm'], //条码
            'stock' => $stock, //库存
            'image' => '/uploads/images/no_image.png', //设置pic
            'author' => '管理员',
            'source' => '本站',
            'status' => $status, //状态
            'create_time' => time() //时间
          ];
          Db::name('product')->insert($new_local_data);
          echo '第' . $key . '条数据不存在，已写入新的数据！！';
        } else {
          //查询本地已存在则查询数据是否一致

          if (
            $local_data['id'] == $value['id'] //对比原id
            and $local_data['cate_id'] == $value['lbid'] //对比名称
            and $local_data['title'] == $value['spmc'] //对比名称
            and $local_data['unit'] == $value['dw'] //对比单位
            and $local_data['standard'] == $value['ggxh'] //对比规格型号
            and $local_data['color'] == $value['ys']  //对比颜色
            and $local_data['price'] == $value['sj']  //对比售价
            and $local_data['bar_code'] == $value['sptm']  //对比条码
            and $local_data['stock'] == $stock //对比库存
            and $local_data['status'] == $status //对比状态
          ) {
            echo '第' . $key . '条数据存在，没有同步';
          } else {
            //更新产品数据项
            Db::name('product')
              ->save([
                'id' => $value['id'], //原id
                'cate_id' => $value['lbid'], //原分类id
                'title' => $value['spmc'], //名称
                'unit' => $value['dw'], //产品单位
                'standard' => $value['ggxh'], //规格型号
                'color' => $value['ys'], //颜色
                'price' => $value['sj'], //售价
                'bar_code' => $value['sptm'], //条码
                'stock' => $stock, //库存
                'author' => '管理员',
                'source' => '本站',
                'status' => $status, //状态
                'update_time' => time()
              ]);
            echo '第' . $key . '条数据不相同，已写入新的数据！';
          }
        }
        echo '<br>';
      }
    }
  }
}
