<?php
require_once '../../../vendor/autoload.php';

use Alex\ManagementSystem\classes\AuthClasses;

$user = new AuthClasses();

$email = $_POST['email'];
$password = md5($_POST['password']);

$user->verifyLoginInfo($email, $password);