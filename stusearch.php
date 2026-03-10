<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  3/9/2026
   * Filename:  stusearch.php
 */
$pageName = "Search Students";
require "header.php";
?>
<p> Please enter the beginning of the student's name.</p>
<form name="stusearch" id="stusearch" method="get" action="<?php echo $currentFile;?>">
    <label for="term">Student Name</label>
    <input type="search" id="term" name="term">
    <input type="submit" id="search" name="search" value="Search">
</form>
<?php
if (isset($_GET['term'])) {
    if (empty($_GET['term'])) {
        echo "<p class='error'>No search term was entered. Please make an entry and try again.</p>";
    } else {
        echo "<p>Searching for ". htmlspecialchars($_GET['term']). "</p>";
        $term = $_GET['term'] . "%"; //append wildcard character
        $sql = "SELECT stu_id, fname, email
                FROM students
                WHERE fname LIKE :term
                ORDER BY fname";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':term', $term);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$result) {
            echo "<p class='error'>No results found.</p>";
        } else {
            echo "<p class='success'>This search returned the following results:</p>";
            foreach ($result as $row) {
                echo "<a href='stuview.php?q={$row['stu_id']}' target='_blank'>{$row['fname']} - {$row['email']}</a><br>";
            } // end of foreach
        } // else if there are results
    } // if empty
} // isset search
require "footer.php" ?>