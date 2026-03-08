<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  2/15/2026
   * Filename:  select1.php
 */
$pageName = "Select 1 - Simple Query";
require "header.php";

//query the data
$sql = "SELECT * FROM students ORDER BY fname";

//execute the query
$result = $pdo->query($sql);

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