<?php
/**
 * +----------------------------------------------------------------------
 * | 公共配置文件模型
* +----------------------------------------------------------------------
*DATETIME: 2019/03/04
*/
namespace app\common\model;

class Config extends Base
{
    //不需要使用自动时间戳
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    //protected $createTime = 'create_time';
    //protected $updateTime = 'update_time';

}