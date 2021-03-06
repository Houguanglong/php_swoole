<?php
/**
 * User: 侯光龙
 * FileName: 文件名称
 * Date: 2019/3/24
 * Time: 22:46
 */
use Swoole\Http\Server;
use Swoole\Coroutine as co;

//创建swoole http server服务器 监听端口8811
$server = new Server('0.0.0.0',8811);

//监听客户端数据 $request http请求对象 $response http响应对象
$server->on('request',function ($request,$response){
    $filename = __DIR__.'/success.log';
    $time = date('y-m-d H:i:s');
    $data = [
        'get:'=>$request->get,
        'post:'=>$request->post,
        'header:'=>$request->header,
        'time:'=>$time
    ];
    //创建协程
    co::create(function () use ($data,$filename,$time){
        //通过协程写入文件 追加形式写入
        $result = co::writeFile($filename,json_encode($data).PHP_EOL,FILE_APPEND);
        if($result !== false){
            echo "日志文件已写入 路径：{$filename}\n写入时间:{$time}";
        }else{
            echo "日志文件写入失败";
        }
    });
    $response->cookie('houguang','very good',120);  //设置客户端cookie
    $response->end("<h1>Http-server</h1>".json_encode($request->get));
});

//开启服务
$server->start();
