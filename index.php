<?php

require_once './vendor/autoload.php';

use Alex\ManagementSystem\classes\UserClasses;

$user = new UserClasses();
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <link rel="shortcut icon" href="src/img/bankchange_logo.png" />
    <title> | Main Pagina</title>
</head>

<body>

    <!-- Menu -->
    <nav class="py-2 bg-light border-bottom">
        <div class="container d-flex flex-wrap">
            <ul class="nav me-auto">
                <li class="nav-item"><a href="#" class="nav-link link-dark px-2 active" aria-current="page">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link link-dark px-2">Features</a></li>
                <li class="nav-item"><a href="#" class="nav-link link-dark px-2">Pricing</a></li>
                <li class="nav-item"><a href="faq.php" class="nav-link link-dark px-2">FAQs</a></li>
                <li class="nav-item"><a href="#" class="nav-link link-dark px-2">About</a></li>
            </ul>
            <ul class="nav">
                <li class="nav-item"><a href="src\views\auth\login_page.php" class="nav-link link-dark px-2">Sign in</a></li>
                <li class="nav-item"><a href="src\views\auth\register_page.php" class="nav-link link-dark px-2">Sign up</a></li>
            </ul>
        </div>
    </nav>
    <header class="py-3 mb-4 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">
            <a href="/" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-dark text-decoration-none">
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
    <div class="px-4 py-5 my-5 text-center">
        <img class="d-block mx-auto mb-4" src="src/img/bankchange_logo.png" alt="image" width="57" height="57">
        <h1 class="display-5 fw-bold">Bank Change</h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">Disclaimer : This is a project developed by a programmer in order to self learning and skill training, this is all just simulation</p>
        </div>
    </div>

    <!-- We Are The Company div -->
    <div class="px-4 pt-5 my-5 text-center border-bottom">
        <h1 class="display-4 fw-bold">We Are The Company</h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">On this website you will find a system for buying and selling cryptocurrencies between users and bots among other features developed in the future.</p>
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5">
                <button type="submit" class="btn btn-primary btn-lg px-4 me-sm-3" onclick="window.location.href='src/views/auth/register_page.php'">Join BankChange</button>
                <button type="button" class="btn btn-outline-secondary btn-lg px-4">More Info</button>
            </div>
        </div>
        <div class="overflow-hidden" style="max-height: 30vh;">
            <div class="container px-5">
                <img src="src/img/bitcoin_bank.png" class="img-fluid border rounded-3 shadow-lg mb-4" alt="Example image" width="700" height="500" loading="lazy">
            </div>
        </div>
    </div>
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