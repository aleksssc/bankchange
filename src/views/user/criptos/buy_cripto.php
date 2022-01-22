<?php
if (isset($_POST['btt_value'])) {
    header("Location: cripto.php?buy=true&id_cripto=" . $_POST['btt_value']);
}
