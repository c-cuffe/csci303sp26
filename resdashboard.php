<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  2/15/2026
   * Filename:  index.php
 */
$pageName = "Resources Dashboard";
require "header.php";
check_login();
echo "<a href='resadd.php'>Add Resource</a>";
if (isset($_GET['q'])){
    switch ($_GET['q']){
        case "ia": $sorting = "res_id ASC";
            break;
        case "id": $sorting = "res_id DESC";
            break;
        case "ta": $sorting = "title ASC";
            break;
        case "td": $sorting = "title DESC";
            break;
        default: $sorting = "title";
    }
}else {
    $sorting = "title";
}
?>

<?php
$sql = "SELECT res_id, title, fk_stu_id FROM resources ORDER BY $sorting";
//prepares a statement for execution
$stmt = $pdo->prepare($sql);
//exectues a prepared statement
$stmt ->execute();
//fetches the next row from a result set / returns an array
//default:  array indexed by both column name and 0-indexed column number
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<table><tr><th>View</th><th>Update</th><th>Delete</th>
        <th>ID<a href="<?php echo $currentFile;?>?q=ia">&#11165;</a>
            <a href="<?php echo $currentFile;?>?q=id">&#11167;</a></th>
        <th>Title<a href="<?php echo $currentFile;?>?q=ta">&#11165;</a>
            <a href="<?php echo $currentFile;?>?q=td">&#11167;</a></th></tr>
<?php
foreach ($result as $row) {
    echo "<tr><td><a href='resview.php?q=". $row['res_id'] . "'>View</a></td>";
    echo "<td>";
    if(isset($_SESSION['stu_id']) && ($_SESSION['stu_id'] == $row['fk_stu_id'])) {
        echo "<a href='resupdate.php?q=" . $row['res_id'] . "'>Update</a>";}
    echo "</td>";
    echo "<td>";
    if(isset($_SESSION['stu_id']) && ($_SESSION['stu_id'] == $row['fk_stu_id'] || $_SESSION['access'] == 1)) {
            echo "<a href='resdelete.php?q=". $row['res_id'] . "'>Delete</a>";}
    echo "</td>";
    echo "<td>" . $row['res_id'] . "</td>";
    echo "<td>" . $row['title'] . "</td></tr>";
}
?>
</table>
<?php
require "footer.php";
?>