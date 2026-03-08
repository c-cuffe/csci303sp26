<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  2/15/2026
   * Filename:  header.php
 */
//Error Reporting
error_reporting(E_ALL);
ini_set('display_errors','1');

//Include files
require_once "connect.php";
require_once "functions.php";

//Current file
$currentFile = basename($_SERVER['SCRIPT_FILENAME']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>cecuffe</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Cecilia Cuffe</h1>
<nav>
    <?php
    echo ($currentFile == "index.php") ? "Home" : "<a href='index.php'>Home</a>";
    echo ($currentFile == "resdashboard.php") ? "Resource Dashboard" : "<a href='resdashboard.php'>Resource Dashboard</a>";
    echo ($currentFile == "studashboard.php") ? "Student Dashboard" : "<a href='studashboard.php'>Student Dashboard</a>";
    echo ($currentFile == "stulist.php") ? "Student List" : "<a href='stulist.php'>Student List</a>";
    // continue main nav here
    ?>
</nav>
<h2><?php echo $pageName;?></h2>