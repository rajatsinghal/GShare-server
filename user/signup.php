<?php
require_once 'user.php';
class Signup extends User {
    public $request_data = array(
        'email' => '',
        'password' => ''
    );
    
    public function __construct() {
        $this->request_data['email'] = $_POST['email'];
        $this->request_data['password'] = $_POST['password'];
        if($this->verify()) {
            if($this->process())
                echo "done!!!";
            else
                echo "error!!!";
        }
    }
    
    public function verify() {
        $verifier = new Verification();
        if($verifier->ruleEmail($this->request_data['email']) && $verifier->rulePassword($this->request_data['password']))
            return true;
        else
            return false;
    }
    
    public function process() {
        $db = new Db;
        $perishable_token = $this->generateToken();
        $query = "insert into user (email, password, perishable_token, last_activity_timestamp, signup_timestamp) values (".
                "'" . $this->request_data['email'] . "', " .
                "'" . $this->request_data['password'] . "', " .
                "'" . $perishable_token . "', " . time() . ", " . time() . ")";
        return $db->execute($query);
    }
    
    public function generateToken() {
        return md5(rand(1, 1000000).time());
    }
}

$sign_up = new Signup();
?>