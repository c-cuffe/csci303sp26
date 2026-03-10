<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  3/9/2026
   * Filename:  stuview.php
 */
$pageName = "Student Resource";
require "header.php";
?>
<?php
$sql = "SELECT * 
        FROM students INNER JOIN majors
        ON students.fk_mjr_id = majors.mjr_id
        WHERE stu_id = :stu_id
        ORDER BY fname";
$stmt = $pdo->prepare($sql);
$stu_id = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_NUMBER_INT);
$stmt->bindValue(':stu_id', $stu_id);
$stmt ->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$row) {
    echo "<p class='error'>Uh oh! We could not find what you are looking for.</p>";
}
else {
?>
    <table>
        <tr><th>Student ID</th><td><?php echo $row['stu_id'];?></td></tr>
        <tr><th>First Name</th><td><?php echo $row['fname'];?></td></tr>
        <tr><th>Email</th><td><?php echo $row['email'];?></td></tr>
        <tr><th>Program</th><td><?php echo $row['program'];?></td></tr>
        <tr><th>Class Standing</th><td><?php echo $row['standing'];?></td></tr>
        <tr><th>Biography</th><td><?php echo $row['bio'];?></td></tr>
        <tr><th>Access Level</th><td><?php if($row['access'] == 0){echo "Regular Access";}else{echo "Admin Access";} ?></td></tr>
        <tr><th>Date Added</th><td><?php echo $row['added'];?></td></tr>
        <tr><th>Last Updated</th><td><?php echo $row['updated'];?></td></tr>

    </table>
<?php
}
require "footer.php" ?>