<?php

namespace Alex\ManagementSystem\classes;

session_start();

use mysqli;

class CriptoClasses
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

    public function selectLastTransactions($id_cripto): array
    {
        $criptos = array();

        $sql = "SELECT * FROM `transfer_logs` WHERE `desc_log` = 'Bought From' AND FK_id_cripto = '$id_cripto'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            foreach ($result as $cripto_info) {
                array_push($criptos, $cripto_info);
            }
        }

        return $criptos;
    }

    public function selectAllCripto(): array
    {
        $criptos = array();

        $sql = "SELECT * FROM `crypto_currencies`";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            foreach ($result as $cripto_info) {
                array_push($criptos, $cripto_info);
            }
        }
        return $criptos;
    }

    public function newCripto($name, $desc, $amount, $id)
    {
        $sql = "INSERT INTO `wallet`(`name_wallet`, `desc_wallet`,`amount`,`FK_id_user`) VALUES ('$name','$desc','$amount','$id')";
        $result = $this->conn->query($sql);

        $_SESSION['wallet_created'] = "New Wallet was Created";
        header("Location: my_wallets.php?created=true");
    }

    public function selectCriptoById($id_cripto): array
    {
        $criptos = array();

        $sql = "SELECT * FROM `crypto_currencies` WHERE `id_crypto` = '$id_cripto' ";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            foreach ($result as $cripto_info) {
                array_push($criptos, $cripto_info);
            }
        }

        return $criptos;
    }

    public function buyCripto($final_balance, $id_wallet, $id_cripto, $price_paid)
    {
        //Seller
        //Verifies stock available
        $sql_search_stock = "SELECT * FROM `crypto_currencies` WHERE `id_crypto`='$id_cripto'";
        $result_search_stock = $this->conn->query($sql_search_stock);

        if ($result_search_stock->num_rows > 0) {
            $stock_arr = $result_search_stock->fetch_assoc();
            $stock = $stock_arr['stock_crypto'];

            if ($stock >= 1) {
                //Selects oldest sell for buy
                $sql_search_waiting_sell = "SELECT * FROM `crypto_wallet` INNER JOIN wallet ON crypto_wallet.FK_id_wallet = wallet.id_wallet INNER JOIN crypto_currencies ON crypto_wallet.FK_id_crypto = crypto_currencies.id_crypto WHERE crypto_wallet.`waiting_sell` = 'yes' AND crypto_wallet.FK_id_crypto = '$id_cripto' AND NOT crypto_wallet.`waiting_since_date` IS NULL AND NOT wallet.id_wallet = '$_SESSION[using_wallet]' ORDER BY crypto_wallet.`waiting_since_date` ASC";
                $result_search_waiting_sell = $this->conn->query($sql_search_waiting_sell);

                if ($result_search_waiting_sell->num_rows > 0) {
                    //Get seller info
                    $last_sell_info = $result_search_waiting_sell->fetch_assoc();

                    $id_seller = $last_sell_info['FK_id_user'];
                    $id_crypto_wallet = $last_sell_info['id_crypto_wallet'];
                    $new_crypto_stock = $last_sell_info['stock_crypto'] - 1;
                    $id_seller_wallet = $last_sell_info['FK_id_wallet'];
                    $balance_seller_wallet = $last_sell_info['amount'] + $price_paid;

                    //Update seller balance
                    $sql = "UPDATE wallet SET amount = '$balance_seller_wallet' WHERE id_wallet = '$id_seller_wallet'";
                    $result = $this->conn->query($sql);
                    //Buyer
                    $sql = "UPDATE wallet SET amount = '$final_balance' WHERE id_wallet = '$id_wallet'";
                    $result = $this->conn->query($sql);

                    $sql = "UPDATE `crypto_wallet` SET `FK_id_wallet`='$id_wallet',`price_paid_crypto`='$price_paid',`data_crypto_bought`= Now(),`waiting_sell` = 'no',waiting_since_date = NULL WHERE `id_crypto_wallet` = '$id_crypto_wallet' ";
                    $result = $this->conn->query($sql);

                    //Update crypto stock
                    $sql = "UPDATE `crypto_currencies` SET `stock_crypto`='$new_crypto_stock' WHERE `id_crypto`= '$id_cripto'";
                    $result = $this->conn->query($sql);

                    //Inser Transfer Log
                    $session_user_id = $_SESSION['logged_user_info']['id'];

                    $sql = "INSERT INTO `transfer_logs`(`desc_log`, `FK_id_user_from`,`FK_id_cripto`,`price_paid_log`, `FK_id_user_to`,`date_log`) VALUES ('Bought From','$id_seller','$id_cripto','$price_paid','$session_user_id',Now())";
                    $result = $this->conn->query($sql);

                    $_SESSION['balance_wallet'] = $final_balance;
                    header("Location: cripto.php?id_cripto=" . $id_cripto . "&cripto_buyed=Successfully purchased Cryptocurrencies");
                } else {
                    header("Location: cripto.php?id_cripto=" . $id_cripto . "&no_stock_available=You are the only owner of Cryptocurrencies for sale, you cannot buy your own cryptocurrency");
                }
            } else {
                header("Location: cripto.php?id_cripto=" . $id_cripto . "&no_stock_available=No stock available");
            }
        }
    }

    public function sellCripto($id_cripto_wallet, $id_cripto, $old_stock)
    {

        $sql = "UPDATE `crypto_wallet` SET `waiting_sell`='yes',`waiting_since_date`= Now() WHERE `id_crypto_wallet` = '$id_cripto_wallet'";
        $result = $this->conn->query($sql);

        $old_stock = $old_stock + 1;

        $sql = "UPDATE `crypto_currencies` SET `stock_crypto`='$old_stock' WHERE `id_crypto`= '$id_cripto'";
        $result = $this->conn->query($sql);

        //Inser Transfer Log
        $session_user_id = $_SESSION['logged_user_info']['id'];

        $sql = "INSERT INTO `transfer_logs`(`desc_log`, `FK_id_user_from`,`FK_id_cripto`,`date_log`) VALUES ('Announced on the market','$session_user_id','$id_cripto',Now())";
        $result = $this->conn->query($sql);

        header("Location: cripto.php?id_cripto=" . $id_cripto . "&sell_pending=Your Cryptocurrency is in the market, now just wait for a buyer!");
    }

    public function selectBuysByWallet($id_wallet): array
    {
        $buys = array();

        $sql = "SELECT * FROM `crypto_wallet` INNER JOIN crypto_currencies ON crypto_wallet.FK_id_crypto = crypto_currencies.id_crypto INNER JOIN wallet ON crypto_wallet.FK_id_wallet = wallet.id_wallet INNER JOIN users ON wallet.FK_id_user = users.id WHERE crypto_wallet.`FK_id_wallet` = '$id_wallet'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $result->fetch_assoc();
            foreach ($result as $result) {
                array_push($buys, $result);
            }
        } else {
            $_SESSION['no_data_found'] = "You don't have any Cryptocurrency";
        }
        return $buys;
    }

    public function selectBuysByCryptoAndWallet($id_wallet, $id_cripto): array
    {
        $buys = array();

        $sql = "SELECT * FROM `crypto_wallet` INNER JOIN crypto_currencies ON crypto_wallet.FK_id_crypto = crypto_currencies.id_crypto INNER JOIN wallet ON crypto_wallet.FK_id_wallet = wallet.id_wallet INNER JOIN users ON wallet.FK_id_user = users.id WHERE crypto_wallet.`FK_id_wallet` = '$id_wallet' AND crypto_wallet.`FK_id_crypto` = '$id_cripto'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $result->fetch_assoc();
            foreach ($result as $result) {
                array_push($buys, $result);
            }
        } else {
            $_SESSION['no_data_found'] = "You don't have any Cryptocurrency";
        }
        return $buys;
    }

    public function selectLastBuyer($id_cripto): array
    {
        $last_buyer = array();

        $sql = "SELECT * FROM `crypto_wallet` INNER JOIN wallet ON crypto_wallet.FK_id_wallet = wallet.id_wallet INNER JOIN users ON wallet.FK_id_user = users.id WHERE crypto_wallet.FK_id_crypto = '$id_cripto' ORDER BY crypto_wallet.data_crypto_bought DESC";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            array_push($last_buyer, $result->fetch_assoc());
        }
        return $last_buyer;
    }

    public function selectLastBuyerAllCriptos(): array
    {
        $last_buyer_btc = array();
        $last_buyer_eth = array();
        $last_buyer_bnb = array();

        $sql_btc = "SELECT * FROM `crypto_wallet` INNER JOIN crypto_currencies ON crypto_wallet.FK_id_crypto = crypto_currencies.id_crypto INNER JOIN wallet ON crypto_wallet.FK_id_wallet = wallet.id_wallet INNER JOIN users ON wallet.FK_id_user = users.id WHERE crypto_currencies.symbol_crypto = 'BTC' ORDER BY crypto_wallet.data_crypto_bought DESC";
        $sql_eth = "SELECT * FROM `crypto_wallet` INNER JOIN crypto_currencies ON crypto_wallet.FK_id_crypto = crypto_currencies.id_crypto INNER JOIN wallet ON crypto_wallet.FK_id_wallet = wallet.id_wallet INNER JOIN users ON wallet.FK_id_user = users.id WHERE crypto_currencies.symbol_crypto = 'ETH' ORDER BY crypto_wallet.data_crypto_bought DESC";
        $sql_bnb = "SELECT * FROM `crypto_wallet` INNER JOIN crypto_currencies ON crypto_wallet.FK_id_crypto = crypto_currencies.id_crypto INNER JOIN wallet ON crypto_wallet.FK_id_wallet = wallet.id_wallet INNER JOIN users ON wallet.FK_id_user = users.id WHERE crypto_currencies.symbol_crypto = 'BNB' ORDER BY crypto_wallet.data_crypto_bought DESC";

        $result_btc = $this->conn->query($sql_btc);
        $result_eth = $this->conn->query($sql_eth);
        $result_bnb = $this->conn->query($sql_bnb);

        if ($result_btc->num_rows > 0) {
            array_push($last_buyer_btc, $result_btc->fetch_assoc());
        }
        if ($result_eth->num_rows > 0) {
            array_push($last_buyer_eth, $result_eth->fetch_assoc());
        }
        if ($result_bnb->num_rows > 0) {
            array_push($last_buyer_bnb, $result_bnb->fetch_assoc());
        }

        return array("btc" => $last_buyer_btc, "eth" => $last_buyer_eth, "bnb" => $last_buyer_bnb);
    }
}
