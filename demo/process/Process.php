<?php
/**
 * User: 侯光龙
 * FileName: 文件名称
 * Date: 2019/3/26
 * Time: 0:10
 */
$process = new swoole_process(function (swoole_process $pro){
    $pro->exec('/home/learn/swoole/php/bin/php',[__DIR__.'/../server/HttpServer.php']);
},false);

$pid = $process->start();
echo $pid.PHP_EOL;
$process::wait();