<?php

require_once '../../../../vendor/autoload.php';

session_start();

use Alex\ManagementSystem\classes\CriptoClasses;
use Alex\ManagementSystem\classes\HomeClasses;
use Alex\ManagementSystem\classes\WalletClasses;

global $id_cripto;
$id_cripto = $_GET['id_cripto'];
global $id_wallet;
$id_wallet = $_SESSION['using_wallet'];

if (isset($id_cripto)) {

    $cripto = new CriptoClasses();

    foreach ($cripto->selectCriptoById($id_cripto) as $cripto_info) {
        global $price_cripto;
        $name_cripto = $cripto_info['name_crypto'];
        $price_cripto = $cripto_info['price_crypto'];
        $stock = $cripto_info['stock_crypto'];
        $image_cripto = $cripto_info['image_crypto'];

        foreach ($cripto->selectLastBuyer($id_cripto) as $last_buyer_info) {

            $last_buyer_name = $last_buyer_info['name'] . " " . $last_buyer_info['l_name'];
            $last_buyer_image = $last_buyer_info['image'];

            $today_date = date("d-m-y");
            $last_buyer_info['data_crypto_bought'] = date("d-m-Y", strtotime($last_buyer_info['data_crypto_bought']));

            $last_buyer_date = ($today_date - $last_buyer_info['data_crypto_bought']);
        }
    }
}

//After buy
if (isset($_GET['buy'])) {
    $buy = new CriptoClasses();

    $id_wallet = $_SESSION['using_wallet'];
    $id_cripto = $GLOBALS['id_cripto'];
    $price_paid = $GLOBALS['price_cripto'];

    if ($_SESSION['balance_wallet'] < $price_paid) {

        $_SESSION['not_enough_balance'] = "Not enough balance !";
    } elseif ($_SESSION['balance_wallet'] >= $price_paid) {
        $final_balance = $_SESSION['balance_wallet'] - $price_paid;
        $buy->buyCripto($final_balance, $id_wallet, $id_cripto, $price_paid);
    }
}

//After sale
if (isset($_GET['sell'])) {
    if (isset($_GET['id_cripto_wallet'])) {
        $buy = new CriptoClasses();
        $id_cripto_wallet = $_GET['id_cripto_wallet'];
        $buy->sellCripto($id_cripto_wallet, $id_cripto, $_GET['old_stock']);
    }
}

function sign_out()
{
    session_destroy();
    header("Location: ../../../../index.php");
}

if (isset($_GET['logged_out'])) {
    sign_out();
}

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../../img/bankchange_logo.png" />
    <title> | Currency: <?php echo $name_cripto; ?></title>
</head>

<script>
    function sucess_msg() {
        var sucess = document.getElementById("sucess");
        sucess.style.display = "block";
    }

    function error_msg() {
        var error_msg = document.getElementById("error");
        error_msg.style.display = "block";
    }

    function sell_msg() {
        var sell_msg = document.getElementById("sell_pending");
        sell_msg.style.display = "block";
    }


    function show_popup_qtd() {
        var popup_qtd = document.getElementById("popup_qtd");
        popup_qtd.style.display = "block";
    }

    function hide_popup_qtd() {
        var popup_qtd = document.getElementById("popup_qtd");
        popup_qtd.style.display = "none";
    }


    function show_popup_sell() {
        var popup_qtd = document.getElementById("popup_sell");
        popup_qtd.style.display = "block";
    }

    function hide_popup_sell() {
        var popup_sell = document.getElementById("popup_sell");
        popup_sell.style.display = "none";
    }
</script>

