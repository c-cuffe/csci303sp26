<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  2/15/2026
   * Filename:  header.php
 */
session_start();
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
    <script src="/csci303/tinymce/tinymce/js/tinymce/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
</head>
<body>
<h1>Cecilia Cuffe</h1>
<nav>
    <?php
    echo ($currentFile == "index.php") ? "Home" : "<a href='index.php'>Home</a>";
    echo ($currentFile == "stulist.php") ? "Student List" : "<a href='stulist.php'>Student List</a>";
    echo ($currentFile == "ressearch.php") ? "Search Resources" : "<a href='ressearch.php'>Resource Search</a>";
    echo ($currentFile == "stusearch.php") ? "Search Students" : "<a href='stusearch.php'>Student Search</a>";
    echo ($currentFile == "stuadd.php") ? "Add Student" : "<a href='stuadd.php'>Add Student</a>";
    // continue main nav here
    if (isset($_SESSION['stu_id'])) {
        echo ($currentFile == "resdashboard.php") ? "Resource Dashboard" : "<a href='resdashboard.php'>Resource Dashboard</a>";
        echo ($currentFile == "studashboard.php") ? "Student Dashboard" : "<a href='studashboard.php'>Student Dashboard</a>";
        echo ($currentFile == "logout.php") ? "Logout" : "<a href='logout.php'>Logout</a>";
    }
    else {
        echo ($currentFile == "login.php") ? "Log In" : "<a href='login.php'>Log In</a>";
    }
    ?>
</nav>
<h2><?php echo $pageName;?></h2>