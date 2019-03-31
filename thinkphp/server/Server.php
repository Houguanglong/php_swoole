<?php
/**
 * User: 侯光龙
 * FileName: 文件名称
 * Date: 2019/3/31
 * Time: 0:45
 */
abstract class Server
{
    //对象实例
    protected $server;


    //此事件在Worker进程/Task进程启动时发生
    //这里创建的对象可以在进程生命周期内使用
    abstract function onWorkerStart($sev,$worker_id);

    //初始化方法 设置默认回调事件worker/Task进程启动,启动task
    public function __construct()
    {
        $this->server->on('task',[$this,'onTask']);
        $this->server->on('finish',[$this,'onFinish']);
    }


    /**
     * 用于设置服务器运行时的各项参数
     * @param array $data
     */
    public function set($data)
    {
        $this->server->set($data);
    }

    /**
     * 执行task任务 返回执行结果到worker进程
     * @param object $sev 服务器对象
     * @param int $taskId task任务ID
     * @param int $workId task任务进程ID
     * @param array $data task任务数据
     */
    public function onTask($sev,$taskId,$workId,$data)
    {
        $task = new \app\common\lib\Task($sev);
        $method = $data['method'];
        return $task->$method($data['data']);
    }

    /**
     * 将任务处理的结果发送给worker进程
     * @param object $sev 服务器对象
     * @param int $taskId 任务的ID
     * @param $data task任务处理返回的结果内容
     */
    public function onFinish($sev,$taskId,$data)
    {
        echo "接收到Tasker进程处理任务结果,finish_task_id={$taskId}\n";
        echo "返回处理结果给woker进程:{$data}\n";
    }


}