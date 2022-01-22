<?php

namespace Alex\ManagementSystem\classes;

session_start();

use mysqli;

class UserClasses
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

    public function getAllUsers(): array
    {

        $users = array();

        $sql = "SELECT * FROM users ORDER BY id ASC";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            foreach ($result as $user) {
                array_push($users, $user);
            }
        }

        return $users;
    }

    public function getUserById(int $id): array
    {
        $user = array();

        $sql = "SELECT * FROM users WHERE id = '$id' ORDER BY id ASC";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
        }

        return $user;
    }

    public function updateUser($name,$last_name,$img_name,$id)
    {
        $user_by_id = new UserClasses();
        
        if ($img_name == "default.png"){

            $sql = "UPDATE `users` SET `name` = '$name',`l_name` = '$last_name', `updated_at` = NOW() WHERE `id` = '$id'";
            $result = $this->conn->query($sql);

            $user_by_id = $this->getUserById($id);

            if($user_by_id['name'] == $name and $user_by_id['l_name'] == $last_name){
                
                $_SESSION['logged_user_info']['name'] = $name;
                $_SESSION['logged_user_info']['l_name'] = $last_name;

                $_SESSION['profile_updated_msg'] = "Personal information updated with sucess";
                header("Location: my_profile.php");
            }else{
                $_SESSION['error_msg'] = "That information is already in the database";
                header("Location: my_profile.php");
            }
        }else{

            $sql = "UPDATE `users` SET `name` = '$name',`l_name` = '$last_name',`image` = '$img_name', `updated_at` = NOW() WHERE `id` = '$id'";
            $result = $this->conn->query($sql);

            $_SESSION['logged_user_info']['name'] = $name;
            $_SESSION['logged_user_info']['l_name'] = $last_name;
            $_SESSION['logged_user_info']['image'] = $img_name;

            $_SESSION['profile_updated_msg'] = "Personal information updated with sucess";
            header("Location: my_profile.php");
        }
    }
}