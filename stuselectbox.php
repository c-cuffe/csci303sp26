<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  3/23/2026
   * Filename:  stuselectbox.php
 */
 $pageName = "Dynamic Student Select";
 require "header.php";
?>
<p>Search for a student by first name.</p>
<label for="stuselect">Dynamic Select</label>
<select name="stu_sel" id="stu_sel">
<option value="">Choose a Student</option>
<?php
$sql = "SELECT stu_id, fname, email FROM students ORDER BY fname, email";
$result = $pdo->query($sql);
foreach ($result as $row) {
    echo "<option value='" . $row['stu_id'] . "'>" . $row['fname'] . "-" . $row['email'] . "</option>";
}
?>
</select>
<?php
require "footer.php";
?>
