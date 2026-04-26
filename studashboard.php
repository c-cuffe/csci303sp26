<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  2/15/2026
   * Filename:  index.php
 */
$pageName = "Student Dashboard";
require "header.php";
check_login();
echo "<a href='stupass.php'>Update User Password</a>";
if (isset($_GET['q'])){
    switch ($_GET['q']){
        case "ia": $sorting = "stu_id ASC";
        break;
        case "id": $sorting = "stu_id DESC";
        break;
        case "fa": $sorting = "fname ASC";
        break;
        case "fd": $sorting = "fname DESC";
        break;
        case "la": $sorting = "lname ASC";
            break;
        case "ld": $sorting = "lname DESC";
            break;
        default: $sorting = "fname";
    }
}else {
    $sorting = "fname";
}
?>

<?php
$sql = "SELECT stu_id, fname, lname FROM students ORDER BY $sorting";
//prepares a statement for execution
$stmt = $pdo->prepare($sql);
//exectues a prepared statement
$stmt ->execute();
//fetches the next row from a result set / returns an array
//default:  array indexed by both column name and 0-indexed column number
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<table><tr>
        <th>View</th>
        <th>Update</th>
        <th>ID<a href="<?php echo $currentFile;?>?q=ia">&#11165;</a>
            <a href="<?php echo $currentFile;?>?q=id">&#11167;</a></th>
        <th>First Name<a href="<?php echo $currentFile;?>?q=fa">&#11165;</a>
            <a href="<?php echo $currentFile;?>?q=fd">&#11167;</a></th>
        <th>Last Name<a href="<?php echo $currentFile;?>?q=la">&#11165;</a>
            <a href="<?php echo $currentFile;?>?q=ld">&#11167;</a></th></tr>
<?php
foreach ($result as $row) {
    echo "<tr><td><a href='stuview.php?q=". $row['stu_id'] . "'>View</a></td>";
    echo "<td>";
    if ($_SESSION['stu_id'] == $row['stu_id'] || $_SESSION['access'] == 1) {
        echo "<a href='stuupdate.php?q=". $row['stu_id'] . "'>Update</a>";}
    echo "</td>";
    echo "<td>" . $row['stu_id'] . "</td>";
    echo "<td>" . $row['fname'] . "</td>";
    echo "<td>" . $row['lname'] . "</td></tr>";
}
?>
</table>
<?php
require "footer.php";
?>