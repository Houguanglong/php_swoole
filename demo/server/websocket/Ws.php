<?php
/**
 * User: websockte 基础类
 * FileName: 文件名称
 * Date: 2019/3/23
 * Time: 21:42
 */
class Ws
{
    CONST HOST = '127.0.0.1';
    CONST POST = 8812;

    protected $fd;
    protected $frame;

    public static $ws;

    public function __construct()
    {
        $ser = new Swoole\WebSocket\Server(self::HOST,self::POST);
        self::$ws = $ser;
        $ser->on('open',[$this,'on_open']);
        $ser->on('message',[$this,'on_message']);
        $this->push('my name is houguang');
        $this->start();
    }



    public function on_open($server,$request)
    {
        echo "server: handshake success with fd-{$request->fd}";
    }

    public function on_message($server,$frame)
    {
        echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
        $this->fd = $frame->fd;
    }

    public function push($message)
    {
        self::$ws->push($this->fd,$message);
        $this->close();
    }


    public function close()
    {
        self::$ws->on('close',function ($ser,$fd){
            echo "client {$fd} closed\n";
        });
    }

    public function start()
    {
        self::$ws->start();
    }

}
new Ws();