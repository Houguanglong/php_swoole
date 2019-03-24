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
        $this->db_source = new swoole_mysql();
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
        $this->db_source->connect($this->db_config,function ($db,$result) {
            if($result == false){
                echo '数据库连接失败!';
            }
            if(empty($this->exec_sql)){
                echo 'sql语句未设置!';
            }
            $db->query($this->exec_sql,function ($link,$result){
                if($result === false){
                    echo "sql语句执行失败：{$link->error}";
                }elseif ($result === true){
                    echo "数据库受影响条数:{$link->affected_rows}";
                }else{
                    print_r($result);
                }
            });
            $db->close();
        });
        return true;
    }


}
$AysMysql = new AysMysql();
$AysMysql->set_param('exec_sql',"select * from test");
$AysMysql->execute();
echo 'start....';