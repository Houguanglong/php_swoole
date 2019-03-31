<?php
namespace server;
/**
 * User: 侯光龙
 * FileName: 文件名称
 * Date: 2019/3/31
 * Time: 0:59
 */

class Http extends Server
{
    CONST HOST = '0.0.0.0';
    CONST POST = 8811;

    public function __construct($host=self::HOST,$port=self::POST)
    {
        $this->server = new Swoole\Http\Server($host,$port);
        parent::__construct();
        $this->set([
            'enable_static_handler'=>true,
            'document_root'=>'/home/learn/bd_git/php_swoole/thinkphp/public/static',    //配置静态文件根目录
            'worker_num'=>5,
        ]);
        $this->server->on('request',[$this,'onRequest']);
        $this->server->on('close',[$this,'onClose']);
        $this->server->start();
    }

    public function onWorkerStart($sev,$worker_id)
    {
        define('APP_PATH', __DIR__ . '/../application/');
        require __DIR__ . '/../thinkphp/base.php';
    }

    public function onRequest($request,$response)
    {
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
$http = new Http();

