<?php

namespace Alex\ManagementSystem\classes;

session_start();

use mysqli;

class WalletClasses
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

    public function newWallet($name, $desc, $amount, $id)
    {
        $sql = "INSERT INTO `wallet`(`name_wallet`, `desc_wallet`,`amount`,`FK_id_user`) VALUES ('$name','$desc','$amount','$id')";
        $result = $this->conn->query($sql);

        $balance = $_SESSION['logged_user_info']['balance'];
        $balance = $balance - $amount;

        $id_user = $_SESSION['logged_user_info']['id'];

        $sql = "UPDATE `users` SET `balance` = '$balance' WHERE `id`= '$id_user' ";
        $result = $this->conn->query($sql);

        $_SESSION['logged_user_info']['balance'] = $balance;
        $_SESSION['wallet_created'] = "New Wallet was Created";
        header("Location: my_wallets.php?created=true");
    }

    public function selectWalletById($id_wallet): array
    {
        $wallets = array();

        $sql = "SELECT * FROM `wallet` WHERE `id_wallet` = '$id_wallet'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            foreach ($result as $wallet) {
                array_push($wallets, $wallet);
            }
        }

        return $wallets;
    }

    public function selectWalletByIdUser(): array
    {
        $wallets = array();

        $id = $_SESSION['logged_user_info']['id'];
        $sql = "SELECT * FROM `wallet` WHERE `FK_id_user` = '$id' ";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            foreach ($result as $wallet) {
                array_push($wallets, $wallet);
            }
        }

        return $wallets;
    }

    public function updateUsingWallet($id_wallet)
    {
        $sql = "UPDATE `wallet` SET `using`= 1 WHERE `id_wallet` = '$id_wallet'";
        $result = $this->conn->query($sql);

        $sql = "SELECT * FROM `wallet` WHERE `id_wallet` = '$id_wallet'";
        $result = $this->conn->query($sql);

        $wallet_info = $result->fetch_assoc();
        $id_user = $wallet_info['FK_id_user'];

        $sql = "UPDATE `wallet` SET `using`= 0 WHERE NOT `id_wallet` = '$id_wallet' AND `FK_id_user`= '$id_user' ";
        $result = $this->conn->query($sql);

        $_SESSION['using_wallet'] = $id_wallet;
        $_SESSION['balance_wallet'] = $wallet_info['amount'];
        $_SESSION['name_wallet'] = $wallet_info['name_wallet'];

        $_SESSION['using_wallet_updated'] = "Good Job ! Now you are using the following Wallet : ";
    }
}
