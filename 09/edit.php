<?php
include 'connect.php';
session_start();

$editID = $_SESSION['id'];

?>
<a href=index.php>Back To Home</a>
<a href=details.php?id=<?= $editID ?>>Back To Details</a>
<?php

if (isset($_REQUEST['title'])) {
    

    $titleChange = @$_REQUEST['title'];
    $authorChange = @$_REQUEST['author'];
    $rawDate = strtotime(@$_REQUEST['publishedDate']);
    $published_DateChange = date('Y-m-d', $rawDate);
  
    $descriptionChange = @$_REQUEST['description'];
    $priceChange = @$_REQUEST['price'];
    $categoryChange = @$_REQUEST['category'];
    $lengthChange = @$_REQUEST['length'];
    
    
     if ($titleChange == "" || $authorChange == "" || $published_DateChange == "" || $lengthChange == ""){
       
        echo "<font color = 'red'>Title, author, published date and length cannot be null</font>";
        
     }
     
     else if ($rawDate == FALSE){
         echo "<font color = 'red'>Invalid Date</font>";
         
     }
     else{

    $sqlUpdate = "update tutorials set title='$titleChange',author='$authorChange',published_date='$published_DateChange',description='$descriptionChange',price=$priceChange,category='$categoryChange',length=$lengthChange where id=$editID;";

    $resultUpdate = $pdo->query($sqlUpdate);

    header("Location:index.php");
  
 }
}
//troubleshooting


$id = $editID;


    $sql1 = "select * from tutorials where id=" . intval($id);
    $result = $pdo->query($sql1);



    $row = $result->fetch(PDO::FETCH_ASSOC);
    $title = $row['title'];
    $author = $row['author'];
    $published_Date = date("M d Y",  strtotime($row['published_date']));
    $description = $row['description'];
    $price = $row['price'];
    $category = $row['category'];
    $length = $row['length'];
    
    $checked = array();
    
    
    for ($i = 0; $i < 5; $i++){
    $checked[$i] = "";
    }
    
    switch ($category){
        case "Programming": $checked[0] = "checked"; break;
        case "CAD": $checked[1] = "checked"; break;
        case "Networking": $checked[2] = "checked"; break;
        case "OS": $checked[3] = "checked"; break;
        case "Productivity": $checked[4] = "checked"; break; 
       
        }
    


?>


<form method="request" action="edit.php">

    <table border="4">
        <tr>
            <th colspan='2'>Edit Listing</th>
        </tr>
        <tr> <td>Title</td> <td><input type="text" name="title" value='<?= ($title) ? $title : '' ?>'></td> </tr>
        <tr> <td>Author</td> <td><input type="text" name="author" value='<?= ($author) ? $author : '' ?>'></td> </tr>
        <tr> <td> Published Date</td> <td><input type="text" name="publishedDate" value='<?= ($published_Date) ? $published_Date : '' ?>'></td> </tr>
        <tr> <td>Description</td> <td>​<textarea name="description" rows="10" cols="18"><?= ($description) ? $description : '' ?></textarea></td> </tr>

        <tr> <td>Price</td> <td><input type="text" name="price" value='<?= ($price) ? $price : '' ?>'></td> </tr>

        <tr> <td>Category</td> <td>
                <input type="radio" name="category" value="programming" <?=$checked[0]?>> Programming<br>
                <input type="radio" name="category" value="CAD"<?=$checked[1]?>>CAD<br>
                <input type="radio" name="category" value="OS"<?=$checked[2]?>>OS
                <input type="radio" name="category" value="Networking"<?=$checked[3]?>>Networking<br>
                <input type="radio" name="category" value="Productivity"<?=$checked[4]?>>Productivity

            </td> </tr>

        <tr> <td>Length in Minutes</td> <td><input type="text" name="length" value='<?= ($length) ? $length : '' ?>'></td> </tr>

        <tr> <td>  <input type="submit" value="Edit"> </td> <td> &nbsp;</td></tr>

    </table>

</form>
