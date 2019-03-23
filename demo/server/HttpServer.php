<?php
/**
 * User: 侯光龙
 * FileName: 文件名称
 * Date: 2019/3/23
 * Time: 13:54
 */
use Swoole\Http\Server;
//创建http_server服务器 监听127.0.0.1:8811端口
$http = new Server('0.0.0.0',8811);

//设置请求访问静态资源自动查找文件目录
//设置document_root并设置enable_static_handler为true后，
//底层收到Http请求会先判断document_root路径下是否存在此文件
//如果存在会直接发送文件内容给客户端，不再触发onRequest回调
$http->set([
    'enable_static_handler'=>true,
    'document_root'=>'/home/learn/bd_git/php_swoole/demo/data'    //配置静态文件根目录
]);

//监听http请求 $request 为http请求对象 $response为http响应对象
$http->on('request',function ($request,$response){
    print_r($request->get); //获取请求get数据
    $response->cookie('houguang','very good',120);  //设置客户端cookie
    $response->end("<h1>Http-server</h1>".$request->get['age']); //end方法响应返回内容
});

//开启httpserver服务
$http->start();