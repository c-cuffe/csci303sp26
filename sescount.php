<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  4/9/2026
   * Filename:  sescount.php
 */
 session_start();
 if (!isset($_SESSION['count'])) {
     $_SESSION['count'] = 0;
 }
 $_SESSION['count']++;
?>
<a href="sesdisplay.php">Display</a>
