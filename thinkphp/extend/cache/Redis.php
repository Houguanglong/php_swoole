<?php
namespace cache;
/**
 * User: 侯光龙
 * FileName: 文件名称
 * Date: 2019/3/30
 * Time: 21:43
 */
class Redis
{

    CONST HOST = '127.0.0.1';
    CONST PORT = 6379;

    protected static $redis_sev;

    public static $redis;


    private function __construct()
    {
        self::$redis_sev = new \Redis(self::HOST,self::PORT);
    }

    public static function getInstance()
    {
        if(empty(self::$redis)) {
            self::$redis = new self();
        }
        return self::$redis;
    }

    /**
     * 获取键值
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        return self::$redis_sev->get($name);
    }

    /**
     * 添加字符数据
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key,$value)
    {
        return self::$redis_sev->set($key,$value);
    }

    /**
     * 添加有序集合
     * @param $name
     * @param $key
     * @param $value
     */
    public function zAdd($key,$value,$score='')
    {
        return self::$redis_sev->zAdd($key,$value,$score);
    }


    public function zRem($key,$value)
    {
        return self::$redis_sev->zRem($key,$value);
    }








}