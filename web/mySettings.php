<?php
session_start();

include_once 'header.php';
include_once '../models/affilatepartner.php';
include_once '../models/userPartner.php';
//$_SESSION['u_id'] = 2; //DEBUGOVACI HODNOTA
if(!isset($_SESSION['u_id'])){
    //header("Location: ../web/login.php?mySettings=notLogedIn");
    exit();
}else{
    $uid = mysqli_real_escape_string($conn,$_SESSION['u_id']);
    $allPartners = array();
    $userPartnersId = array();
    $sql = "SELECT ap.partner_id, ap.name, ap.image_link, ap.link, up.link_to_affilate, up.active, up.partner_id AS up_partner_id FROM affilate_partners ap 
            LEFT JOIN user_partners up on ap.partner_id=up.partner_id AND up.user_id = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)) {
        //header("Location: ../web/login.php?mySettings=notLogedIn");
        exit();
    }else{
        mysqli_stmt_bind_param($stmt, "s", $uid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while($row = mysqli_fetch_assoc($result)) {
            if(isset($row['active']) && $row['active']==1){
                $userPartnersId[] = $row['up_partner_id'];
            }
            $allPartners[] = new affilatepartner($row['partner_id'],$row['link'],$row['name'],$row['image_link']);
        }
    }
}
?>
<script>
    document.onclick = function(e) {
        if (!e) e = window.event;
        var el = e.target || e.srcElement;
        if (el.type === "checkbox") {
            if (el.checked) {
                el.nextSibling.className += " checked";
            }else{
                el.nextSibling.className = el.nextSibling.className.replace(/\bchecked\b/,"");
            }
        }
    };
</script>
<section class="main-container">
    <div class="main-wrapper">
        <h2>My settings</h2>
        <form action="../includes/mySettings.inc.php" method="post">
            <table>
                <?php
                $partnerstorow = 3; // Nastavení kolik se jich bude zobrazovat v řadě
                $actualIndex = 0;
                $num_rows = ceil(count($allPartners)/$partnerstorow);

                for ($x = 0; $x < $num_rows; $x++) {
                    echo "<tr>";
                    for ($y = 0; $y < $partnerstorow; $y++){
                        if($actualIndex >= count($allPartners))break;
                        $p_id = $allPartners[$actualIndex]->partner_id;
                        $p_name = $allPartners[$actualIndex]->name;
                        $p_image = $allPartners[$actualIndex]->image_link;

                        if(in_array($allPartners[$actualIndex]->partner_id,$userPartnersId)){
                            $checked = " checked";
                        }else{
                            $checked = "";
                        }
                        echo "<td>
                                <input type='checkbox' name='check_list[]' style='display: none';
                                    value='$p_id' id='$p_id' $checked /><label class='checkedLabel' for='$p_id' >
                                    <img src='$p_image' alt='$p_name' height='500' width='500'>
                                </label>                                
                              </td>";
                        $actualIndex++;
                    }
                    echo "</tr>";
                }?>
            </table>
            <button type="submit" name="submit">Save</button>
        </form>
    </div>
</section>
<?php
include_once 'footer.php'
?>
