<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  4/15/2026
   * Filename:  resadd.php
 */
$pageName = "Add Resource";
require "header.php";
check_login();
$showForm = TRUE;
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = trim($_POST['title']);
    $url = $_POST['url'];
    $description= $_POST['description'];
    if (empty($title)) {
        $errors['title'] = "Please enter a title.";
    } else {
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
    if (!empty($errors)) {
        echo "<p class='error'>Error(s) found. Please make the necessary changes and resubmit</p>";
    } else {
        $sql = "INSERT INTO resources (fk_stu_id, title, url, description) 
        VALUES (:fk_stu_id, :title, :url, :description)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':fk_stu_id', $_SESSION['stu_id']);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':url', $url);
        $stmt->bindValue(':description', $description);
        $stmt->execute();
        echo "<p class='success'>Submission Successful.</p>";
        $showForm = FALSE; //Modify the value from true to false so the form is not displayed.
    }

}
if ($showForm) {
    ?>
    <p>Enter a new resource.</p>

    <form name="add_res" id="add_res" method="POST" action="<?php echo $currentFile; ?>">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="<?php if (isset($title)) {echo htmlspecialchars($title);}?>">
        <br>
        <?php if (isset($errors['title'])) { echo "<span class='error'>&#10006; " . $errors['title'] . "</span>";}?>
        <br>
        <label for="url">URL</label>
        <input type="url" name="url" id="url" value="<?php if (isset($url)) {echo htmlspecialchars($url);}?>">
        <br>
        <?php if (isset($errors['url'])) { echo "<span class='error'>&#10006; " . $errors['url'] . "</span><br>";}?>
        <label for="description">Description</label>
        <br>
        <?php if (isset($errors['description'])) { echo "<span class='error'>&#10006; " . $errors['description'] . "</span><br>";}?>
        <textarea name="description" id="description"><?php if (isset($description)) {echo $description;}?></textarea>
        <br>
        <input type="submit" name="submit" id="submit" value="submit">
    </form>
    <?php
}

require "footer.php";
?>

 