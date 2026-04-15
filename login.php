<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  4/9/2026
   * Filename:  login.php
 */

// LOGIN SP26 - COPY/PASTE THIS ENTIRE CODE (INCLUDING THIS COMMENT) AFTER YOUR INITIAL COMMENTS.

$pageName = "Log In";
require "header.php";

$showForm = TRUE;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //CREATE LOCAL VARIABLES
    $email = trim($_POST['email']);
    $pwd = $_POST['pwd'];

    //ERROR CHECKING
    if (empty($email)) {
        $errors['email'] = "Please enter an email address.";
    }
    if (empty($pwd)) {
        $errors['pwd'] = "Please enter a password.";
    }

    //PROGRAM CONTROL
    if (!empty($errors)) {
        echo "<p class='error'>Please fill in all fields.</p>";
    } else {
        $sql = "SELECT * FROM students WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch();

        if(!$row){
            echo "<p class='error'>The user was not found.</p>";
        }else {
            if (password_verify($pwd, $row['pwd'])) {
                $_SESSION['stu_id'] = $row['stu_id'];
                $_SESSION['fname'] = $row['fname'];
                $_SESSION['access'] = $row['access'];
                header("Location: confirm.php");
            } else {
                echo "<p class='error'>The password does not match our records.</p>";
            }//else pwd verify
        }//if not row
    } // else errors
}//*** END of PROCESS THE FORM UPON SUBMIT
if ($showForm) {
?>
<p>Please use this form to register.  All fields are required.</p>

<form name="login" id="login" method="POST" action="<?php echo $currentFile; ?>">

    <label for="email">Email</label>
    <input type="email" name="email" id="email" value="<?php if (isset($email)) { echo htmlspecialchars($email);}?>">
    <?php if (isset($errors['email'])) { echo "<br><span class='error'>&#9888; {$errors['email']}</span>"; } ?>
    <br><br>

    <label for="pwd">Password</label><input type="password" name="pwd" id="pwd" size="16" placeholder="15-72 characters">
    <?php if (isset($errors['pwd'])) { echo "<br><span class='error'>&#9888; {$errors['pwd']}</span>"; } ?>
    <br><br>

    <input type="submit" name="submit" id="submit" value="submit">
</form>
<?php
}//*** END of IF statement to SHOW FORM

require "footer.php";

