<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  4/9/2026
   * Filename:  confirm.php
 */
$pageName = "Confirmation";
require "header.php";
if (isset($_SESSION['fname'])) {
    echo "Hello, " . htmlspecialchars($_SESSION['fname']) . ". You have successfully logged in.";
}
else {
    echo "To access the site, please <a href='login.php'>log in</a>";
}

require "footer.php" ?>

