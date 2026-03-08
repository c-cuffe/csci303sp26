<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  2/15/2026
   * Filename:  select2.php
 */

$pageName = "Select 3 - Fetch (Associative Array)";
require "header.php";

//query the data
$sql = "SELECT * FROM students ORDER BY fname";

//prepares a statement for execution
$stmt = $pdo->prepare($sql);

//exectues a prepared statement
$stmt ->execute();

//fetches the next row from a result set / returns an array
//default:  array indexed by both column name and 0-indexed column number
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<h3>Contents of print_r($row):</h3>
<?php
print_r($row);
?>
<h3>Displaying Data to the Screen</h3>
<?php
//display the single result to the screen
echo $row['stu_id'] . " - " . $row['fname'];

require "footer.php";
?>
 