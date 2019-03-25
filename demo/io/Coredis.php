<?php
/**
 * User: 侯光龙
 * FileName: 文件名称
 * Date: 2019/3/25
 * Time: 23:20
 */

use Swoole\Coroutine as co;
class Coredis
{
    CONST HOST = '127.0.0.1';
    CONST POST = 3306;

    public $source_redis;


    public function __construct()
    {
        $this->source_redis = new Swoole\Coroutine\Redis();
        $result = $this->source_redis->connect(self::HOST,self::POST);
        if($result === false){
            echo 'redis连接失败!';
        }
    }


    public function get($key)
    {
        return $this->source_redis->get($key);
    }


}
co::create(function (){
   $coredis = new Coredis();
   $value = $coredis->get('name');
   var_dump($value);
});
echo 'start.......';
