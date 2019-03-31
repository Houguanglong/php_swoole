<?php
/**
 * User: 侯光龙
 * FileName: 文件名称
 * Date: 2019/3/31
 * Time: 0:59
 */
include __DIR__.'/Server.php';
class Tcp extends Server
{
    CONST HOST = '127.0.0.1';
    CONST POST = 9501;

    public function __construct($host=self::HOST,$port=self::POST)
    {
        $this->server = new swoole_server($host,$port);
        $this->set([
            'worker_num'=>4,    //进程数
            'max_request'=>50   //最大请求50次数结束运行
        ]);
        //$this->server->on('WorkerStart',[$this,'onWorkerStart']);
        $this->server->on('connect',[$this,'onConnect']);
        $this->server->on('receive',[$this,'onReceive']);
        parent::__construct();
        $this->server->on('close',[$this,'onClose']);
        $this->server->start();
    }

    public function onWorkerStart($sev,$worker_id)
    {

    }

    /**
     * 监听连接进入事件
     * @param $serv
     * @param $fd
     * @param $reactor_id
     */
    public function onConnect($serv, $fd,$reactor_id)
    {
        echo "Client: {$fd}-{$reactor_id}-Connect.\n";
    }

    /**
     * 监听数据接收事件
     * @param $serv
     * @param $fd
     * @param $reactor_id
     * @param $data
     */
    public function onReceive($serv, $fd, $reactor_id, $data)
    {
        //发送数据到客户端 send(客户端链接用户的唯一标识，数据内容)
        $serv->send($fd, "{$reactor_id}-Server: ".$data);
    }



    /**
     * onclose关闭事件 监听关闭服务事件
     * @param object $server websocket对象
     * @param int $fd 关闭连接的用户标识
     */
    public function onClose($server,$fd)
    {
        echo "client {$fd} closed\n";
    }

}
$http = new Tcp();

