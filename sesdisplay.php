<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  4/9/2026
   * Filename:  sesdisplay.php
 */
session_start();
print_r($_SESSION);
echo "<pre>";
print_r($_COOKIE);
echo "</pre>";
?>
<br>
<a href="sesdestroy.php">Destroy</a>
or
<a href="sescount.php">Count</a>
