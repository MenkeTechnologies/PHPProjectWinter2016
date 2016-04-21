<?php
/*
 * created by Jacob Menke
 * 
 */

session_start();

include 'connect.php';

if (isset($_REQUEST['user'])) {

    $user = @$_REQUEST['user'];
    $newPass = @$_REQUEST['newPass'];
    $oldPass = @$_REQUEST['oldPass'];
    $sqlUsers = "select * from users where user='$user';";


    $result = $pdo->query($sqlUsers);

    $count = $result->rowCount();

    if ($count > 0) {

        $salt = "dgjklgaj()#%lk353";

        $possiblePass = hash("sha256", $salt . $oldPass);


        $currentPassSearch = $result->fetch(PDO::FETCH_ASSOC);
        $currentPass = $currentPassSearch['password'];

        if ($possiblePass == $currentPass) {

            $pattern = "/[a-zA-z]{7}\d/";
            $matchResult = preg_match($pattern, $newPass);

            if ($matchResult != 1) {
                echo "<font color = 'red'> Not A Valid Password</font>";
            } else {

                $salt = "dgjklgaj()#%lk353";

                $securePass = hash("sha256", $salt . $newPass);

                $sqlAdd = "update users set password='$securePass' where user='$user'";

                $result = $pdo->query($sqlAdd);

                header("Location:index.php");
            }
        } else {
            echo "<font color = 'red'>Incorrect Username or Password</font>";
        }
    } else {
        echo "<font color = 'red'>Incorrect Username or Password</font>";
    }
}
?>

<form method="request" action='change.php'>

    <table border='1'>

        <tr>
            <th colspan='2'>Change Password</th>
        </tr>
        <tr>
            <td>Username</td>
            <td><input type='text' name='user' /> </td>
        </tr>
        <tr>
            <td>Old Password</td>
            <td><input type='password' name='oldPass'/></td>
        </tr>

        <tr>
            <td>New Password</td>
            <td><input type='password' name='newPass'/></td>
        </tr>


    </table>

    <input type="submit" value="Change">

</form>