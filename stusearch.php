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
        echo "<p>No term entered. Please try again?</p>";
    } else {
        $term = $_GET['term'] . "%"; //append wildcard character
        $sql = "SELECT fname
                FROM students
                WHERE fname LIKE :term
                ORDER BY fname";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':term', $term);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$result) {
            echo "<p>We could not find any results.</p>";
        } else {
            echo "<p>We found the following results:</p>";
            foreach ($result as $row) {
                echo $row['fname'] . "<br>";
            } // end of foreach
        } // else if there are results
    } // if empty
} // isset search
require "footer.php" ?>