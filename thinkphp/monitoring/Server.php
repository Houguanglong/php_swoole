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
        //shell_exec php函数执行linux shell脚本
        $result = shell_exec($shell);
        //监听结果 做相应处理 通知短信或者邮箱操作
        if($result != 1){
            echo date('Y-m-d H:i:s').'error'.PHP_EOL;
        }else{
            echo date('Y-m-d H:i:s').'success'.PHP_EOL;
        }
    }

}
swoole_timer_tick(2000,function ($timer_id){
    (new Server())->port();
});
