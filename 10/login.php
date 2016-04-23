<?php
/*
 * created by Jacob Menke
 * 
 * 
 * User = Instructor
 * PW = hellowo5
 * 
 * 
 */
 session_start();

unset($_SESSION['user']);

include 'connect.php';


if (isset($_REQUEST['user'])) {

    $user = @$_REQUEST['user'];
    $newPass = @$_REQUEST['pass'];
    $sqlUsers = "select * from users where user='$user';";


    $result = $pdo->query($sqlUsers);

    $count = $result->rowCount();

    if ($count > 0) {

        $salt = "dgjklgaj()#%lk353";

        $possiblePass = hash("sha256", $salt . $newPass);


        $currentPassSearch = $result->fetch(PDO::FETCH_ASSOC);
        $currentPass = $currentPassSearch['password'];

        if ($possiblePass == $currentPass) {
           
           

            $_SESSION['user'] = $user;
            header("Location:index.php");
        } else {
            echo "<font color = 'red'>Incorrect Username or Password</font>";
        }
    }
    else {
            echo "<font color = 'red'>Incorrect Username or Password</font>";
        }
}


if (isset($_REQUEST['newUser'])) {

    $newUser = @$_REQUEST['newUser'];
    $newPass = @$_REQUEST['newPass'];

    //valid password checking


    $pattern = "/[a-zA-z]{7}\d/";
    $matchResult = preg_match($pattern, $newPass);

    if ($matchResult != 1) {
        echo "<font color = 'red'> Not A Valid Password</font>";
    } else {
        //check to see if username already taken    

        $sqlUsers = "select * from users where user='$newUser';";

        $result = $pdo->query($sqlUsers);

        $count = $result->rowCount();


        if ($count > 0) {
            echo "<font color = 'red'> Username already taken sorry.</font>";
        } else if ($newUser == NULL) {
            echo "<font color = 'red'> Username cannot be blank sorry.</font>";
        } else {

            
            
            echo "It is working";
            //encrypt password

            $salt = "dgjklgaj()#%lk353";

            $securePass = hash("sha256", $salt . $newPass);

            $sqlAdd = "insert into users (user,password) values ('$newUser','$securePass');";

            $result = $pdo->query($sqlAdd);

            $_SESSION['user'] = $newUser;
            header("Location:index.php");
        }
    }
}
?>

<form method="request" action='login.php'>

    <table border='1'>

        <tr>
            <th colspan='2'>Login</th>
        </tr>
        <tr>
            <td>Username</td>
            <td><input type='text' name='user' /> </td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type='password' name='pass'/></td>
        </tr>


    </table>

    <input type="submit" value="Login">

</form>

<header>Password must be 7 letters and 1 number.  No spaces or any extra characters.  Capital letters are allowed. </header>

<form method="request" action='login.php'>

    <table border='1'>

        <tr>
            <th colspan='2'>Registration</th>
        </tr>
        <tr>
            <td>Username</td>
            <td><input type='text' name='newUser' /> </td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type='password' name='newPass'/></td>
        </tr>


    </table>

    <input type="submit" value="Create new account">

</form>