
<?php
include 'connect.php';

$Numeric = true;


if (isset($_POST['zipCode'])) { //get Name Search Text Field Data when form submitted
    $zipCode = $_POST['zipCode'];
} else {
    $zipCode = "";
}
?>

<img src="chipmunk.jpg" alt="chipmunk playing trumpet" border="1">
<!--<h1>Michigan Association of Independent Music Educators Search </h1>-->


<form method='post' action='index.php'>
    Enter a zip code: <input type="text" name='zipCode' value="<?= (($zipCode) ? $zipCode : '') ?>" size="5">
    <input type="submit" value="Search">




    <?php
    if (is_numeric($zipCode) == false && $zipCode != "") { //error message when not integer
        echo "Not a valid zipcode";
        $Numeric = false;
    }

    if ($zipCode != "" && $Numeric == true) {  //if zipcode is valid then query with this zipcode
        $sql = "select * from a5_locations where zipcode=" . $zipCode;
        $result = $pdo->query($sql);

        $sqlCountSearch = "select count(*) from (
    select * from a5_locations where zipcode=" . $zipCode . ") a5_locations";
        $resultCountSearch = $pdo->query($sqlCountSearch);
        $rowCountSearch = $resultCountSearch->fetch(PDO::FETCH_ASSOC);
        $locationFoundCount = $rowCountSearch['count(*)']; //store  number of locations found

        if ($locationFoundCount == 0) {
            echo "<font color = 'red'>No location found with zip code " . $zipCode . "</font>"; // if not locations found then not zipcode in MI so output error message
        }
    }
    ?>

</form>


<?php
if ($zipCode != "" && $Numeric == true && $locationFoundCount != 0) {  //only display initial table if valid zipcode in MI
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $zipCodeSearch = $row['zipcode'];  //get data from sql query
        $locationNameSearch = $row['location_name'];
        $stateSearch = $row['state'];

        $selectedZipLat = $row['latitude'];
        $selectedZipLong = $row['longitude'];

        echo "<table border='2' padding='5'>
                <tr>
                 <th>Zip Code</th>
                 <th>Location</th>
                 <th>State</th>

                </tr>

                 <td>" . $zipCodeSearch . "</td>
                 <td>" . $locationNameSearch . "</td>
                 <td>" . $stateSearch . ".</td>
                </table>
                <hr> ";
    }

//second sql query with selected zipcode's latitude and longitutde to get information for table
    $sql2 = "select l.state, l.location_name, 
l.zipcode, l.longitude, l.latitude,
(69.0 *sqrt(pow((l.longitude-($selectedZipLong)),2) + pow((l.latitude-$selectedZipLat),2))) as distance,  
p.provider_number, p.person_name,
group_concat(t.subject_label order by t.subject_label separator ', ') from a5_locations as l
join a5_people as p on p.locationID = l.locationID
join a5_people_subject as s on s.personID = p.personID
join a5_subject as t on t.subjectID = s.subjectID
where (69.0 *sqrt(pow((l.longitude-($selectedZipLong)),2) + pow((l.latitude-$selectedZipLat),2)) < 25.0) group by p.personID order by distance, p.provider_number;";
//using distance formula

    $result2 = $pdo->query($sql2);
    
//third sql query to get count of results from sql query
    $sql3 = "select count(*) from ( 
select l.state, l.location_name,
l.zipcode, l.longitude, l.latitude,
(69.0 *sqrt(pow((l.longitude-($selectedZipLong)),2) + pow((l.latitude-$selectedZipLat),2))) as distance,
p.provider_number, p.person_name,
group_concat(t.subject_label order by t.subject_label separator ', ') from a5_locations as l
join a5_people as p on p.locationID = l.locationID
join a5_people_subject as s on s.personID = p.personID
join a5_subject as t on t.subjectID = s.subjectID
where (69.0 *sqrt(pow((l.longitude-($selectedZipLong)),2) + pow((l.latitude-$selectedZipLat),2)) < 25.0) group by p.personID order by distance, p.provider_number
) a5_locations;";
//using distance formula
    
    $result3 = $pdo->query($sql3);
    $row3 = $result3->fetch(PDO::FETCH_ASSOC);

    $numPeople = $row3['count(*)'];

    if ($numPeople > 1) {
        echo $numPeople . " people were found within 25 miles";
    } else if ($numPeople = 1) {
        echo $numPeople . " person was found within 25 miles";
    } else {
        echo "No people were found within 25 miles";
    }

//create table header and columns
    echo "<br><br>

<table  border='1' >
        <col width = 135>
        <col width = 100>
        <col width = 275>
        <col width = 150>
        <col width = 40>
        <col width = 75>
        <col width = 100>
        
                <tr>
                 <th>Name</th>
                 <th>Provider #</th>
                 <th>Subjects</th>
                 <th>City</th>
                <th>State</th>
                <th>Zip Code</th>
                <th>Distance (mi)</th>
                </tr>";
//fill table with data
    while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {


        $nameResult = $row2['person_name'];
        $providerResult = $row2['provider_number'];
        $subjectsResult = $row2['group_concat(t.subject_label order by t.subject_label separator \', \')'];
        $cityResult = $row2['location_name'];
        $stateResult = $row2['state'];
        $zipCodeResult = $row2['zipcode'];
        $distance = number_format($row2['distance'], 1);



        echo
        "        <tr>

                 <td>" . $nameResult . "</td>
                 <td>" . $providerResult . "</td>
                 <td>" . $subjectsResult . "</td>
                     <td>" . $cityResult . "</td>
                         <td>" . $stateResult . "</td>
                             <td>" . $zipCodeResult . "</td>
                                 <td>" . $distance . "</td>
                                 
                             </tr>";
    }
    echo "</table>";
}
?>




