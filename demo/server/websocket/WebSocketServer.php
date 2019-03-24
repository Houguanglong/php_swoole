<?php
/**
 * User: 侯光龙
 * FileName: swoole-websocket
 * Date: 2019/3/23
 * Time: 20:26
 */

use Swoole\WebSocket\Server;

//创建swoole_websocket服务 监听 8812端口
$server = new Server('0.0.0.0',8812);

$server->set([
    'enable_static_handler'=>true,
    'document_root'=>'/home/learn/bd_git/php_swoole/demo/data'    //配置静态文件根目录
]);
/**
 * onopen事件 监听服务器与客户端完成连接 成功握手后执行回调函数
 * @param object $server websocket对象
 * @param object $request Http请求对象,包含客户端发来的握手请求信息
 */
//onopen事件 监听服务器与客户端完成连接 成功握手后执行回调函数
$server->on('open',function (Swoole\WebSocket\Server $server,$request){
    echo "server: handshake success with fd-{$request->fd}";
});

/**
 * onmessage事件 监听客户端发送数据接收
 * @param object $server websocket对象
 * @param array $frame swoole_websocket_frame对象，包含了客户端发来的数据帧信息
 */

// 执行回调函数 返回数据给客户端push
$server->on('message',function (Swoole\WebSocket\Server $server,$frame){
    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    //发送数据给客户端 push(客户端连接的ID,发送的数据内容,发送数据内容的格式，默认为文本,发送结果bool)
    $server->push($frame->fd,'hello my name is houguang',1,true);
});

//关闭连接
$server->on('close',function ($ser,$fd){
    echo "client {$fd} closed\n";
});

//开启服务
$server->start();

