<?php
/**
 * User: websockte 基础类
 * FileName: 文件名称
 * Date: 2019/3/23
 * Time: 21:42
 */
class Ws
{
    CONST HOST = '0.0.0.0'; //IP地址

    CONST POST = 8812;  //端口号

    protected $ws;  //服务器对象

    public function __construct()
    {
        $this->ws = new Swoole\WebSocket\Server(self::HOST,self::POST);
        $this->ws->on('open',[$this,'on_open']);
        $this->ws->on('message',[$this,'on_message']);
        $this->ws->on('close',[$this,'on_close']);
        $this->ws->start();
    }


    /**
     * 客户端与服务器成功建立连接 完成握手
     * @param object $server 服务器对象
     * @param object $request   Http对象
     */
    public function on_open($server,$request)
    {
        echo "server: handshake success with fd-{$request->fd}";
    }

    /**
     * 监听客户端发送数据
     * @param object $server 服务器对象
     * @param object $frame 包含客户端信息
     */
    public function on_message($server,$frame)
    {
        echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
        $server->push($frame->fd,'hello my name is houguang',1,true);
    }

    /**
     * 服务器发送数据到客户端
     * @param array $message
     * @method push 客户端连接的ID,发送的数据内容,发送数据内容的格式，默认为文本,发送结果bool
     */
    public function push($message)
    {
        $this->ws->push($this->fd,$message);
    }

    /**
     * 断开连接
     * @param object $ser 服务器对象
     * @param int $fd 客户端唯一标识
     */
    public function on_close($ser,$fd)
    {
        echo "client {$fd} closed\n";
    }


}
$server = new Ws();