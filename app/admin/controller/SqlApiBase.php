<?php

namespace app\admin\controller;

use think\facade\Config;
use think\facade\Lang;
use think\facade\Request;
use think\Response;

abstract class SqlApiBase
{
  protected $pageSize;
  public function __construct()
  {
    //获取每分页条数
    $this->pageSize = (int)Request::param('page_size', Config::get('app.page_size'));
  }

  protected function create($data, string $msg = '', int $code = 200, string $type = 'json'): Response
  {
    //标准api结构生成

    $result = [
      //状态码
      'code' => $code,
      //消息
      'msg' => $msg,
      //数据
      'data' => $data
    ];
    //返回api接口
    return Response::create($result, $type);
  }
  public function __call($name, $arguments)
  /***
  * @ description:方法不存在的错误
  */
  {
    return $this->create([], Lang::get('code.Not Found'), 404);
  }
}
