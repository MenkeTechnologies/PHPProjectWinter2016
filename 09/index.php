<h1>Tutorial Database</h1>

<?php

include 'connect.php'; //connect to database

//PHP requests setting timezone for date formatting
date_default_timezone_set('America/Detroit');

if (isset($_POST['nameSearch'])) { //get Name Search Text Field Data when form submitted
    $nameSearch = $_POST['nameSearch'];

    
} else {  //keep text field blank and do not filter with no data entered in text field

}




$sql = "select * from tutorials";
$result = $pdo->query($sql);
?>


<table border = "2" cellpadding = "5" cellspacing="5">
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Published Date</th>
        <th>Price</th>
        <th>Category</th>
        <th>Length(min)</th>
        <th>More Info</th>
    </tr>

<?php
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $title = $row['title'];
    $published_Date = date("M d Y",  strtotime($row['published_date']));
    $author = $row['author'];
    $price = $row['price'];
    $category = $row['category'];
    $length = $row['length'];
    $id = $row['id'];

//table data, if no data available keep table cell empty
    echo"<tr>";
    echo "<td>" . (($title) ? $title : '&nbsp') . "</td>";
    echo "<td>".(($author)?$author : '&nbsp')."</td>";
    echo "<td>" . (($published_Date) ? $published_Date : '&nbsp') . "</td>";
    echo "<td>$" . (($price) ? $price : '&nbsp') . "</td>";
    echo "<td>" . (($category) ? $category : '&nbsp') . "</td>";
    echo "<td>" . (($length) ? $length : '&nbsp') . "</td>";

    echo "<td><a href=\"details.php?id=" . $id . "\">Details</a> </td>";

    echo "</tr>";
}
?>
</table>

<a href=add.php>Add Item</a>