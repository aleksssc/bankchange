<?php

require_once '../../../vendor/autoload.php';

use Alex\ManagementSystem\classes\CriptoClasses;
use Alex\ManagementSystem\classes\UserClasses;
use Alex\ManagementSystem\classes\WalletClasses;

$user = new UserClasses();
$wallet = new WalletClasses();
$cripto = new CriptoClasses();

foreach ($wallet->selectWalletByIdUser() as $wallet) {
  if ($wallet['using'] == '1') {
    $_SESSION['using_wallet'] = $wallet['id_wallet'];
    $_SESSION['name_wallet'] = $wallet['name_wallet'];
    $_SESSION['balance_wallet'] = $wallet['amount'];
  }
}

$i = 0;
foreach ($cripto->selectLastBuyerAllCriptos() as $last_buyer_info) {
  $last_buyer_name = $last_buyer_info[0]['name'] . " " . $last_buyer_info[0]['l_name'];

  $last_buyer_image = $last_buyer_info[0]['image'];

  $today_date = date("d-m-y");
  $last_buyer_info[0]['data_crypto_bought'] = date("d-m-Y", strtotime($last_buyer_info[0]['data_crypto_bought']));

  $last_buyer_date = ($today_date - $last_buyer_info[0]['data_crypto_bought']);

  $last_buyer_info_arr[$i] = array("0" => $last_buyer_name, "1" => $last_buyer_date, "2" => $last_buyer_image);

  if ($last_buyer_info_arr[2] != null) {
    $last_buyer_info_all = array($last_buyer_info_arr[0], $last_buyer_info_arr[1], $last_buyer_info_arr[2]);
  }

  $i = $i + 1;
}


