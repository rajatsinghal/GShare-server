<?php
require_once 'user.php';
class Signup extends User {
    public $result;
    
    public function __construct() {
        $this->attributes = $_POST;
        if($this->verify()) {
            if($this->process()) {
                $this->sendConfirmationMail();
                $this->result = true;
            }
            else
                $this->result = false;
        }
    }
    
    public function sendConfirmationMail() {
        Mailer::lib()->confirmationMail($this);
    }
    
    public function getResult() {
        if($this->result)
            return "done!!!";
        else
            return "error!!!";
    }
    
    public function rules() {
        return array(
            "email" => array("unique","email"),
            "password" => array("password")
        );
    }
    
    public function verify() {
        $verifier = new Verification();
        $rules = $this->rules();
        //foreach($rules as $rule) {
            
        //}
        if($verifier->ruleEmail($this->attributes['email']) && $verifier->rulePassword($this->attributes['password']))
            return true;
        else
            return false;
    }
    
    public function process() {
        $db = new Db;
        $perishable_token = $this->generateToken();
        $query = "insert into user (email, password, perishable_token, last_activity_timestamp, signup_timestamp) values (".
                "'" . $this->attributes['email'] . "', " .
                "'" . $this->attributes['password'] . "', " .
                "'" . $perishable_token . "', " . time() . ", " . time() . ")";
        return $db->execute($query);
    }
    
    public function generateToken() {
        return md5(rand(1, 1000000).time());
    }
}

$sign_up = new Signup();
echo $sign_up->getResult();
?>