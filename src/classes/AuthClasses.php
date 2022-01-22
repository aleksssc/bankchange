<?php

namespace Alex\ManagementSystem\classes;

session_start();

use mysqli;

class AuthClasses
{
    private $conn, $hostname = "localhost", $database = "bankchange", $user = "root", $password = "";

    function __construct()
    {
        $this->conn = new mysqli($this->hostname, $this->user, $this->password, $this->database);
    }

    function __destruct()
    {
        $this->conn->close();
    }

    //Register System
    public function verifiyAccountExists(string $name, $last_name, $email, $password)
    {
        $user_insert = new AuthClasses();

        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $this->conn->query($sql);

        $user = $result->num_rows;
        
        if($user == 0){
            $user_insert->insertUser($name, $last_name, $email, $password);
            $_SESSION['sucess_msg'] = "You have been registered successfully !";
            header("Location: login_page.php");
        }else{
            $_SESSION['invalid_info_msg'] = "Email is already in use !";
            header("Location: register_page.php");
        }
    }

    public function insertUser($name, $last_name, $email, $pass)
    {
        $sql = "INSERT INTO `users`(`name`,`l_name`, `email`, `password`, `created_at`, `updated_at`) VALUES ('$name','$last_name','$email','$pass',NOW(),NOW())";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
        }
    }

    //Login System
    public function verifyLoginInfo(string $email, $password)
    {

        $sql = "SELECT * FROM users INNER JOIN user_types ON users.FK_id_user_type = user_types.id_user_type WHERE email = '$email' and password = '$password'";
        $result = $this->conn->query($sql);

        $user = $result->num_rows;

        if($user == 1){
            $_SESSION['logged_user_info'] = $result -> fetch_assoc();
            if($_SESSION['logged_user_info']['FK_id_user_type'] == 1){

                header("Location: ../super_admin/index_page.php");

            }elseif($_SESSION['logged_user_info']['FK_id_user_type'] == 2){

                header("Location: ../admin/index_page.php");

            }elseif($_SESSION['logged_user_info']['FK_id_user_type'] == 3 or $_SESSION['logged_user_info']['FK_id_user_type'] == 4){

                header("Location: ../user/index_page.php");

            }
        }else{
            $_SESSION['invalid_login_info'] = "This user doesn't exist.";
            header("Location: login_page.php");
        }
    }
}
