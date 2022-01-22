<?php

require_once '../../../../vendor/autoload.php';

use Alex\ManagementSystem\classes\UserClasses;

$user = new UserClasses();

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
    <title> | My Profile</title>
</head>

<script>
    function profile_updated_msg() {
        var sucess = document.getElementById("sucess");
        sucess.style = "position: absolute;display: block;right: 20px;";
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
                    <li><a class="dropdown-item" href="#">Profile</a></li>
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
        if (isset($_SESSION['profile_updated_msg'])) {
            echo $_SESSION['profile_updated_msg'];
            echo "<script>profile_updated_msg();</script>";
            unset($_SESSION['profile_updated_msg']);
        }
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="alert alert-danger alert-dismissible fade show" style="position: absolute;display: none;right: 20px;" id="error" role="alert">
        <?php
        if (isset($_SESSION['error_msg'])) {
            echo $_SESSION['error_msg'];
            echo "<script>error_msg();</script>";
            unset($_SESSION['error_msg']);
        }
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="modal-content rounded-5 shadow" style="width: 30%;border-radius: 10px;margin: auto;">
        <div class="modal-header p-5 pb-4 border-bottom-0">
            <!-- <h5 class="modal-title">Modal title</h5> -->
            <h2 class="fw-bold mb-0">Edit Profile</h2>
        </div>

        <div class="modal-body p-5 pt-0">

            <img style="display: block;
            border-radius:8px;
            width: 55%;
            margin-bottom: 20px;
            margin-left: auto;
            margin-right: auto;" src="../../../img/profile/<?php echo $_SESSION['logged_user_info']['image']; ?>">

            <form action="save_my_profile.php" enctype='multipart/form-data' method="post">

                <div class="mb-3">
                    <input type="file" name="img_name" class="form-control form-control-lg" aria-label="Large file input example">
                </div>

                <div class="form-floating mb-3">
                    <input type="text" name="name" class="form-control" id="name" placeholder="New Name">
                    <label for="floatingInput"><?php echo $_SESSION['logged_user_info']['name']; ?></label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" name="l_name" class="form-control" id="l_name" placeholder="Mew Last Name">
                    <label for="floatingInput"><?php echo $_SESSION['logged_user_info']['l_name']; ?></label>
                </div>

                <div class="form-floating mb-3">
                    <input disabled type="email" name="email" class="form-control" id="floatingInput" placeholder="New Email">
                    <label for="floatingInput"><?php echo $_SESSION['logged_user_info']['email']; ?></label>
                </div>

                <button class="btn btn-primary" style="float:right;margin-left:10px" type="submit">Update Profile</button>
                <button class="btn btn-outline-secondary" type="button" style="float:right;">Recover Password</button>
        </div>
    </div>

    </form>

    <!-- Fim Tabela Utilizadores -->

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