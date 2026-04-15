<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  3/23/2026
   * Filename:  stuadd.php
 */

/* ***********************************************************************************************
 * READ ALL COMMENTS CAREFULLY!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 * Course lessons will eventually cover all parts of this form.
 *
 * SP26 BASIC FORM TEMPLATE - COPY THIS ENTIRE PAGE AFTER YOUR INITIAL COMMENTS
 * Modify any part that says "CHANGE_THIS"
 * Variable names are examples and can be modified (e.g. $showForm & $pageName)
 *
 * *********************************************************************************************
 *  PART 1 - PAGE SETUP - HEADER USAGE
 *     Create a variable for a user-friendly name of the page (e.g.  $pageName)
 *     Include your header file with require
 *  ******************************************************************************************** */

$pageName = "Create New Student";
require "header.php";

/* ***********************************************************************************************
 *  PART 2 - SET INITIAL VARIABLES
 *     SHOW FORM - Create a flag to allow us to show (default) or hide the form as appropriate.
 *     ERRORS - Create an empty array to handle the existence of errors.
 *     OTHERS - Create other variables, if necessary.
 *  ******************************************************************************************** */
$showForm = TRUE;
$errors = [];
//add additional initial variables here, when needed

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
        $email = trim($_POST['email']);
        $pwd = $_POST['pwd'];
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
        //additional error checking goes here...
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Please enter a valid email address.";
        } else {
            $sql = "SELECT email from students WHERE email = :field";
            $dupEmail = check_duplicates($pdo, $sql, $email);
            if ($dupEmail) {
                $errors['email'] = "Email is already associated with another student.";
            }
        }
        if (strlen($pwd) < 15 || strlen($pwd) > 72) {
            $errors['pwd'] = "Please enter a password between 15 and 72 characters.";
        }
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
        $sql = "INSERT INTO students (fname, email, pwd, fk_mjr_id, standing, bio) 
        VALUES (:fname, :email, :pwd, :fk_mjr_id, :standing, :bio)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':fname', $fname);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':pwd', password_hash($pwd, PASSWORD_DEFAULT));
        $stmt->bindValue(':fk_mjr_id', $major);
        $stmt->bindValue(':standing', $standing);
        $stmt->bindValue(':bio', $bio);
        $stmt->execute();
        echo "<p class='success'>Submission Successful.</p>";
        $showForm = FALSE; //Modify the value from true to false so the form is not displayed.

    }//*** END of ELSE statement to check for ERRORS
}//*** END of PROCESS THE FORM UPON SUBMIT

/* ***********************************************************************************************
 * PART 4 - FORM CODE
 *    Check to see if form should be displayed w/ if statement
 *    Provide useful paragraph to user with directions (expectations about required fields)
 *    CHANGE the METHOD to GET if not POST form
 *  ******************************************************************************************** */
if ($showForm) {
?>
    <p>Enter student information. Email and password must meet requirements.</p>

    <form name="add_stu" id="add_stu" method="POST" action="<?php echo $currentFile; ?>">
    	<label for="fname">First Name</label>
        <input type="text" name="fname" id="fname" value="<?php if (isset($fname)) {echo htmlspecialchars($fname);}?>">
        <br>
        <?php if (isset($errors['fname'])) { echo "<span class='error'>&#10006; " . $errors['fname'] . "</span>";}?>
        <br>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php if (isset($email)) {echo htmlspecialchars($email);}?>">
        <br>
        <?php if (isset($errors['email'])) { echo "<span class='error'>&#10006; " . $errors['email'] . "</span><br>";}?>
        <br>
        <label for="pwd">Password</label>
        <input type="password" name="pwd" id="pwd" size="72" placeholder="Must be at least 15 and no more than 72 characters">
        <br>
        <?php if (isset($errors['pwd'])) { echo "<span class='error'>&#10006; " . $errors['pwd'] . "</span><br>";}?>
        <br>
        <label for="major">Select a Major</label>
        <select name="major" id="major">
            <option value="" <?php if (isset($major) && $major =="") { echo " selected";}?>>CHOOSE A MAJOR</option>
        <?php
        $sql = "SELECT * FROM majors ORDER BY priority";
        $result = $pdo->query($sql);
        foreach ($result as $row) {
            echo "<option value='" .$row['mjr_id'] . "'";
            if (isset($major) && $major == $row['mjr_id']) { echo " selected";}
            echo ">".$row['prefix'] . " - " . $row['program'] . "</option>";
        }
        ?>
        </select>
        <br>
        <?php if (isset($errors['major'])) { echo "<span class='error'>&#10006; " . $errors['major'] . "</span><br>";}?>
        <br>
        <fieldset>
        <legend>Select the Class Standing</legend>
            <?php if (isset($errors['standing'])) { echo "<span class='error'>&#10006; " . $errors['standing'] . "</span><br>";}?>
            <input type="radio" name="standing" id="FR" value="FR" <?php if (isset($standing) && $standing == "FR") { echo "checked";}?>><label for="FR">Freshman</label><br>
            <input type="radio" name="standing" id="SO" value="SO" <?php if (isset($standing) && $standing == "SO") { echo "checked";}?>><label for="SO">Sophomore</label><br>
            <input type="radio" name="standing" id="JR" value="JR" <?php if (isset($standing) && $standing == "JR") { echo "checked";}?>><label for="JR">Junior</label><br>
            <input type="radio" name="standing" id="SR" value="SR" <?php if (isset($standing) && $standing == "SR") { echo "checked";}?>><label for="SR">Senior</label><br>
            <input type="radio" name="standing" id="OT" value="OT" <?php if (isset($standing) && $standing == "OT") { echo "checked";}?>><label for="OT">Other</label><br>
        </fieldset>
        <br>
        <label for="bio">Student Biography</label>
        <?php if (isset($errors['bio'])) { echo "<br><span class='error'>&#10006; " . $errors['bio'] . "</span><br>";}?>
        <br>
        <textarea name="bio" id="bio"><?php if (isset($bio)) {echo $bio;}?></textarea>
        <br>
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