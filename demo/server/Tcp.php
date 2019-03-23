<?php
/**
 * User: 侯光龙
 * FileName: 文件名称
 * Date: 2019/3/20
 * Time: 23:09
 */
//创建Server对象，监听 127.0.0.1:9501端口
$serv = new swoole_server("127.0.0.1", 9501);

//设置服务器运行配置参数
$serv->set([
    'worker_num'=>4,    //进程数
    'max_request'=>50   //最大请求50次数结束运行
]);

/**
 * @param int $fd  客户端链接用户的唯一标识
 * @param int $reactor_id 线程id号
 */
//监听连接进入事件
$serv->on('connect', function ($serv, $fd,$reactor_id) {
    echo "Client: {$fd}-{$reactor_id}-Connect.\n";
});

//监听数据接收事件
$serv->on('receive', function ($serv, $fd, $reactor_id, $data) {
    //发送数据到客户端 send(客户端链接用户的唯一标识，数据内容)
    $serv->send($fd, "{$reactor_id}-Server: ".$data);
});

//监听连接关闭事件
$serv->on('close', function ($serv, $fd) {
    echo "Client: Close.\n";
});

//启动服务器
$serv->start();