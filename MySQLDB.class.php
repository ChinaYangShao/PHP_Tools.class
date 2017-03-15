<?php
/*
这是一个对MySQL数据库操作的类;

*** 还需要后期继续完善 ***
*/
class MySQLDB{
	private $host;  // 数据库地址
	private $port;  // 数据库端口
	private $userName;  // 用户名
	private $password;  // 有户密码
	private $charset;  // 数据库编码
	private $dbName;  // 数据库名

	private static $obj;   //数据库链接对象 
	private $link;  // 链接结果（资源）

	// 创建数据库链接对象
	public static function getInstance($config){
		if (!isset(self::$obj)) {
			self::$obj = new self($config);
		}
		return self::$obj;
	}
	// 构造函数, 禁止new
	private function __construct($config){
		$this->host = isset($config['host']) ? $config['host'] : 'localhost';
		$this->port = isset($config['port']) ? $config['port'] : '3306';
		$this->userName = isset($config['userName']) ? $config['userName'] : 'root';
		$this->password = isset($config['password']) ? $config['password'] : '';
		$this->charset = isset($config['charset']) ? $config['charset'] : 'utf8';
		$this->dbName = isset($config['dbName']) ? $config['dbName'] : '';
		//链接数据库
		$this->config();
		// 设置数据库编码
		$this->setCharset($this->charset);
		// 选定数据库
		$this->useDb($this->dbName);
	}
	// 禁止克隆
	private function __clone(){}
	//链接数据库
	private function config(){
		if (preg_match('/^\d+$/i', $this->port)) {
			// echo "是数字";
			$this->link = mysqli_connect($this->host,$this->userName,$this->password,$this->dbName,$this->port) or die("链接数据库失败！");

		}else{
			// echo "不是数字";
			$this->link = mysqli_connect($this->host,$this->userName,$this->password,$this->dbName) or die("链接数据库失败！");
		}
		// var_dump($link);
		// return $this->link;
	}
	// 设置数据库编码
	public function setCharset($charset){
		return mysqli_set_charset($this->link,$charset);
	}
	// 选定数据库
	public function useDb($dbName){
		return mysqli_select_db($this->link,$dbName);
	}
	// 执行sql语句
	public function sql($sql){
		return mysqli_query($this->link,$sql);
	}


}

/* 以下是使用示例  */
// $config = array(
// 	'host' => 'localhost', 
// 	'port' => '', 
// 	'userName' => 'root', 
// 	'password' => '', 
// 	'charset' => 'utf8', 
// 	'dbName' => '', 
// 	);
// $link = MySQLDB::getInstance($config);
// var_dump($link);
// $link->useDb("userdb");
// $sql = "show databases;";
// $link->sql($sql);

?>