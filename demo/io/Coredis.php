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

    public function set($key,$value)
    {
        if(is_array($key)){
            foreach ($key as $keys=>$values){
                $this->source_redis->set($keys,$values);
            }
        }
        $this->source_redis->set($key,$value);
    }


}

$http = new Swoole\Http\Server('0.0.0.0',8811);

$http->on('request',function ($request,$response){
    $redis = new Swoole\Coroutine\Redis();
    $redis->connect('127.0.0.1',6379);
    $value = $redis->get($request->get['key']);
    $response->header('Content-Type','text/plain');
    $response->end($value);
});

$http->start();
