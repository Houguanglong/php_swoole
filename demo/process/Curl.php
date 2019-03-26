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
    //创建swoole进程
    $process = new swoole_process(function (swoole_process $worker) use ($process_obj,$i,$url_arr){
        $content = CurlData($url_arr[$i]);
        //向管道内写入数据
        $worker->write($content.PHP_EOL);
    },true);
    //执行fork系统调用，启动进程
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

foreach ($process_obj as $pro){
    //向管道读取数据
    echo $pro->read();
    //回收结束运行的子进程
    $pro::wait();
}

echo 'process_end_time'.date('Y-m-d H:i:s').PHP_EOL;