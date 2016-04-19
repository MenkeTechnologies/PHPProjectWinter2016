<?php
include 'connect.php';
?>

<form enctype="multipart/form-data" method="post" action="index.php"> 

    <input type="file" name="uploadedPaper"/>

    <input type="submit" value="Submit Your Own">    

</form>


<form method="post" action="index.php">

    <select name="paper">
        <option value="paper01.txt">EUNOMY: Evaluation of the Location-Identity Split</option>
        <option value="paper02.txt">On The Analysis of Compilers</option>
        <option value="paper03.txt">Decoupling Lamport Clocks from Superpages in Online Algorithms</option>
        <option value="paper04.txt">Collaborative Algorithms for Information Retrieval Systems</option>
        <option value="paper05.txt">Interposable Information</option>

    </select>

    <input type="submit" value="Submit">    

</form>


<?php

function getResults($file) { //main function for counting first number of numbers and calculating Benfords Law
    $pattern = "/\d{1,}\.?\d{1,}/";  //regular expression pattern

    $matches = array();

    $total = preg_match_all($pattern, $file, $matches); //get array of all numbers matching pattern
//initialize counters
    $d1 = 0;
    $d2 = 0;
    $d3 = 0;
    $d4 = 0;
    $d5 = 0;
    $d6 = 0;
    $d7 = 0;
    $d8 = 0;
    $d9 = 0;
    $numZeros = 0; //count of zero numbers to subtract from total results found so as to invalidate the numbers starting with 0

    foreach ($matches[0] as $key => $value) {  //loop thru array and count up the number of numbers starting with each digit
        switch ($value[0]) {

            case 0: $numZeros++;
                    break;
            case 1: $d1++;
                break;
            case 2: $d2++;
                break;
            case 3: $d3++;
                break;
            case 4: $d4++;
                break;
            case 5: $d5++;
                break;
            case 6: $d6++;
                break;
            case 7: $d7++;
                break;
            case 8: $d8++;
                break;
            case 9: $d9++;
                break;
            default: 
                break;
        }
    }

    $totalAfterZeros = $total - $numZeros;

    $result = ((($d1 / 0.301) + ($d2 / 0.176) + ($d3 / 0.125) + ($d4 / 0.097) + ($d5 / 0.079) //formula given on assignment but removing any numbers starting with zero
            + ($d6 / 0.067) + ($d7 / 0.058) + ($d8 / 0.051) + ($d9 / 0.046)) / 9) / $totalAfterZeros;



    $resultFormatted = number_format($result, 2);  //2 decimal plcaes on result

    echo "The total number of numbers in the document is $totalAfterZeros <br>"
    . "The total number of numbers starting with 1 is $d1<br>
        The total number of numbers starting with 2 is $d2<br>
        The total number of numbers starting with 3 is $d3<br>
         The total number of numbers starting with 4 is $d4<br>
         The total number of numbers starting with 5 is $d5<br>
         The total number of numbers starting with 6 is $d6<br>
         The total number of numbers starting with 7 is $d7<br>
         The total number of numbers starting with 8 is $d8<br>
         The total number of numbers starting with 9 is $d9<br>
         The result number is $resultFormatted. <br><br>";


    //analysis of data
    if ($result > 1.2) {
        echo "Suspect Data.";

        if ($result > 1.35 && $result < 1.45) { //result around 1.4
            echo "<br> Likely to be randomly generated.";
        }
    } else if ($result < 1.2 && $result > 0.8) {
        echo "Likely to be naturally-ocurring data.";
    }
}

//for preexisting papers on website

if (isset($_REQUEST['paper'])) {
    $selectedPaper = $_REQUEST['paper'];
    $selectedFileContentsDrop = file_get_contents($selectedPaper);

    getResults($selectedFileContentsDrop);
} else {

    $selectedPaper = '';
}

//for uploaded data

if (isset($_FILES['uploadedPaper'])) {


    if ($_FILES['uploadedPaper']['error'] != 4) {
        $uploadedFileContents = file_get_contents($_FILES['uploadedPaper']['tmp_name']);

        echo "Your uploaded file's results: <br>";
        getResults($uploadedFileContents);
    } else {
        echo "<font color = 'red'> No file uploaded </font>";
    }
}
?>