<body>
    <!-- PopUp buy-->
    <div class="modal-content rounded-6 shadow" id="popup_qtd" style="position: absolute;
        z-index: 1;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 30%;
        border-radius: 12px;
        margin: auto;
        width: 30%;
        padding: 10px;
        border: none;
        display: none;">

        <form method="POST" action="buy_cripto.php">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title">Confirm Purchase </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="hide_popup_qtd()"></button>
            </div>
            <div class="modal-footer flex-column border-top-0">
                <button type="submit" name="btt_value" class="btn btn-lg btn-primary w-100 mx-0 mb-2" value="<?php echo $id_cripto; ?>">Confirm</button>
            </div>
        </form>
    </div>

    <!-- PopUp Sell-->
    <div class="modal-content rounded-6 shadow" id="popup_sell" style="position: absolute;
        z-index: 1;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 30%;
        border-radius: 12px;
        margin: auto;
        width: 40%;
        padding: 10px;
        border: none;
        display: none;">

        <div class="modal-header border-bottom-0">
            <h5 class="modal-title">Confirm Purchase</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="hide_popup_sell()"></button>
        </div>
        <?php if (isset($id_wallet)) {
            $wallet = new CriptoClasses();
            foreach ($wallet->selectBuysByCryptoAndWallet($id_wallet, $id_cripto) as $wallet) {
                $viewing_wallet_name = $wallet['name_wallet'];
                $today_date = date("d-m-y");
                $wallet['data_crypto_bought'] = date("d-m-Y", strtotime($wallet['data_crypto_bought']));

                $buyed_time_ago = ($today_date - $wallet['data_crypto_bought']);
        ?>
                <form action="sell_cripto.php" method="POST">
                    <a class="list-group-item list-group-item-action d-flex gap-3 py-3">
                        <img src="../../../img/criptos/<?php echo $wallet['image_crypto']; ?>" alt="twbs" width="32" height="32" class="rounded-circle flex-shrink-0">
                        <div class="d-flex gap-2 w-100 justify-content-between">
                            <div>
                                <h6 class="mb-0"><?php echo $wallet['name_crypto']; ?></h6>
                                <p class="mb-0 opacity-75">
                                    <?php
                                    $percentage = ($wallet['price_crypto'] - $wallet['price_paid_crypto']) / $wallet['price_paid_crypto'] * 100;
                                    if ($percentage >= 0) {
                                        $color = "green";
                                        $percentage = "+" . number_format($percentage, 2);
                                    } else {
                                        $color = "red";
                                        $percentage = number_format($percentage, 2);
                                    }
                                    echo $wallet['symbol_crypto'] . " Price : " . $wallet['price_crypto'] . " € | You Paid : " . $wallet['price_paid_crypto'] . " € <span style='color:" . $color . "'> (" . $percentage . "%)</span>"; ?>
                                </p>
                            </div>
                            <input type="hidden" name="id_cripto" value="<?php echo $id_cripto; ?>">
                            <input type="hidden" name="stock" value="<?php echo $wallet['stock_crypto']; ?>">

                            <?php if ($wallet['waiting_sell'] == 'yes') { ?>
                                <small class="opacity-50 text-nowrap">Pending sale process</small>
                            <?php } else { ?>
                                <button type="submit" name="id_crypto_wallet" class="btn btn-danger" value="<?php echo $wallet['id_crypto_wallet']; ?>">Sell</button>
                            <?php } ?>
                            <small class="opacity-50 text-nowrap"><?php echo $buyed_time_ago . " Days ago"; ?></small>
                        </div>
                    </a>
                </form>
        <?php }
        } ?>
        <div class="modal-footer flex-column border-top-0">
            <button type="submit" name="btt_value" class="btn btn-lg btn-primary w-100 mx-0 mb-2" onclick="hide_popup_sell()">Finish</button>
        </div>
    </div>

    <!-- Menu -->
    <nav class="py-2 bg-light border-bottom">
        <div class="container d-flex flex-wrap">
            <ul class="nav me-auto">
                <li class="nav-item"><a href="#" class="nav-link link-dark px-2 active" aria-current="page">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link link-dark px-2">Features</a></li>
                <li class="nav-item"><a href="#" class="nav-link link-dark px-2">Pricing</a></li>
                <li class="nav-item"><a href="../../../../faq.php" class="nav-link link-dark px-2">FAQs</a></li>
                <li class="nav-item"><a href="#" class="nav-link link-dark px-2">About</a></li>
            </ul>

            <p href="#" style="text-align: center;
              margin-right: 15px;
              margin-top: 5px;">
                <?php if (isset($_SESSION['name_wallet'])) { ?>
                    <b>Using Wallet :</b>
                <?php echo $_SESSION['name_wallet'] . " | <b>Wallet Balance :</b> " . $_SESSION['balance_wallet'] . " €";
                } ?>
            </p>

            <!-- Menu User -->
            <div class="dropdown text-end">
                <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../../../img/profile/<?php echo $_SESSION['logged_user_info']['image']; ?>" alt="mdo" width="32" height="32" class="rounded-circle">
                </a>
                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                    <li style="margin-left: auto;
                    margin-right: auto;
                    width: 8em;
                    }"><b>Balance : <?php echo $_SESSION['logged_user_info']['balance'] . "€"; ?></b></li>
                    <li><a class="dropdown-item" href="../wallets/my_wallets.php">Wallets</a></li>
                    <li><a class="dropdown-item" href="../my_settings.php">Settings</a></li>
                    <li><a class="dropdown-item" href="../profile/my_profile.php">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="../index_page.php?logged_out=true">Sign out</a></li>
                </ul>
            </div>

        </div>
    </nav>
    <header class="py-3 mb-4 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">
            <a href="../index_page.php" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-dark text-decoration-none">
                <svg class="bi me-2" width="40" height="32">
                    <use xlink:href="#bootstrap"></use>
                </svg>
                <span class="fs-4">BankChange</span>
            </a>
            <form class="col-12 col-lg-auto mb-3 mb-lg-0">
                <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
            </form>
        </div>
    </header>

    <!-- Main page -->

    <div class="alert alert-success alert-dismissible fade show" style="position: absolute;display: none;right: 20px;" id="sucess" role="alert">
        <?php
        if (isset($_GET['cripto_buyed'])) {
            echo $_GET['cripto_buyed'];
            echo "<script>sucess_msg();</script>";
            unset($_GET['cripto_buyed']);
        }
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="alert alert-warning alert-dismissible fade show" style="position: absolute;display: none;right: 20px;" id="sell_pending" role="alert">
        <?php
        if (isset($_GET['sell_pending'])) {
            echo $_GET['sell_pending'];
            echo "<script>sell_msg();</script>";
            unset($_GET['sell_pending']);
        }
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="alert alert-danger alert-dismissible fade show" style="position: absolute;display: none;right: 20px;" id="error" role="alert">
        <?php
        if (isset($_SESSION['not_enough_balance'])) {
            echo $_SESSION['not_enough_balance'];
            echo "<script>error_msg();</script>";
            unset($_SESSION['not_enough_balance']);
        }
        if (isset($_GET['no_stock_available'])) {
            echo $_GET['no_stock_available'];
            echo "<script>error_msg();</script>";
            unset($_GET['no_stock_available']);
        }
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="container px-4 py-5" id="custom-cards">

        <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5 pb-9 border-bottom">
            <div class="col">
                <div class="card card-cover h-100 overflow-hidden text-white rounded-5 shadow-lg" style="background-image: url('../../../img/criptos/<?php echo $image_cripto; ?>');
        border-radius: 15px;
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;">
                    <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">

                        <ul class="d-flex list-unstyled mt-auto">
                            <li class="me-auto">
                                <img src="../../../img/profile/<?php echo $last_buyer_image; ?>" alt="Bootstrap" width="32" height="32" style="background-color:black;" class="rounded-circle border border-white">
                            </li>
                            <li class="d-flex align-items-center me-3">
                                <svg class="bi me-2" width="1em" height="1em">
                                    <use xlink:href="#geo-fill"></use>
                                </svg>
                                <small><?php echo $last_buyer_name; ?></small>
                            </li>
                            <li class="d-flex align-items-center">
                                <svg class="bi me-2" width="1em" height="1em">
                                    <use xlink:href="#calendar3"></use>
                                </svg>
                                <small><?php echo $last_buyer_date . " Days ago"; ?></small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div style="width: auto;">
                <h1 class="display-4 fw-bold"><?php echo $name_cripto; ?></h1>

                <div id="chart_div" style="width: 600px; height: 300px;"></div>

                <div style="margin-top:30px;">
                    <p style="font-size: 25px;">Current Price :</p>
                    <b>
                        <p style="font-size: 30px;font-style: bold;font-family: monospace;"><?php echo $price_cripto . "€"; ?></p>
                    </b>
                    <a><button type="button" href="cripto.php" class="btn btn-success" style="height: 50px;width: 150px;" onclick="show_popup_qtd()"><b>Buy</b><br></button></a>
                    <button type="button" class="btn btn-danger" style="height: 50px;width: 150px;" onclick="show_popup_sell()"><b>Sell </b><br></button>
                </div>

                <!-- Optional JavaScript; choose one of the two! -->

                <!-- Option 1: Bootstrap Bundle with Popper -->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>

                <!-- Option 2: Separate Popper and Bootstrap JS -->
                <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.min.js" integrity="sha384-PsUw7Xwds7x08Ew3exXhqzbhuEYmA2xnwc8BuD6SEr+UmEHlX8/MCltYEodzWA4u" crossorigin="anonymous"></script>
    -->

</body>

</html>