<?php
/**
 * User: 侯光龙
 * FileName: 异步mysql
 * Date: 2019/3/24
 * Time: 23:54
 */
class AysMysql
{

    public $db_source;

    protected $exec_sql = '';

    protected $exec_param = [];

    public $db_config = [
        'host' => '127.0.0.1',
        'user' => 'root',
        'password' => 'hhh123',
        'database' => 'test',
        'charset' => 'utf8',
    ];

    public function __construct()
    {
        $this->db_source = new Swoole\Coroutine\MySQL();
        $result = $this->db_source->connect($this->db_config);
        if($result === false ){
            echo '数据库连接失败!';
        }
    }

    public function set_param($key,$value)
    {
        if(is_array($key)){
            foreach ($key as $keys=>$values){
                $this->$keys = $values;
            }
        }
        $this->$key = $value;
    }


    public function execute()
    {
        if(empty($this->exec_sql)){
            echo 'sql语句未设置!';
        }
        $result = $this->db_source->query($this->exec_sql);
        if($result === false){
            echo "sql语句执行失败：{$this->exec_sql}";
        }else{
            print_r($result);
        }
    }


}
$AysMysql = new AysMysql();
$AysMysql->set_param('exec_sql',"select * from test");
$AysMysql->execute();
echo 'start....';