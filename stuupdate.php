<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  4/15/2026
   * Filename:  stuupdate.php
 */
$pageName = "Update Student";
require "header.php";
check_login();

/* ***********************************************************************************************
 *  PART 2 - SET INITIAL VARIABLES
 *     SHOW FORM - Create a flag to allow us to show (default) or hide the form as appropriate.
 *     ERRORS - Create an empty array to handle the existence of errors.
 *     OTHERS - Create other variables, if necessary.
 *  ******************************************************************************************** */
$showForm = TRUE;
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['q'])) {
    $stu_id = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_NUMBER_INT);
} elseif ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['stu_id'])) {
    $stu_id= filter_input(INPUT_POST, 'stu_id', FILTER_SANITIZE_NUMBER_INT);
} else {
    echo "<p class='error'>Unable to procceed.</p>";
    include "footer.php";
    exit();
}
check_owner_admin($stu_id);
/* ***********************************************************************************************
*  PART 3 - PROCESS THE FORM UPON SUBMIT - THIS IS A *POST* FORM.  WOULD BE ALTERED FOR A *GET* FORM.
*  ******************************************************************************************** */
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    /* ***********************************************************************************************
     * PART 3.1 - TROUBLESHOOTING
     * Use print_r or var_dump for troubleshooting, but COMMENT OUT when done testing!
     * ******************************************************************************************** */
    // var_dump($_POST);
    /* ***********************************************************************************************
     * PART 3.2 - CREATE LOCAL VARIABLES
     *     Create a local variable for ALL form fields (except submit)
     *     Sanitize any text BOX values (such as first name, email, etc.) with trim()
     *     Leave passwords unaltered.
     * ******************************************************************************************** */
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $major = $_POST['major'];
    if (isset($_POST['standing'])) {
        $standing = $_POST['standing'];
    }
    $bio = $_POST['bio'];
    /* ***********************************************************************************************
     * PART 3.3 - ERROR CHECKING
     * Here, you are checking for:
     *     Missing values (where appropriate)
     *     Duplicates (if not allowed)
     *     Format errors (such as email, date, url, etc.)
     *     Restrictions (such as length requirements)
     *     Other requirements of your program
     * ******************************************************************************************** */
    if (empty($fname)) {
        $errors['fname'] = "Please enter a first name.";
    }
    if (empty($lname)) {
        $errors['lname'] = "Please enter a last name.";
    }
    //additional error checking goes here...
    if ($email != $_POST['emaildb']) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Please enter a valid email address.";
        } else {
            $sql = "SELECT email from students WHERE email = :field";
            $dupEmail = check_duplicates($pdo, $sql, $email);
            if ($dupEmail) {
                $errors['email'] = "Email is already associated with another student.";
            }
        }
    } // end if email is changed
    if (empty($standing)) {
        $errors['standing'] = "Please select a standing.";
    }
    if (empty($major)) {
        $errors['major'] = "Please select a major.";
    }
    if (empty($bio)) {
        $errors['bio'] = "Please enter a biography.";
    }
    /* ***********************************************************************************************
     * PART 3.4 - PROGRAM CONTROL
     * ******************************************************************************************** */
    // *** IF THERE ARE ERRORS ***
    if (!empty($errors)) {
        /* ***********************************************************************************************
         * PART 3.4a - PROGRAM CONTROL - ERRORS EXIST
         * The above if statement assumes array called $errors().  Modify as needed.
         *    Provide general message to user.
         *    Provide Specific messages are displayed in form.
         *    NOTE CSS CLASS .error created in Style Sheet
         * ******************************************************************************************** */
        echo "<p class='error'>Error(s) found. Please make the necessary changes and resubmit</p>";
    }
    //*** IF THERE ARE NO ERRORS ***
    else {
        /* ***********************************************************************************************
         * PART 3.4b - PROGRAM CONTROL - NO ERRORS EXIST
         *    Perform database actions (if applicable)
         *    Display user-friendly feedback of success. ALWAYS REQUIRED
         *    NOTE CSS CLASS .success created in Style Sheet
         *    HIDE THE FORM upon SUCCESS
        * ******************************************************************************************** */
        $sql = "UPDATE students SET fname = :fname, lname = :lname, email = :email, fk_mjr_id = :fk_mjr_id,
        standing = :standing, bio = :bio, updated = :updated WHERE stu_id = :stu_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':fname', $fname);
        $stmt->bindValue(':lname', $lname);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':fk_mjr_id', $major);
        $stmt->bindValue(':standing', $standing);
        $stmt->bindValue(':bio', $bio);
        $stmt->bindValue(':updated', date("Y-m-d H:i:s"));
        $stmt->bindValue(':stu_id', $stu_id);
        $stmt->execute();
        echo "<p class='success'>Update Successful.</p>";
        $showForm = FALSE; //Modify the value from true to false so the form is not displayed.
    }//*** END of ELSE statement to check for ERRORS
}//*** END of PROCESS THE FORM UPON SUBMIT
$sql = "SELECT * FROM students WHERE stu_id = :stu_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':stu_id', $stu_id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) {
    echo "<p class='error'>Student not found.</p>";
    $showForm = FALSE;
}
/* ***********************************************************************************************
 * PART 4 - FORM CODE
 *    Check to see if form should be displayed w/ if statement
 *    Provide useful paragraph to user with directions (expectations about required fields)
 *    CHANGE the METHOD to GET if not POST form
 *  ******************************************************************************************** */
