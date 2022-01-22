<?php

namespace Alex\ManagementSystem\classes;

session_start();

use mysqli;

class UserTypeClasses
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

    public function updateUserType(int $id_user,$id_user_type)
    {

        $sql = "UPDATE users SET FK_id_user_type = '$id_user_type' WHERE id = '$id_user'";
        $result = $this->conn->query($sql);

        $_SESSION['logged_user_info']['FK_id_user_type'] = $id_user_type;
        $_SESSION['package_updated'] = "Package upgraded with success";
        header("Location: my_wallets.php");

    }

}
