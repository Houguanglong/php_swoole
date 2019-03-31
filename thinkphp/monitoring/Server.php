<?php
/**
 * User: 侯光龙
 * FileName: 监控server服务
 * Date: 2019/3/31
 * Time: 17:23
 */

class Server
{
    CONST PORT = 8887;

    public function port()
    {
        $shell = 'netstat -anp 2>/dev/null | grep '.self::PORT.'| grep LISTEN | wc -l';
        $result = shell_exec($shell);
        if($result != 1){
            echo date('Y-m-d H:i:s').'error';
        }else{
            echo date('Y-m-d H:i:s').'success';
        }
    }

}
(new Server())->port();