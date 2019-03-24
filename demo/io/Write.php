<?php
/**
 * User: 侯光龙
 * FileName: 文件名称
 * Date: 2019/3/24
 * Time: 22:39
 */
use Swoole\Coroutine as co;

$filename = __DIR__.'/2.txt';
$content = 'houguanglong';
co::create(function () use ($filename,$content){
    $result = co::writeFile($filename,$content.PHP_EOL,FILE_APPEND);
    if($result !== false){
        echo "文件写入成功\n 写入文件：{$filename}\n文件内容：{$content}\n";
    }else{
        echo "文件写入失败\n";
    }
});
echo 'start.......';