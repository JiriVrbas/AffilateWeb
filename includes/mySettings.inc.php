<?php
session_start();
//$_SESSION['u_id'] = 2; //DEBUGOVACI HODNOTA
if (isset($_POST['submit'])) {
    include 'dbh.inc.php';
    //Id affilates které uživatel chce
    $checkListId = array();
    if (!empty($_POST['check_list'])) {
        foreach ($_POST['check_list'] as $check) {
            if ($check) {
                $checkListId[] = $check;
            }
        }
        $uid = mysqli_real_escape_string($conn, $_SESSION['u_id']);
        if (empty($uid)) {
            header("Location: ../web/mySettings.php?login=notLogedIn");
            exit();
        } else {
            //Nastavení inactive všech affilate parterů který uživatel nemá mít
            deactiveUserPartners($uid, $conn);
            //Nastavení active všech affilate parterů který uživatel má mít ale nemá
            //activeUserPartners($checkListId,$uid,$conn);
            foreach ($checkListId as $partnerId) {
                setActiveForUserPartner($partnerId, $uid, $conn);
            }
        }
        header("Location: ../web/mySettings.php?success");
        exit();
    }
} else {
    header("Location: ../web/mySettings.php?");
    exit();
}

function activeUserPartners($partnersId, $uid, $conn)
{
    $sql = "UPDATE user_partners SET active=1 WHERE user_id=?";
    if (count($partnersId) != 0) {
        $sql = $sql . " AND partner_id IN (?);";
    }
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../web/mySettings.php?stm=error");
        exit();
    } else {
        $inString = "";
        foreach ($partnersId as $partnerId) {
            $inString = $inString . strval($partnerId) . ",";
        }
        $inString = substr($inString, 0, -1);
        if (count($partnersId) != 0) {
            mysqli_stmt_bind_param($stmt, "ss", $uid, $inString);
        } else {
            mysqli_stmt_bind_param($stmt, "s", $uid);
        }
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_affected_rows($stmt); //K Otestování zda byly nějak řádky zasašeny
    }
}

function deactiveUserPartners($uid, $conn)
{
    //Nastavení inactive všech affilate parterů který uživatel nemá mít
    $sql = "UPDATE user_partners SET active=0 WHERE user_id = ?";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../web/mySettings.php?stm=error");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $uid);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_affected_rows($stmt); //K Otestování zda byly nějak řádky zasašeny
    }
}

function setActiveForUserPartner($partnerId, $uid, $conn)
{
    //Nastavení inactive všech affilate parterů který uživatel nemá mít
    $sql = "UPDATE user_partners SET active=1 WHERE user_id = ? AND partner_id=?";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../web/mySettings.php?stm=error");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $uid, $partnerId);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_affected_rows($stmt); //K Otestování zda byly nějak řádky zasašeny
    }
}