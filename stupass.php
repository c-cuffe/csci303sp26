<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  4/25/2026
   * Filename:  stupass.php
 */
$pageName = "Update Password";
require "header.php";
check_login();
$showForm = TRUE;
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $pwd = $_POST['pwd'];
    $pwd_c = $_POST['pwd_c'];
    if (strlen($pwd) < 15 || strlen($pwd) > 72) {
        $errors['pwd'] = "Please enter a password between 15 and 72 characters.";
    }
    if (empty($pwd_c)) {
        $errors['pwd_c'] = "Please enter confirmation password.";
    }
    if ($pwd !== $pwd_c) {
        $errors['pwd_c'] = "Passwords do not match.";
    }
    if (!empty($errors)) {
        echo "Errors found. Please resolve to continue.";
    }
    else {
        $sql = "UPDATE students SET pwd = :pwd, updated = :updated WHERE stu_id = :stu_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':pwd', password_hash($pwd, PASSWORD_DEFAULT));
        $stmt->bindValue(':updated',date("Y-m-d H:i:s"));
        $stmt->bindValue('stu_id', $_SESSION['stu_id']);
        $stmt->execute();
        header("Location: logout.php");
        exit();
    } // End of error checking
}// End of form if statement
if ($showForm) {
?>
<p>Update user password. After updating, you will be redirected to the logout page and will need to log in again.</p>
<form name="update_pwd" id="update_pwd" method="POST" action="<?php echo $currentFile; ?>">
    <label for="pwd">New Password</label>
    <input type="password" name="pwd" id="pwd" size="72" placeholder="Must be at least 15 and no more than 72 characters">
    <br>
    <?php if (isset($errors['pwd'])) { echo "<span class='error'>&#10006; " . $errors['pwd'] . "</span>";}?>
    <br>
    <label for="pwd_c">Confirm Password</label>
    <input type="password" name="pwd_c" id="pwd_c" size="72" placeholder="Must be at least 15 and no more than 72 characters">
    <br>
    <?php if (isset($errors['pwd_c'])) { echo "<span class='error'>&#10006; " . $errors['pwd_c'] . "</span>";}?>
    <br>
    <input type="submit" name="submit" id="submit" value="Submit">
</form>
<?php
} // Show form
require "footer.php";
?>