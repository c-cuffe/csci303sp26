<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  2/15/2026
   * Filename:  index.php
 */
$pageName = "Student Dashboard";
require "header.php";
?>

<?php
$sql = "SELECT stu_id, fname FROM students ORDER BY fname";
//prepares a statement for execution
$stmt = $pdo->prepare($sql);
//exectues a prepared statement
$stmt ->execute();
//fetches the next row from a result set / returns an array
//default:  array indexed by both column name and 0-indexed column number
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<table><tr><th>View</th><th>Update</th><th>ID</th><th>First Name</th></tr>
<?php
foreach ($result as $row) {
    echo "<tr><td><a href='stuview.php?q=". $row['stu_id'] . "'>View</a></td>";
    echo "<td><a href='stuupdate.php?q=". $row['stu_id'] . "'>Update</a></td>";;
    echo "<td>" . $row['stu_id'] . "</td>";
    echo "<td>" . $row['fname'] . "</td></tr>";
}
?>
</table>
<?php
require "footer.php";
?>