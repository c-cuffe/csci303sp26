<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  3/9/2026
   * Filename:  resview.php
 */
$pageName = "View Resource";
require "header.php";
$sql = "SELECT res_id, fname, title, description, url, fk_stu_id, resources.added as radd, resources.updated as rupd 
        FROM resources INNER JOIN students
        ON resources.fk_stu_id = students.stu_id
        WHERE res_id = :res_id
        ORDER BY res_id";
$stmt = $pdo->prepare($sql);
$res_id = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_NUMBER_INT);
$stmt->bindValue(':res_id', $res_id);
$stmt ->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$row) {
    echo "<p class='error'>Uh oh! We could not find what you are looking for.</p>";
}
else {
    ?>
    <table>
        <tr><th>Resource ID</th><td><?php echo $row['res_id'];?></td></tr>
        <tr><th>Student Contributor</th><td><?php echo "<a href='https://ccuresearch.coastal.edu/cecuffe/csci303sp26/stuview.php?q={$row["fk_stu_id"]}' target='_blank'>{$row['fname']}</a>"?></td></tr>
        <tr><th>Title</th><td><?php echo $row['title'];?></td></tr>
        <tr><th>URL</th><td><?php echo "<a href='{$row["url"]}' target='_blank'>{$row['url']}</a>"?></td></tr>
        <tr><th>Description</th><td><?php echo $row['description'];?></td></tr>
        <tr><th>Date Added</th><td><?php echo $row['radd'];?></td></tr>
        <tr><th>Last Updated</th><td><?php echo $row['rupd'];?></td></tr>

    </table>
    <?php
}
require "footer.php" ?>