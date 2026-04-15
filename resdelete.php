<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  4/15/2026
   * Filename:  resdelete.php
 */
$pageName = "Delete Resource";
require "header.php";
check_login();
$showForm = TRUE;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $sql = "DELETE FROM resources WHERE res_id = :res_id";
    $stmt = $pdo->prepare($sql);
    $res_id = filter_input(INPUT_POST, 'res_id', FILTER_SANITIZE_NUMBER_INT);
    $stmt->bindValue(':res_id', $res_id);
    $stmt->execute();
    echo "<p class='success'>" . htmlspecialchars($_POST['title']) . " was successfully deleted.</p>";
    $showForm = FALSE;
}
if($_SERVER['REQUEST_METHOD'] == "GET") {
    $sql = "SELECT res_id, fk_stu_id, title from resources WHERE res_id = :res_id";
    $stmt = $pdo->prepare($sql);
    $res_id = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_NUMBER_INT);
    $stmt->bindValue(':res_id', $res_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$row) {
        echo "<p class='error'>Sorry! Resource not found.</p>";
    } else {
    check_owner_admin($row['fk_stu_id']);
    }
}
if ($showForm){
?>
    <p>Please confirm you want to delete <strong><?php echo $row['title']?></strong> or
    return to <a href="resdashboard.php">Resource Dashboard</a> to cancel.</p>
    <form id="delete" name="delete" method="POST" action="<?php echo $currentFile;?>">
        <input type="hidden" id="res_id" name="res_id" value="<?php echo $row['res_id']?>">
        <input type="hidden" id="title" name="title" value="<?php echo $row['title']?>">
        <input type="submit" id="delete" name="delete" value="CONFIRM DELETE">
    </form>
<?php
}

require "footer.php";
?>