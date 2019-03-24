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
    $result = co::writeFile($filename,$content,FILE_APPEND);
    if($result !== false){
        echo "文件写入成功 写入文件：{$filename}-文件内容：{$content}";
    }else{
        echo "文件写入失败";
    }
});
echo 'start.......';