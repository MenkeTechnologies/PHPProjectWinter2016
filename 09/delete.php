
    <?php
session_start();
include 'connect.php';

$editID = $_SESSION['id'];


if (isset($_REQUEST['delete'])) {

$sqlDelete = "delete from tutorials where id=$editID";
$delete = $pdo->query($sqlDelete);

header("Location:index.php");


}

?>

<h1>Are you sure you want to delete this record?</h1>


<form method="request" action=delete.php>
    <input type="submit" name='delete' value="Yes">
</form>

<form action=details.php>
    <input type="hidden" name="id" value="<?=$editID?>">

        <input type="submit" value="No">

</form>


