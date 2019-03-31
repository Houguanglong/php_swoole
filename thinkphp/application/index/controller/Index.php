<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        print_r(request()->get());
        return 'hello world';
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }

    public function push()
    {
        $server = $_POST['http_server'];
        $data = [
            'method'=>'push_live',
            'data'=>''
        ];
        return $server->task($data);
    }


    public function push_comment()
    {
        $server = $_POST['http_server'];
        $content = $_GET['comment'];
        $data = [
            'method'=>'push_comment',
            'data'=>$content
        ];
        return $server->task($data);
    }
}
