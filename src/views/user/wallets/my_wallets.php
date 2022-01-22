<?php

require_once '../../../../vendor/autoload.php';

use Alex\ManagementSystem\classes\UserTypeClasses;
use Alex\ManagementSystem\classes\WalletClasses;

$user = new WalletClasses();

if (isset($_GET['package_free'])) {
  $user_type = new UserTypeClasses();
  $user_type->updateUserType($_SESSION['logged_user_info']['id'], 4);
}

if (isset($_GET['id_wallet'])) {
  $using_wallet = new WalletClasses();
  $using_wallet->updateUsingWallet($_GET['id_wallet']);
}

if (isset($_GET['logged_out'])) {
  session_destroy();
  header("Location: ../../../../index.php");
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
  <title> | My Wallets</title>
</head>

<script>
  function alert_show() {
    var package = document.getElementById("alert");
    package.style.display = "block";
  }

  function error_msg() {
    var error_msg = document.getElementById("error");
    error_msg.style = "position: absolute;display: block;right: 20px;";
  }
</script>

<body>

  <!-- Menu -->
  <nav class="py-2 bg-light border-bottom">
    <div class="container d-flex flex-wrap">
      <ul class="nav me-auto">
        <li class="nav-item"><a href="../index_page.php" class="nav-link link-dark px-2 active" aria-current="page">Home</a></li>
        <li class="nav-item"><a href="#" class="nav-link link-dark px-2">Features</a></li>
        <li class="nav-item"><a href="#" class="nav-link link-dark px-2">Pricing</a></li>
        <li class="nav-item"><a href="#" class="nav-link link-dark px-2">FAQs</a></li>
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

  <!-- Create Wallet Form -->

  <div class="modal-content rounded-5 shadow" id="wallet_form" style="
        display: block;
        width: 50%;
        margin: auto;
        border-radius: 10px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border: none;
        display: none;
        z-index: 1;">
    <div class="modal-header p-5 pb-4 border-bottom-0">
      <!-- <h5 class="modal-title">Modal title</h5> -->
      <h2 class="fw-bold mb-0">Create new Wallet</h2>
      <span class="close" style="float:right;cursor:pointer;">&times;</span>
    </div>

    <div class="modal-body p-5 pt-0">
      <form action="create_wallet.php" method="post" id="create_wallet_form">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1">@</span>
          <input type="text" name="name" class="form-control" placeholder="Wallet Name" aria-label="Username" aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text">Description</span>
          <textarea class="form-control" name="desc" aria-label="With textarea"></textarea>
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text">€</span>
          <input type="text" Placeholder="Wallet Start Amount" name="amount" class="form-control" aria-label="Amount (to the nearest euro)">
          <span class="input-group-text">.00</span>
        </div>
        <button type="button" class="w-100 btn btn-lg btn-outline-primary" onclick="create_wallet_form.submit()">Create</button>

      </form>
    </div>
  </div>

  <!-- PopUp -->
  <div class="modal-content rounded-6 shadow" id="popup_free" style="
        border-radius: 10px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 30%;
        z-index:1;
        border: none;
        display:none;">
    <div class="modal-body p-5">
      <h2 class="fw-bold mb-0">One more Step<span class="close" style="float:right;cursor:pointer;">&times;</span></h2>

      <ul class="d-grid gap-4 my-5 list-unstyled">
        <li class="d-flex gap-4">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          <div>
            <h5 class="mb-0">Wallets</h5>
            Create Wallets and increase your income.
          </div>
        </li>
        <li class="d-flex gap-4">
          <div class="spinner-border text-info" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          <div>
            <h5 class="mb-0">Trade</h5>
            Trade in cryptocurrencies for free or get help with paid packages
          </div>
        </li>
        <li class="d-flex gap-4">
          <div class="spinner-border text-dark" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          <div>
            <h5 class="mb-0">BankChange</h5>
            All this with bankchange is possible
          </div>
        </li>
      </ul>
      <a href='my_wallets.php?package_free=true'><button type="button" onclick="assign_package_free()" class="btn btn-lg btn-primary mt-5 w-100" data-bs-dismiss="modal">Become a BankChanger!</button></a>
    </div>
  </div>

  <!-- Main page -->
  <div class="alert alert-success alert-dismissible fade show" style="position: absolute;display: none;right: 20px;" id="alert" role="alert">
    <?php
    if (isset($_SESSION['package_updated'])) {
      echo $_SESSION['package_updated'];
      echo "<script>alert_show();</script>";
      unset($_SESSION['package_updated']);
    } elseif (isset($_SESSION['wallet_created'])) {
      echo $_SESSION['wallet_created'];
      echo "<script>alert_show();</script>";
      unset($_SESSION['wallet_created']);
    } elseif (isset($_SESSION['using_wallet_updated'])) {
      echo $_SESSION['using_wallet_updated'] . $_SESSION['name_wallet'];
      echo "<script>alert_show();</script>";
      unset($_SESSION['using_wallet_updated']);
    }
    ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>

  <div id="wallet_div" style="display:none;">

    <div class="container px-4 py-5" id="hanging-icons">
      <h2 class="pb-2 border-bottom">Wallets</h2>

      <button type="button" id="create_wallet_btn" style="
    width: 13%;
    font-size: 17px;" class="btn btn-lg btn-outline-primary">Create New +</button>

      <div>
        <?php $i = 0;
        foreach ($user->selectWalletByIdUser() as $wallet) {
          if ($i % 3 == 0) {
        ?>
      </div>
      <div class="row g-4 py-5 row-cols-1 row-cols-lg-3" id="wallets">
        <div class="col d-flex align-items-start">

          <div class="card text-center" style="width: 100%;">
            <div class="card-header">
              <?php echo $wallet['name_wallet']; ?>
            </div>
            <div class="card-body">
              <h5 class="card-title">Description :</h5>
              <p class="card-text"><?php echo $wallet['desc_wallet']; ?></p>
              <a href="my_wallets.php?id_wallet=<?php echo $wallet['id_wallet']; ?>" class="btn btn-primary" id="btt_use" value="<?php echo $wallet['id_wallet']; ?>">
                Use
              </a>
              <a href="view_wallet.php?id_wallet=<?php echo $wallet['id_wallet']; ?>" class="btn btn-primary" id="btt_use" value="<?php echo $wallet['id_wallet']; ?>">
                View
              </a>
            </div>
            <div class="card-footer text-muted">
              <?php echo "Wallet balance : " . $wallet['amount'] . " €"; ?>
            </div>
          </div>
        </div>

      <?php } else { ?>
        <div class="col d-flex align-items-start">

          <div class="card text-center" style="width: 100%;">
            <div class="card-header">
              <?php echo $wallet['name_wallet']; ?>
            </div>
            <div class="card-body">
              <h5 class="card-title">Description :</h5>
              <p class="card-text"><?php echo $wallet['desc_wallet']; ?></p>
              <a href="my_wallets.php?id_wallet=<?php echo $wallet['id_wallet']; ?>" class="btn btn-primary" id="btt_use" value="<?php echo $wallet['id_wallet']; ?>">
                Use
              </a>
              <a href="view_wallet.php?id_wallet=<?php echo $wallet['id_wallet']; ?>" class="btn btn-primary" id="btt_use" value="<?php echo $wallet['id_wallet']; ?>">
                View
              </a>
            </div>
            <div class="card-footer text-muted">
              <?php echo "Wallet balance : " . $wallet['amount'] . " €"; ?>
            </div>
          </div>
        </div>

      <?php } ?>

    <?php
          $i = $i + 1;
        } ?>
      </div>
    </div>
  </div>
  </div>

  <div style="width:70%;margin:auto;display:none;" id="package_selection">

    <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
      <h1 class="display-4 fw-normal">Before you operate</h1>
      <p class="fs-5 text-muted">To start trading in the market you need to choose a member package :</p>
    </div>

    <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
      <div class="col">
        <div class="card mb-4 rounded-3 shadow-sm">
          <div class="card-header py-3">
            <h4 class="my-0 fw-normal">Free</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title">0€<small class="text-muted fw-light">/mês</small></h1>
            <ul class="list-unstyled mt-3 mb-4">
              <li>Limeted to 3 Active Wallets</li>
              <li>Can operate in any crypto currency</li>
              <br>
            </ul>
            <button type="button" class="w-100 btn btn-lg btn-outline-primary" id="popup_free_btn">Sign up for free</button>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card mb-4 rounded-3 shadow-sm">
          <div class="card-header py-3">
            <h4 class="my-0 fw-normal">Learner</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title">5€<small class="text-muted fw-light">/mês</small></h1>
            <ul class="list-unstyled mt-3 mb-4">
              <li>Learner Badge</li>
              <li>Limited to 6 Active Wallets</li>
              <li>Help center access</li>
            </ul>
            <button type="button" class="w-100 btn btn-lg btn-primary" disabled>Get started</button>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card mb-4 rounded-3 shadow-sm border-primary">
          <div class="card-header py-3 text-white bg-primary border-primary">
            <h4 class="my-0 fw-normal">Investor</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title">15€<small class="text-muted fw-light">/mês</small></h1>
            <ul class="list-unstyled mt-3 mb-4">
              <li>Investor Badge</li>
              <li>No wallet limit</li>
              <li>Help center access</li>
            </ul>
            <button type="button" class="w-100 btn btn-lg btn-primary" disabled>Contact us</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function package_open() {
      var package_show = document.getElementById("package_selection");
      package_show.style.display = "block";
    }

    function wallet() {
      var wallet = document.getElementById("wallet_div");
      wallet.style.display = "block";
    }

    function hide_wallet_form() {
      var wallet = document.getElementById("wallet_form");
      wallet.style.display = "none";
    }
  </script>

  <?php
  if ($_SESSION['logged_user_info']['FK_id_user_type'] == 3) {
    echo "<script>package_open();</script>";
  } else {
    echo "<script>wallet();</script>";
  }

  if (isset($_GET['created'])) {
    echo "<script>hide_wallet_form();</script>";
  }

  ?>

  <!-- Pop Up-->

  <script>
    var popup_free = document.getElementById("popup_free");
    var btn_free = document.getElementById("popup_free_btn");
    var close = document.getElementsByClassName("close")[0];

    var wallet = document.getElementById("wallet_form");
    var create_wallet_btn = document.getElementById("create_wallet_btn");

    create_wallet_btn.onclick = function() {
      wallet.style.display = "block";
    }

    btn_free.onclick = function() {
      popup_free.style.display = "block";
    }

    close.onclick = function() {
      popup_free.style.display = "none";
      wallet.style.display = "none";
    }

    window.onclick = function(event) {
      if (event.target == popup_free) {
        popup_free.style.display = "none";
      }
    }
  </script>

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