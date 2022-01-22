<?php
if (isset($_POST['id_crypto_wallet'])) {
    if (isset($_POST['id_cripto'])) {
        $id_crypto_wallet = $_POST['id_crypto_wallet'];
        header("Location: cripto.php?sell=true&id_cripto=" . $_POST['id_cripto'] . "&id_cripto_wallet=" . $id_crypto_wallet . "&old_stock=" . $_POST['stock']);
    }
}
