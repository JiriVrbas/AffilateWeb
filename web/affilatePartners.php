<?php
include_once 'header.php';
include_once '../models/affilatepartner.php';
$rows = 3;
$columns = 3;
?>

<section class="main-container">
    <div class="main-wrapper">
        <h2>Affilate partners</h2>
        <?php
        $partners = array();
        if(isset($_SESSION['u_id'])){
            $uid = mysqli_real_escape_string($conn, $_SESSION['u_id']);
        }else{
            $uid = 1;//Id hlavního uživatele
        }
        $sql = "SELECT ap.partner_id, ap.name, ap.image_link, ap.link, up.link_to_affilate, up.active, up.partner_id AS up_partner_id FROM affilate_partners ap 
            LEFT JOIN user_partners up on ap.partner_id=up.partner_id AND up.user_id = ? ORDER BY up.active ASC LIMIT ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)) {
            //header("Location: ../web/login.php?mySettings=notLogedIn");
            exit();
        }else{
            $count = $rows*$columns;
            mysqli_stmt_bind_param($stmt, "si", $uid,$count);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while($row = mysqli_fetch_assoc($result)) {
                $partners[] = new affilatepartner($row['partner_id'],$row['link'],$row['name'],$row['image_link']);
            }
        }
        ?>
        <form action="../includes/affilatePartners.inc.php" method="post">
        <table>
            <?php
            $actualIndex = 0;
            for ($x = 0; $x < $rows; $x++) {
                echo "<tr>";
                for ($y = 0; $y < $columns; $y++){
                    if($actualIndex >= count($partners))break;
                    $p_id = $partners[$actualIndex]->partner_id;
                    $p_name = $partners[$actualIndex]->name;
                    $p_image = $partners[$actualIndex]->image_link;

                    echo "<td>
                              <input class='affilate-link-input' type='image'src='$p_image' name='affilate[$p_id]'/>
                            </td>";
                    $actualIndex++;
                }
                echo "</tr>";
             }?>
        </table>
        </form>
    </div>
</section>

<?php
include_once 'footer.php';
?>
