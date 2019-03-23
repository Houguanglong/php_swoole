<?php
/**
 * User: 侯光龙
 * FileName: 文件名称
 * Date: 2019/3/22
 * Time: 0:27
 */
//创建swoole客户端服务 socket类型为UDP
$udp_client = new swoole_client(SWOOLE_SOCK_UDP);

//php cli常量 STDOUT
fwrite(STDOUT,'请输入消息:');
//获取客户端输入的内容数据 STDIN可以拿到在dos下输入的内容，fgets读取这个STDIN文件句柄
$msg = trim(fgets(STDOUT));

/**
 * sendto方法 发送数据到server
 * @param int address  客户端ip
 * @param int port 端口号
 * @param string $data 文本数据
 */
$send_result = $udp_client->sendto('127.0.0.1',9502,$msg);
if($send_result == false){
    echo '发送数据失败!';
    exit;
}

/**
 * 接收服务器数据
 * @param int $size 接收数据的缓存区最大长度，此参数不要设置过大，否则会占用较大内存
 * @param bool $waitall 是否等待所有数据到达后返回
 */
$server_msg = $udp_client->recv($size=65535,$watill=0);
echo $server_msg;