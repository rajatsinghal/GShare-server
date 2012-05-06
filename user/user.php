<?php
require_once '../verification/verification.php';
require_once '../db/db.php';
class User {
    public $attributes = array(
        "id" => "",
        "email" => "",
        "password" => "",
        "perishable_token" => "",
        "last_activity_timestamp" => "",
        "signup_timestamp" => ""
    );
    
    public function __construct() {
        ;
    }
}
?>