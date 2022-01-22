<?php

require_once '../../../../vendor/autoload.php';

use Alex\ManagementSystem\classes\CriptoClasses;
use Alex\ManagementSystem\classes\UserClasses;
use Alex\ManagementSystem\classes\WalletClasses;

$user = new UserClasses();
$wallet = new CriptoClasses();

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
    <title> | View Wallet</title>
</head>

<body>

    <!-- Menu -->
    <nav class="py-2 bg-light border-bottom">
        <div class="container d-flex flex-wrap">
            <ul class="nav me-auto">
                <li class="nav-item"><a href="../index_page.php" class="nav-link link-dark px-2 active" aria-current="page">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link link-dark px-2">Features</a></li>
                <li class="nav-item"><a href="#" class="nav-link link-dark px-2">Pricing</a></li>
                <li class="nav-item"><a href="../../../faq.php" class="nav-link link-dark px-2">FAQs</a></li>
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
                    <li><a class="dropdown-item" href="my_wallets.php">Wallets</a></li>
                    <li><a class="dropdown-item" href="../my_settings.php">Settings</a></li>
                    <li><a class="dropdown-item" href="../profile/my_profile.php">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="view_wallet.php?logged_out=true">Sign out</a></li>
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

    <?php if (isset($_GET['id_wallet'])) {
        $teste = new WalletClasses();
        foreach ($teste->selectWalletById($_GET['id_wallet']) as $teste) {
            $viewing_wallet_name = $teste['name_wallet'];
        }
    }
    ?>

    <div class="container px-4 py-5" id="featured-3">
        <h2 class="pb-2 border-bottom"><?php echo $viewing_wallet_name; ?></h2>
        <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
            <div class="list-group" style="width: 100%;">

                <?php if (isset($_GET['id_wallet'])) {
                    foreach ($wallet->selectBuysByWallet($_GET['id_wallet']) as $wallet) {
                        $viewing_wallet_name = $wallet['name_wallet'];
                        $today_date = date("d-m-y");
                        $wallet['data_crypto_bought'] = date("d-m-Y", strtotime($wallet['data_crypto_bought']));

                        $buyed_time_ago = ($today_date - $wallet['data_crypto_bought']);
                ?>

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
                                <?php if ($wallet['waiting_sell'] == 'yes') { ?>
                                    <small class="opacity-50 text-nowrap">Pending sale process</small>
                                <?php } ?>
                                <small class="opacity-50 text-nowrap"><?php echo $buyed_time_ago . " Days ago"; ?></small>
                            </div>
                    <?php }
                } ?>
                        </a>
            </div>
        </div>
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