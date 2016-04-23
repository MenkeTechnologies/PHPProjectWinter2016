
<a href=index.php>Back</a>

<?php
include 'connect.php';
if (isset($_REQUEST['title'])) {

    $titleAdd = @$_REQUEST['title'];
    $authorAdd = @$_REQUEST['author'];

    $rawDate = strtotime(@$_REQUEST['publishedDate']);
    $published_DateAdd = date('Y-m-d', $rawDate);
    $descriptionAdd = @$_REQUEST['description'];
    $priceAdd = floatval(@$_REQUEST['price']);
    $categoryAdd = @$_REQUEST['category'];
    $lengthAdd = @$_REQUEST['length'];



    if ($titleAdd == "" || $authorAdd == "" || $published_DateAdd == "" || $lengthAdd == "") {

        echo "<font color = 'red'>Title, author, published date and length cannot be null</font>";
    } else if ($rawDate == FALSE) {
        echo "<font color = 'red'>Invalid Date</font>";
    } else {



        $sqlAdd = "insert into tutorials (title,author,published_date,description,price,category,length)
        values ('$titleAdd','$authorAdd','$published_DateAdd','$descriptionAdd',$priceAdd,'$categoryAdd',$lengthAdd);";

        $result = $pdo->query($sqlAdd);

//    echo "the sql is $sqlAdd";
//    echo "the price is $priceAdd";
        header("Location:index.php");

    }
}
?>

<form method="request" action="add.php">

    <table border="4">
        <tr>
            <th colspan='2'>Add Listing</th>
        </tr>
        <tr> <td>Title</td> <td><input type="text" name="title"> </td> </tr>
        <tr> <td>Author</td> <td><input type="text" name="author"></td> </tr>
        <tr> <td> Published Date</td> <td><input type="text" name="publishedDate"> </td> </tr>
        <tr> <td>Description</td> <td>​<textarea name="description" rows="10" cols="18"></textarea></td> </tr>

        <tr> <td>Price</td> <td><input type="text" name="price"></td> </tr>

        <tr> <td>Category</td> <td>
                <input type="radio" name="category" value="programming" checked> Programming<br>
                <input type="radio" name="category" value="CAD"> CAD<br>
                <input type="radio" name="category" value="OS">OS
                <input type="radio" name="category" value="Networking">Networking<br>
                <input type="radio" name="category" value="Productivity">Productivity

            </td> </tr>

        <tr> <td>Length in Minutes</td> <td><input type="text" name="length"></td> </tr>

        <tr> <td>  <input type="submit" value="Add"> </td> <td> &nbsp;</td></tr>

    </table>

</form>
