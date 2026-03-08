<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  2/15/2026
   * Filename:  index.php
 */
$pageName = "Home";
require "header.php";
?>
    <p>Hello! Welcome to my website. Click the links to navigate through resources and students.</p>
<?php
    $sql = "SELECT res_id, title FROM resources ORDER BY title";
//prepares a statement for execution
$stmt = $pdo->prepare($sql);

//exectues a prepared statement
$stmt ->execute();

//fetches the next row from a result set / returns an array
//default:  array indexed by both column name and 0-indexed column number
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h3> List of Resources</h3>
<?php
foreach ($result as $row) {
    echo "<a href='resview.php?q=". $row['res_id'] . "'>" . $row['title'] . "</a><br>";
}
?>
<?php
require "footer.php";
?>