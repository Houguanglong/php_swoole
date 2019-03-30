<?php
namespace app\common\lib;
/**
 * User: 侯光龙
 * FileName: 文件名称
 * Date: 2019/3/31
 * Time: 0:31
 */
class Task
{

    private $server;

    public function __construct($sev)
    {
        $this->server = $sev;
    }

    public function push_live($data)
    {
        foreach ($this->server->connections as $fd){
            if($this->server->isEstablished($fd)){
                $this->server->push($fd,'send content success');
            }
        }
    }

}