<?php
/**
 * User: 侯光龙
 * FileName: 文件名称
 * Date: 2019/3/22
 * Time: 0:27
 */

//创建server对象 监听127.0.0.1:9502端口 服务器类型为UPD
$udp = new swoole_server('127.0.0.1',9502,SWOOLE_PROCESS,SWOOLE_SOCK_UDP);

//设置服务器运行配置参数
$udp->set([
    'worker_num'=>4,    //进程数
    'max_request'=>50   //最大请求50次数结束运行
]);

/**
 * sendto方法 发送数据到客户端
 * @param int address  客户端ip
 * @param int port 端口号
 * @param string $data 文本数据
 */
//监听数据接收事件
$udp->on('Packet',function ($udp,$data,$clientInfo){
   $udp->sendto($clientInfo['address'],$clientInfo['port'],"Server ".$data);
   var_dump($clientInfo);
});

//启动服务器
$udp->start();


