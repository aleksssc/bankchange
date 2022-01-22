<?php

require_once '../../../../vendor/autoload.php';

use Alex\ManagementSystem\classes\UserClasses;

$user = new UserClasses();

$id = $_SESSION['logged_user_info']['id'];

    if($_POST['name'] != "") {

        $name = $_POST['name'];

    }elseif($_POST['name'] == ""){

        $name = $_SESSION['logged_user_info']['name'];

    }

    if($_POST['l_name'] != "") {

        $last_name = $_POST['l_name'];

    }elseif($_POST['l_name'] == ""){

        $last_name = $_SESSION['logged_user_info']['l_name'];

    }

if($_FILES['img_name']['name'] != ""){

    $img_name = $_FILES['img_name']['name'];
    
    $db_name = $_SESSION['logged_user_info']['name'];
    $db_l_name = $_SESSION['logged_user_info']['l_name'];
    
    if($name == $db_name and $last_name == $db_l_name and $img_name == "default.png"){

        $_SESSION['error_msg'] = "That information is already in the database";
        header("Location: my_profile.php");

    }else{
        
        $folder = '../../img/profile/' . $img_name;
        
        $arquive_tmp = $_FILES['img_name']['tmp_name'];
         
        move_uploaded_file($arquive_tmp, $folder);
        
        $user->updateUser($name, $last_name,$img_name,$id);

    }
}else{
    
    $db_name = $_SESSION['logged_user_info']['name'];
    $db_l_name = $_SESSION['logged_user_info']['l_name'];

    if($name == $db_name and $last_name == $db_l_name){
        
        $_SESSION['error_msg'] = "That information is already in the database";
        header("Location: my_profile.php");

    }else{
        $img_name = "default.png";
        
        $user->updateUser($name, $last_name,$img_name,$id);
    }
}

?>