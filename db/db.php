<?php
class Db{
    private $config = array(
        "server" => "localhost",
        "username" => "root",
        "password" => "root",
        "database" => "gshare");
    private $connection;
    private $db;
    
    private function connect() {
        $server = $this->config["server"];
        $username = $this->config["username"];
        $password = $this->config["password"];
        $this->connection = mysql_connect($server, $username, $password);
        $this->db = mysql_select_db($this->config["database"]);
    }
    
    public function __construct() {
        $this->connect();        
    }
    
    public function execute($query) {
        return mysql_query($query);
    }
    
    public function findAll($query) {
        $mysql_result = $this->execute($query);
        $result_data = array();
        while($row = mysql_fetch_array($mysql_result)) {
            array_push($result_data, $row);
        }
        return mysql_result;
    }
}
?>