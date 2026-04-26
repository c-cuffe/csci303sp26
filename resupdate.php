<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  4/15/2026
   * Filename:  resupdate.php
 */
$pageName = "Update Resource";
require "header.php";
check_login();
// Initial variables
$showForm = TRUE;
$errors = [];
// Track resources being modified
if ($_SERVER['REQUEST_METHOD'] == "GET" && isset ($_GET['q'])) {
    $res_id = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_NUMBER_INT);
} elseif ($_SERVER['REQUEST_METHOD'] == "POST" && isset ($_POST['res_id'])) {
    $res_id = filter_input(INPUT_POST, 'res_id', FILTER_SANITIZE_NUMBER_INT);
} else {
    echo "<p class='error'>Unable to proceed.</p>";
    include "footer.php";
    exit();
}
// Form processing
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //print_r($_POST);

    //Local variables
    $title = trim($_POST['title']);
    $url = $_POST['url'];
    $description = $_POST['description'];

// Error checking
    if (empty($title)) {
        $errors['title'] = "Please enter a title.";
    } elseif ($title != $_POST['titledb']) {
        $sql = "SELECT title from resources WHERE title = :field";
        $dupTitle = check_duplicates($pdo, $sql, $title);
        if ($dupTitle) {
            $errors['title'] = "Title is already associated with another resource.";
        }
    }
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        $errors['url'] = "Please enter a valid url.";
    }
    if (empty($description)) {
        $errors['description'] = "Please enter a description.";
    }
    // Form control
    if (!empty($errors)) {
        echo "<p class='error'>Error(s) found. Please make the necessary changes and resubmit</p>";
    } else {
        $sql = "UPDATE resources SET title = :title, url = :url, description = :description, updated = :updated 
                WHERE res_id = :res_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':url', $url);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':updated', date("Y-m-d H:i:s"));
        $stmt->bindValue(':res_id', $res_id);
        $stmt->execute();
        echo "<p class='success'>Update Successful.</p>";
        $showForm = FALSE;
    } // End error checking
} // End form processing
// Form code
// Query table for existing resource and determine owner
$sql = "SELECT * FROM resources WHERE res_id = :res_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':res_id', $res_id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) {
    echo "<p class='error'>Resource not found.</p>";
    $showForm = FALSE;
}
// Verify owner
check_owner($row['fk_stu_id']);
// Display form
if ($showForm) {
    ?>
<p>Update resource information. All fields are required.</p>

<form name="add_res" id="add_res" method="POST" action="<?php echo $currentFile; ?>">
    <label for="title">Title</label>
    <input type="text" name="title" id="title" value="<?php if (isset($title)) {echo htmlspecialchars($title);}
    else{echo htmlspecialchars($row['title']);}?>">
    <br>
    <?php if (isset($errors['title'])) { echo "<span class='error'>&#10006; " . $errors['title'] . "</span>";}?>
    <br>
    <label for="url">URL</label>
    <input type="url" name="url" id="url" value="<?php if (isset($url)) {echo htmlspecialchars($url);}
    else{echo htmlspecialchars($row['url']);}?>">
    <br>
    <?php if (isset($errors['url'])) { echo "<span class='error'>&#10006; " . $errors['url'] . "</span><br>";}?>
    <label for="description">Description</label>
    <br>
    <?php if (isset($errors['description'])) { echo "<span class='error'>&#10006; " . $errors['description'] . "</span><br>";}?>
    <textarea name="description" id="description"><?php if (isset($description)) {echo $description;}
        else{echo $row['description'];}?></textarea>
    <br>
    <input type="hidden" name="titledb" id="titledb" value="<?php echo $row['title'];?>">
    <input type="hidden" name="res_id" id="res_id" value="<?php echo $row['res_id'];?>">
    <input type="submit" name="submit" id="submit" value="Submit">
</form>
<?php
} // end show form
require "footer.php";
?>