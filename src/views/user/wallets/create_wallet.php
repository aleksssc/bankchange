<?php
require_once '../../../../vendor/autoload.php';

use Alex\ManagementSystem\classes\WalletClasses;

$user = new WalletClasses();

$name = $_POST['name'];
$desc = $_POST['desc'];
$amount = $_POST['amount'];
$id = $_SESSION['logged_user_info']['id'];

$user->newWallet($name, $desc, $amount, $id);
?>
