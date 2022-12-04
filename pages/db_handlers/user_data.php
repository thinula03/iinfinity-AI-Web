<?php

class User_Data{
    private $conn;
    private $servername = "localhost"; // Change the servername to IP address of the server before deployment
    private $username = "iinffbjy_user1"; // Adjust the username to the username of the server before deployment
    private $password = "DAms12/="; // Adjust the password to the password of the server before deployment
    private $database = "iinffbjy_iinfinity_ai";
    function __construct(){

    }
    function connect(){
        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//            echo "Connected successfully";
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            // Change error output later
        }
    }
    function disconnect(){
        $this->conn=null;
    }
    function make_inquiry($name, $email, $subject, $msg){
        $stmt = $this->conn->prepare("INSERT INTO Inquiry (Inq_Subject, Inq_Name, Inq_Email, Inq_Message) VALUES (:subject, :name, :email, :msg)");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":subject", $subject);
        $stmt->bindParam(":msg", $msg);
        $stmt->execute();
    }
    function request_quote($fname, $lname, $email, $phone, $msg){
        $stmt = $this->conn->prepare("INSERT INTO Quotation (Quo_first_name, Quo_last_name, Quo_email, Quo_phone, Quo_request) VALUES (:fname, :lname, :email, :phone, :msg)");
        $stmt->bindParam(":fname", $fname);
        $stmt->bindParam(":lname", $lname);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":msg", $msg);
        $stmt->execute();
    }
}
?>