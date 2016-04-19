<?php

session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$id = $_GET['id'];

include 'connect.php';
$_SESSION['id'] = $id;




$sql1 = "select * from tutorials where id=" . intval($id);
$result = $pdo->query($sql1);
?>


<a href=index.php>Back to Main View</a>
<a href=edit.php?id=<?=$id?>>Edit This Record</a>
<a href=delete.php>Delete This Record</a>
<h1>Detail View</h1>

<table border = "2" cellpadding = "5" cellspacing="5">
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Published Date</th>
        <th>Description</th>
        <th>Price</th>
        <th>Category</th>
        <th>Length</th>

    </tr>

<?php
$row = $result->fetch(PDO::FETCH_ASSOC);
$title = $row['title'];
    $author = $row['author'];
    $published_Date = date("M d Y",  strtotime($row['published_date']));
$description = $row['description'];
    $price = $row['price'];
    $category = $row['category'];
    $length = $row['length'];
    
echo "<tr>";
    echo "<td>" . (($title) ? $title : '&nbsp') . "</td>";
    echo "<td>".(($author)?$author : '&nbsp')."</td>";
    echo "<td>" . (($published_Date) ? $published_Date : '&nbsp') . "</td>";
    echo "<td>" . (($description) ? $description : '&nbsp') . "</td>";
    echo "<td>" . (($price) ? $price : '&nbsp') . "</td>";
    echo "<td>" . (($category) ? $category : '&nbsp') . "</td>";
    echo "<td>" . (($length) ? $length : '&nbsp') . "</td>";
echo"</tr>";





echo "</table>";