function sign_out()
{
  session_destroy();
  header("Location: ../../../index.php");
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
  <link rel="shortcut icon" href="../../img/bankchange_logo.png" />
  <title> | Main Page</title>
</head>

<body>

  <!-- Menu -->
  <nav class="py-2 bg-light border-bottom">
    <div class="container d-flex flex-wrap">
      <ul class="nav me-auto">
        <li class="nav-item"><a href="#" class="nav-link link-dark px-2 active" aria-current="page">Home</a></li>
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
          <img src="../../img/profile/<?php echo $_SESSION['logged_user_info']['image']; ?>" alt="mdo" width="32" height="32" class="rounded-circle">
        </a>
        <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
          <li style="margin-left: auto;
            margin-right: auto;
            width: 8em;
            }"><b>Balance : <?php echo $_SESSION['logged_user_info']['balance'] . "€"; ?></b></li>
          <li><a class="dropdown-item" href="wallets/my_wallets.php">Wallets</a></li>
          <li><a class="dropdown-item" href="my_settings.php">Settings</a></li>
          <li><a class="dropdown-item" href="profile/my_profile.php">Profile</a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item" href="index_page.php?logged_out=true">Sign out</a></li>
        </ul>
      </div>

    </div>
  </nav>
  <header class="py-3 mb-4 border-bottom">
    <div class="container d-flex flex-wrap justify-content-center">
      <a href="index_page.php" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-dark text-decoration-none">
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
  <div class="container px-4 py-5" id="custom-cards">
    <h2 class="pb-2 border-bottom">Trending</h2>

    <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5 pb-9 border-bottom">
      <a href="criptos/cripto.php?id_cripto=1" style="text-decoration: none;">
        <div class="col">
          <div class="card card-cover h-100 overflow-hidden text-white rounded-5 shadow-lg" style="background-image: url('../../img/criptos/bitcoin_wall.jpg');
        border-radius: 15px;
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;">
            <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
              <h2 class=" mt-5 mb-4 display-6 lh-1 fw-bold">Bitcoin</h2>
              <ul class="d-flex list-unstyled mt-auto">
                <li class="me-auto">
                  <img src="../../img/profile/<?php echo $last_buyer_info_all[0][2] ?>" alt="Bootstrap" width="32" height="32" class="rounded-circle border border-white">
                </li>
                <li class="d-flex align-items-center me-3">
                  <svg class="bi me-2" width="1em" height="1em">
                    <use xlink:href="#geo-fill"></use>
                  </svg>
                  <small><?php echo $last_buyer_info_all[0][0] ?></small>
                </li>
                <li class="d-flex align-items-center">
                  <svg class="bi me-2" width="1em" height="1em">
                    <use xlink:href="#calendar3"></use>
                  </svg>
                  <small><?php echo $last_buyer_info_all[0][1] . " Days ago"  ?></small>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </a>

      <div class="col">
        <a href="criptos/cripto.php?id_cripto=2" style="text-decoration: none;">
          <div class="card card-cover h-100 overflow-hidden text-white rounded-5 shadow-lg" style="background-image: url('../../img/criptos/ethereum_wall.jpg');
        border-radius: 15px;
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;">
            <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
              <h2 class=" mt-5 mb-4 display-6 lh-1 fw-bold">Ethereum</h2>
              <ul class="d-flex list-unstyled mt-auto">
                <li class="me-auto">
                  <img src="../../img/profile/<?php echo $last_buyer_info_all[1][2] ?>" alt="Bootstrap" width="32" height="32" class="rounded-circle border border-white">
                </li>
                <li class="d-flex align-items-center me-3">
                  <svg class="bi me-2" width="1em" height="1em">
                    <use xlink:href="#geo-fill"></use>
                  </svg>
                  <small><?php echo $last_buyer_info_all[1][0] ?></small>
                </li>
                <li class="d-flex align-items-center">
                  <svg class="bi me-2" width="1em" height="1em">
                    <use xlink:href="#calendar3"></use>
                  </svg>
                  <small><?php echo $last_buyer_info_all[1][1] . " Days ago" ?></small>
                </li>
              </ul>
            </div>
          </div>
        </a>
      </div>

      <div class="col">
        <a href="criptos/cripto.php?id_cripto=3" style="text-decoration: none;">
          <div class="card card-cover h-100 overflow-hidden text-white rounded-5 shadow-lg" style="background-image: url('../../img/criptos/binance_wall.jpeg');
        border-radius: 15px;
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;">
            <div class="d-flex flex-column h-100 p-5 pb-3 text-shadow-1">
              <h2 class=" mt-5 mb-4 display-6 lh-1 fw-bold">Binance</h2>
              <ul class="d-flex list-unstyled mt-auto">
                <li class="me-auto">
                  <img src="../../img/profile/<?php echo $last_buyer_info_all[2][2] ?>" alt="Bootstrap" width="32" height="32" class="rounded-circle border border-white">
                </li>
                <li class="d-flex align-items-center me-3">
                  <svg class="bi me-2" width="1em" height="1em">
                    <use xlink:href="#geo-fill"></use>
                  </svg>
                  <small><?php echo $last_buyer_info_all[2][0] ?></small>
                </li>
                <li class="d-flex align-items-center">
                  <svg class="bi me-2" width="1em" height="1em">
                    <use xlink:href="#calendar3"></use>
                  </svg>
                  <small><?php echo $last_buyer_info_all[2][1] . " Days ago"  ?></small>
                </li>
              </ul>
            </div>
          </div>
      </div>
      </a>
    </div>
  </div>

  <!-- We Are The Company div -->
  <div class="px-4 text-center border-bottom">
    <table style="margin: auto;">
      <tr>
        <?php
        $id_row = 0;
        foreach ($cripto->selectAllCripto() as $cripto) {
          if ($id_row % 4 == 0) { ?>
      </tr>
      <tr>
        <th>
        <?php } else { ?>
        </th>
        <th>
        <?php } ?>

        <div class="col" style="height: 75px;width: 300px;margin: 10px;">
          <a href="criptos/cripto.php?id_cripto=<?php echo $cripto["id_crypto"] ?>" style="text-decoration: none;">
            <div class="card card-cover h-100 overflow-hidden text-white rounded-5 shadow-lg" style="background-image: url('../../img/criptos/<?php echo $cripto["image_crypto"]; ?>');
        border-radius: 5px;
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;">
              <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                <h2 class=" mt-5 mb-4 display-6 lh-1 fw-bold"><?php echo $cripto["name_crypto"]; ?></h2>
              </div>
            </div>
          </a>
        </div>

      <?php
          $id_row++;
        }
      ?>
    </table>
    <h1 class="display-4 fw-bold">We Are The Company</h1>
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4">Disclaimer : This is a project developed by a programmer in order to self learning and skill training, this is all just simulation</p>
    </div>
    <div class="overflow-hidden" style="max-height: 30vh;">
      <div class="container px-5">
        <img src="../..//img/bitcoin_bank.png" class="img-fluid border rounded-3 shadow-lg mb-4" alt="Example image" width="700" height="500" loading="lazy">
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