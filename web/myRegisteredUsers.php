<?php
include_once 'header.php';
include_once '../includes/dbh.inc.php';
include_once '../models/user.php';
?>

<section class="main-container">
    <div class="main-wrapper">
        <h2>My registered users</h2>
        <?php
        if (isset($_SESSION['u_id'])) {
            echo "<table>";
            echo "<tr>
                    <th>Login</th>
                    <th>Email</th>
                    <th>Link</th>
                    <th>First name</th>
                    <th>Last name</th>
                  </tr>";
            $users = getRegisteredUsersForUser($_SESSION['u_id']);
            foreach ($users as $user){
                echo "<tr>";
                echo "<td> $user->login</td>";
                echo "<td> $user->email</td>";
                echo "<td> $user->link</td>";
                echo "<td> $user->first_name</td>";
                echo "<td> $user->last_name</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        ?>
    </div>
</section>

<?php
include_once 'footer.php'
?>
