<?php
/**
 * User: 侯光龙
 * FileName: 多进程模拟curl操作
 * Date: 2019/3/26
 * Time: 0:42
 */
echo 'process_start_time'.date('Y-m-d H:i:s').PHP_EOL;
$url_arr = [
    'https://www.baidu.com/',
    'http://news.baidu.com/',
    'http://image.baidu.com/',
    'https://zhidao.baidu.com/',
    'https://tieba.baidu.com/index.html',
    'https://wenku.baidu.com/'
];
$process_obj = [];

for($i = 0;$i<count($url_arr);$i++){
    $process = new swoole_process(function (swoole_process $worker) use ($process_obj,$i,$url_arr){
        $content = CurlData($url_arr[$i]);
        echo $content;
    },true);
    $pid = $process->start();
    $process_obj[$pid] = $process;
}

/**
 * 模拟curl请求
 */

function CurlData($url)
{
    sleep(1);
    return $url.PHP_EOL;
}
echo 'process_end_time'.date('Y-m-d H:i:s').PHP_EOL;