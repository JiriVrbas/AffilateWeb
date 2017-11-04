<?php
include_once '../web/header.php'
?>

<section class="main-container">
    <div class="main-wrapper">
        <h2>Home</h2>
        <?php
        if(isset($_SESSION['comeLink'])){
            //echo "User in!" . $_SESSION['comeLink'];
        }
        ?>
    </div>
</section>

<?php
include_once '../web/footer.php'
?>
