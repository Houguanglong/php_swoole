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

    protected $ws;

    public function __construct()
    {
        $this->ws = new Swoole\WebSocket\Server(self::HOST,self::POST);
        $this->ws->on('open',[$this,'on_open']);
        $this->ws->on('message',[$this,'on_message']);
        $this->push('my name is houguang');
        $this->ws->close('close',[$this,'on_close']);
        $this->ws->start();
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
        $this->ws->push($this->fd,$message);
    }

    public function on_close($ser,$fd)
    {
        echo "client {$fd} closed\n";
    }


}
$server = new Ws();