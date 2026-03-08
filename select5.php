<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  2/15/2026
   * Filename:  select2.php
 */

$pageName = "Select 5 - Select Appropriate Fields";
require "header.php";

//query the data
$sql = "SELECT stu_id, fname FROM students ORDER BY fname";

//prepares a statement for execution
$stmt = $pdo->prepare($sql);

//exectues a prepared statement
$stmt ->execute();

//fetches the next row from a result set / returns an array
//default:  array indexed by both column name and 0-indexed column number
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<h3>Contents of print_r($row):</h3>
<?php
print_r($result);
?>
<h3>Displaying Data to the Screen</h3>
<?php
//loop through and display the results
foreach ($result as $row) {
    echo $row['stu_id'] . " - " . $row['fname'] . "<br>";
}

//loop through and display the results AGAIN - NOTHING WILL BE DISPLAYED!
foreach ($result as $row) {
    echo $row['stu_id'] . " - " . $row['fname'] . "<br>";
}

require "footer.php";
?>
 