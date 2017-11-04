<?php
include_once '../models/userPartner.php';
include_once '../models/user.php';
function getAffilatePartnerById($partnerid,$uid){
    //global $conn
    $conn = $GLOBALS['conn'];
    $p_id = mysqli_real_escape_string($conn, $partnerid);
    $u_id = mysqli_real_escape_string($conn, $uid);
    if (!empty($p_id)&&!empty($u_id)) {
        $sql = "SELECT partner_id, user_id, link_to_affilate, active FROM user_partners WHERE partner_id=? AND user_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../web/index.php?getAffilateParntnerById=error");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $p_id,$u_id);

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            if($row != null){
                return new userPartner($row['partner_id'],$row['user_id'],$row['link_to_affilate'],$row['active']);
            }
        }
    }
    return null;
}
function saveClick($partnerid,$uid){
    //global $conn;
    $conn = $GLOBALS['conn'];
    $p_id = mysqli_real_escape_string($conn, $partnerid);
    $u_id = mysqli_real_escape_string($conn, $uid);

    if (!empty($p_id)&&!empty($u_id)) {
        $sql = "INSERT INTO clicks_history(time_of_click,user_id,affilate_partner_id) VALUES (NOW(),?,?);";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../web/index.php?saveClick=error");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ss",$u_id,$p_id);

            mysqli_stmt_execute($stmt);
            $affectedRows = mysqli_stmt_affected_rows($stmt);
        }
    }
}
function getRegisteredUsersForUser($uid){
    $conn = $GLOBALS['conn'];
    $u_id = mysqli_real_escape_string($conn, $uid);
    $users = array();
    if (!empty($u_id)) {
        $sql = "SELECT u2.user_id, u2.login, u2.email, u2.link, u2.first_name, u2.last_name, u2.superior_id, u2.account_id,u2.balance FROM users u1 JOIN users u2 ON u1.user_id = u2.superior_id WHERE u1.user_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../web/index.php?getRegisteredUsersForUser=error");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s",$u_id);

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while($row = $result->fetch_assoc()){
                $users[] = new user($row['user_id'],$row['login'],$row['email'],$row['link'],$row['first_name'],$row['last_name'],$row['superior_id'],$row['account_id'],$row['balance']);
            }
        }
    }
    return $users;
}

$dbServername="localhost";
$dbUserName="root";
$dbPassword="";
$dbName="affilatesystem";

$conn = mysqli_connect($dbServername,$dbUserName,$dbPassword,$dbName);

