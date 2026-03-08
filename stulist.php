<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  2/15/2026
   * Filename:  select2.php
 */

$pageName = "Student List";
require "header.php";

//query the data
$sql = "SELECT * FROM students ORDER BY fname";

//prepares a statement for execution
$stmt = $pdo->prepare($sql);

//exectues a prepared statement
$stmt ->execute();

//fetches the next row from a result set / returns an array
//default:  array indexed by both column name and 0-indexed column number
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<h3>Displaying Data to the Screen</h3>
<?php
//loop through and display the results
foreach ($result as $row) {
    echo "<a href='stuview.php?q=". $row['stu_id'] . "'>" . $row['fname'] . "</a><br>";
}

require "footer.php";
?>
 