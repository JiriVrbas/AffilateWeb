<?php
include_once 'header.php'
?>
<script>
    function ValidatePassword() {
        var pass1 = document.getElementById("pwd").value;
        var pass2 = document.getElementById("repeatPwd").value;
        if (pass1 != pass2) {
            document.getElementById("signUp").isDisabled = true;
        }else{
            document.getElementById("signUp").isDisabled = false;
        }
    }
</script>
<section class="main-container">
    <div class="main-wrapper">
        <h2>Signup</h2>
        <form class="signup-form" action="../includes/signup.inc.php" method="post">
            <input type="text" name="login" placeholder="Login">
            <input type="text" name="email" placeholder="E-mail">
            <input type="password" name="pwd" placeholder="Password" id="pwd" onchange="ValidatePassword()">
            <input type="password" placeholder="Repeat password" id="repeatPwd" onchange="ValidatePassword()">
            <button type="submit" name="submit" id="signUp">Sign up</button>
        </form>
    </div>
</section>

<?php
include_once 'footer.php'
?>
