<?php
session_start();
if (!empty($_POST['affilate'])) {
    include_once 'dbh.inc.php';

    $partnerId = key($_POST['affilate']);
    if (isset($_SESSION['u_id'])) {
        $uid = mysqli_real_escape_string($conn, $_SESSION['u_id']);
    } else {
        $uid = 1;//Id hlavního uživatele
    }

    $partner = getAffilatePartnerById($partnerId, $uid);

    if (is_null($partner)) {
        header("Location: ../web/affilatePartners.php?error=parnterisnull");
        exit();
    } else {
        saveClick($partner->partner_id, $uid);
        header("Location: $partner->link_to_affilate");
        exit();
    }
}
