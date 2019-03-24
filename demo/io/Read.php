<?php
/**
 * User: 侯光龙
 * FileName: 文件名称
 * Date: 2019/3/24
 * Time: 15:26
 */
use Swoole\Coroutine as co;

//文件路径
$filename = __DIR__.'/1.txt';

//创建协程
co::create(function () use ($filename){
    //通过协程方式读取文件 返回值读取成功返回内容字符串 失败则返回false
    //可使用swoole_last_error获取错误信息
    $result = co::readFile($filename);
    var_dump($result);
    echo "filecontent:{$result}".PHP_EOL;
});

echo 'start...'.PHP_EOL;
