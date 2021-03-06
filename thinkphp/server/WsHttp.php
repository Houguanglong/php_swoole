<?php
/**
 * User: 侯光龙
 * FileName: 文件名称
 * Date: 2019/3/31
 * Time: 0:59
 */
include __DIR__.'/Server.php';
class WsHttp extends Server
{
    CONST HOST = '0.0.0.0';
    CONST POST = 8887;
    CONST CHART_PORT = 8812;

    public function __construct($host=self::HOST,$port=self::POST)
    {
        $this->server = new Swoole\WebSocket\Server($host,$port);
        //开放监听8812端口 未设置配置则默认使用主服务器的配置
        $this->server->listen(self::HOST,self::CHART_PORT,SWOOLE_SOCK_TCP);
        $this->set([
            'enable_static_handler'=>true,
            'document_root'=>'/home/learn/bd_git/php_swoole/thinkphp/public/static',    //配置静态文件根目录
            'worker_num'=>5,
            'task_worker_num'=>5
        ]);
        $this->server->on('start',[$this,'onStart']);
        $this->server->on('WorkerStart',[$this,'onWorkerStart']);
        $this->server->on('open',[$this,'onOpen']);
        $this->server->on('message',[$this,'onMessage']);
        $this->server->on('request',[$this,'onRequest']);
        parent::__construct();
        $this->server->on('close',[$this,'onClose']);
        $this->server->start();
    }


    public function onStart($server)
    {
        swoole_set_process_name('live_master');
    }

    public function onWorkerStart($sev,$worker_id)
    {
        define('APP_PATH', __DIR__ . '/../application/');
        require __DIR__ . '/../thinkphp/base.php';
    }

    /**
     * onopen事件 监听服务器与客户端完成连接 成功握手后执行回调函数
     * @param object $server websocket对象
     * @param object $request Http请求对象,包含客户端发来的握手请求信息
     */
    public function onOpen($server,$request)
    {
        //\app\common\lib\Redis::getInstance()->set(config('redis.live_game_key'),$request->fd);
        echo "server: handshake success with fd-{$request->fd}\n";
    }


    /**
     * onmessage事件 监听客户端发送数据接收
     * @param object $server websocket对象
     * @param array $frame swoole_websocket_frame对象，包含了客户端发来的数据帧信息
     */
    public function onMessage($server,$frame)
    {
        return $this->server->push($frame->fd,'hello my name is houguang',1,true);
    }


    /**
     * onRequest 监听http请求
     * @param object $request http请求对象
     * @param object $response http响应对象
     */
    public function onRequest($request,$response)
    {
        if($request->server['request_uri'] == '/favicon.ico'){
            $response->status(404);
            $response->end();
            return ;
        }
        $_SERVER = [];
        if(isset($request->server)){
            foreach ($request->server as $k =>$v){
                $_SERVER[strtoupper($k)] = $v;
            }
        }

        if(isset($request->header)){
            foreach ($request->header as $k =>$v){
                $_SERVER[strtoupper($k)] = $v;
            }
        }
        $_GET = [];
        if(isset($request->get)){
            foreach ($request->get as $k =>$v){
                $_GET[$k] = $v;
            }
        }

        $_POST = [];
        if(isset($request->post)){
            foreach ($request->post as $k =>$v){
                $_POST[$k] = $v;
            }
        }
        $_POST['http_server'] = $this->server;

        ob_start();
        try{
            // 执行应用并响应
            \think\Container::get('app', [APP_PATH])
                ->run()
                ->send();
        }catch (\Exception $e){
            var_dump($e->getMessage());
        }
        $content = ob_get_contents();
        ob_end_clean();
        return $response->end($content); //end方法响应返回内容
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
$http = new WsHttp();

