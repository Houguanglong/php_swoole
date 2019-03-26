<?php
/**
 * User: 侯光龙
 * FileName: swoole共享内存 多进程/多线程数据共享
 * Date: 2019/3/26
 * Time: 23:20
 */
use Swoole\Table;
//class My_Table
//{
//
//    protected static $table;
//
//    public static $column_type = [
//        Table::TYPE_INT,   //默认为4个字节，可以设置1，2，4，8一共4种长度
//        Table::TYPE_STRING,    //设置后，设置的字符串不能超过此长度
//        Table::TYPE_FLOAT  //会占用8个字节的内存
//    ];
//
//    private function __construct()
//    {
//        //实例化内存表 指定表格的最大行数 1024
//        self::$table = new TB(1024);
//    }
//
//    public static function getInstance()
//    {
//        if(empty(self::$table)){
//            self::$table = new self();
//        }
//        return self::$table;
//    }
//
//    /**
//     * 创建内存表字段
//     * @param string $name  字段名称
//     * @param int $type 字段类型 (使用内存表类型常量)
//     * @param int $size 字段大小 (字符串字段的最大长度,字符串必须指定长度)
//     */
//    public function column(string $name,int $type,int $size=0)
//    {
//        if(!in_array($type,self::$column_type)){
//            echo '字段类型错误!';
//        }
//        return self::$table->column($name,$type,$size);
//    }
//
//    /**
//     * 创建内存表
//     */
//    public function create()
//    {
//        return self::$table->create();
//    }
//
//    /**
//     * 设置行的数据
//     * @param string $key 数据的键名
//     * @param array $value 数据的值
//     */
//    public function set(string $key,array $value)
//    {
//        return self::$table->set($key,$value);
//    }
//
//    /**
//     * 获取数据
//     * @param string $key 数据的键
//     */
//    public function get(string $key)
//    {
//        return self::$table->get($key);
//    }
//
//}

$table = new \Swoole\Table(1024);
$table->column('id',Table::TYPE_INT,4);
$table->column('name',Table::TYPE_STRING,20);
$table->column('age',Table::TYPE_INT,3);
$table->create();
$table->set('hgl',['id'=>1,'name'=>'houguang','age'=>21]);
$value = $table->get('hgl');
print_r($value);