<?php
require_once '../../../vendor/autoload.php';

use Alex\ManagementSystem\classes\AuthClasses;

$user = new AuthClasses();

$name = $_POST['name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = md5($_POST['password']);

$user->verifiyAccountExists($name, $last_name, $email, $password);
