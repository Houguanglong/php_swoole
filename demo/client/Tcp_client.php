<?php
/**
 * User: 侯光龙
 * FileName: 文件名称
 * Date: 2019/3/21
 * Time: 23:33
 */

//创建swoole客户端实例 SWOOLE_SOCK_TCP常量 socket类型为TCP
$client = new swoole_client(SWOOLE_SOCK_TCP);

//连接TCP服务器
$connect = $client->connect('127.0.0.1',9501);
if(!$connect){
    echo '连接失败！';
    exit;
}

//php cli常量 STDOUT
fwrite(STDOUT,'请输入消息:');
//获取客户端输入的内容数据 STDIN可以拿到在dos下输入的内容，fgets读取这个STDIN文件句柄
$msg = trim(fgets(STDOUT));

/**
 * 发送数据给服务器
 * @param string $msg 参数为字符串，支持二进制数据
 * @return bool/返回已发送的数据长度
 */
$send_result = $client->send($msg);
if($send_result == false){
    echo '发送数据失败!';
    exit;
}

/**
 * 接收服务器数据
 * @param int $size 接收数据的缓存区最大长度，此参数不要设置过大，否则会占用较大内存
 * @param bool $waitall 是否等待所有数据到达后返回
 */
$server_msg = $client->recv($size=65535,$watill=0);
echo $server_msg;




