<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  4/9/2026
   * Filename:  sesdestroy.php
 */
session_start();
$_SESSION = [];
$params = session_get_cookie_params();
setcookie(session_name(), '', time() - 3600,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]
);
session_destroy();
print_r($_SESSION);
echo "<pre>";
print_r($_COOKIE);
echo "</pre>";
?>
<br>
<a href="sesdisplay.php">Display</a>
<a href="sescookie.php">Cookie</a>
 