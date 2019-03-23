<?php
/**
 * User: websockte 基础类
 * FileName: 文件名称
 * Date: 2019/3/23
 * Time: 21:42
 */
class Ws
{
    CONST HOST = '0.0.0.0';
    CONST POST = 8812;


    protected $ws;

    public function __construct()
    {
        $this->ws = new Swoole\WebSocket\Server(self::HOST,self::POST);
        $this->ws->on('open',[$this,'on_open']);
        $this->ws->on('message',[$this,'on_message']);
        $this->ws->on('close',[$this,'on_close']);
        $this->ws->start();
    }



    public function on_open($server,$request)
    {
        echo "server: handshake success with fd-{$request->fd}";
    }

    public function on_message($server,$frame)
    {
        echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
        $this->ws->push($frame->fd,'hello my name is houguang',1,true);
    }

    public function push($message)
    {
        $this->ws->push($this->fd,$message);
    }

    public function on_close($ser,$fd)
    {
        echo "client {$fd} closed\n";
    }


}
$server = new Ws();