if ($showForm) {
    ?>
    <p>Update student information. Email and password must meet requirements.</p>
    <form name="add_stu" id="add_stu" method="POST" action="<?php echo $currentFile; ?>">
        <label for="fname">First Name</label>
        <input type="text" name="fname" id="fname" value="<?php if (isset($fname)) {echo htmlspecialchars($fname);}
        else{echo htmlspecialchars($row['fname']);}?>">
        <br>
        <?php if (isset($errors['fname'])) { echo "<span class='error'>&#10006; " . $errors['fname'] . "</span>";}?>
        <br>
        <label for="lname">Last Name</label>
        <input type="text" name="lname" id="lname" value="<?php if (isset($lname)) {echo htmlspecialchars($lname);}
        else{echo htmlspecialchars($row['lname']);}?>">
        <br>
        <?php if (isset($errors['lname'])) { echo "<span class='error'>&#10006; " . $errors['lname'] . "</span>";}?>
        <br>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php if (isset($email)) {echo htmlspecialchars($email);}else
        {echo htmlspecialchars($row['email']);}?>">
        <br>
        <?php if (isset($errors['email'])) { echo "<span class='error'>&#10006; " . $errors['email'] . "</span><br>";}?>
        <br>
        <label for="major">Select a Major</label>
        <select name="major" id="major">
            <option value="" <?php if (isset($major) && $major =="") { echo " selected";}?>>CHOOSE A MAJOR</option>
            <?php
            $sql = "SELECT * FROM majors ORDER BY priority";
            $result = $pdo->query($sql);
            foreach ($result as $option) {
                echo "<option value='" .$option['mjr_id'] . "'";
                if (isset($major) && $major == $option['mjr_id']) { echo " selected";} elseif ($row['fk_mjr_id'] == $option['mjr_id']) {echo " selected";}
                echo ">".$option['prefix'] . " - " . $option['program'] . "</option>";
            }
            ?>
        </select>
        <br>
        <?php if (isset($errors['major'])) { echo "<span class='error'>&#10006; " . $errors['major'] . "</span><br>";}?>
        <br>
        <fieldset>
            <legend>Select the Class Standing</legend>
            <?php if (isset($errors['standing'])) { echo "<span class='error'>&#10006; " . $errors['standing'] . "</span><br>";}?>
            <input type="radio" name="standing" id="FR" value="FR" <?php if (isset($standing) && $standing == "FR") { echo "checked";} elseif ($row['standing'] == "FR") echo "checked"?>><label for="FR">Freshman</label><br>
            <input type="radio" name="standing" id="SO" value="SO" <?php if (isset($standing) && $standing == "SO") { echo "checked";} elseif ($row['standing'] == "SO") echo "checked"?>><label for="SO">Sophomore</label><br>
            <input type="radio" name="standing" id="JR" value="JR" <?php if (isset($standing) && $standing == "JR") { echo "checked";} elseif ($row['standing'] == "JR") echo "checked"?>><label for="JR">Junior</label><br>
            <input type="radio" name="standing" id="SR" value="SR" <?php if (isset($standing) && $standing == "SR") { echo "checked";} elseif ($row['standing'] == "SR") echo "checked"?>><label for="SR">Senior</label><br>
            <input type="radio" name="standing" id="OT" value="OT" <?php if (isset($standing) && $standing == "OT") { echo "checked";} elseif ($row['standing'] == "OT") echo "checked"?>><label for="OT">Other</label><br>
        </fieldset>
        <br>
        <label for="bio">Student Biography</label>
        <?php if (isset($errors['bio'])) { echo "<br><span class='error'>&#10006; " . $errors['bio'] . "</span><br>";}?>
        <br>
        <textarea name="bio" id="bio"><?php if (isset($bio)) {echo $bio;}
            else{echo $row['bio'];}?></textarea>
        <br>
        <input type="hidden" name="stu_id" id="stu_id" value="<?php echo $row['stu_id'];?>">
        <input type="hidden" name="emaildb" id="emaildb" value="<?php echo $row['email'];?>">
        <input type="submit" name="submit" id="submit" value="submit">
    </form>
    <?php
}//*** END of IF statement to SHOW FORM

/* ***********************************************************************************************
 *  PART 5 - PAGE SETUP - FOOTER USAGE
 *    Include your footer file with require
 *  ******************************************************************************************** */
require "footer.php";
?>
 