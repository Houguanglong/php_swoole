<?php
/**
 * User: 侯光龙
 * FileName: 文件名称
 * Date: 2019/3/24
 * Time: 15:26
 */
use Swoole\Coroutine as co;

$filename = __DIR__.'/1.txt';
co::create(function () use ($filename){
    $r = co::readFile($filename);
    if($r != false) {
        echo "filecontent:{$r}".PHP_EOL;
    }
});
var_dump($r);
echo 'start...'.PHP_EOL;
