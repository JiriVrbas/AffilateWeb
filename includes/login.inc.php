<?php

session_start();

if(isset($_POST['submit'])){
    include 'dbh.inc.php';

    $uid = mysqli_real_escape_string($conn,$_POST['uid']);
    $pwd = mysqli_real_escape_string($conn,$_POST['pwd']);

    //Error handlers
    //Check if inputs are empty
    if(empty($uid) ||empty($pwd)){
        header("Location: ../web/index.php?login=empty");
        exit();
    }else{
        $sql = "SELECT * FROM users WHERE login=? OR email=?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../web/index.php?login=error");
            exit();
        }else{
            mysqli_stmt_bind_param($stmt,"ss",$uid,$uid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $resultCheck = mysqli_num_rows($result);
            if($resultCheck < 1) {
                header("Location: ../web/index.php?login=error");
                exit();
            }else{
                if($row = mysqli_fetch_assoc($result)){
                    //De-hashing the password
                    $hashedPwdCheck = password_verify($pwd,$row['password']);
                    if($hashedPwdCheck == false){
                        header("Location: ../web/index.php?login=error");
                        exit();
                    }elseif($hashedPwdCheck == true){
                        //Login the user here
                        $_SESSION['u_id'] = $row['user_id'];
                        $_SESSION['u_login'] = $row['login'];
                        $_SESSION['u_first'] = $row['first_name'];
                        $_SESSION['u_last'] = $row['last_name'];
                        $_SESSION['u_email'] = $row['user_email'];
                        $_SESSION['u_link'] = $row['link'];
                        $_SESSION['u_superior_id'] = $row['superior_id'];
                        $_SESSION['u_account_id'] = $row['account_id'];
                        $_SESSION['u_balance'] = $row['balance'];
                        header("Location: ../web/index.php?login=success");
                        exit();
                    }
                }
            }
        }
    }
}else{
    header("Location: ../web/index.php?login=error");
    exit();
}