<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  2/15/2026
   * Filename:  functions.php
 */
 function check_duplicates($pdo, $sql, $field) {
     $stmt = $pdo->prepare($sql);
     $stmt->bindValue(':field', $field);
     $stmt->execute();
     $row = $stmt->fetch();
     return $row;
 }// end function

function check_login(){ // Check if user is logged in
   if(!isset($_SESSION['stu_id'])) {
       echo "<p class='error'> This page requires users to <a href='login.php'>log in</a> to view.</p>";
       require "footer.php";
       exit();
   }
}
function admin_access() { // Check if user has admin privileges
     if(isset($_SESSION['access']) && ($_SESSION['access'] != 1)) {
         echo "<p class='error'>This page requires administrative access</p>";
         require "footer.php";
         exit();
     }
}
function check_owner($stu_id) { // Check if user is the owner
    if(isset($_SESSION['stu_id']) && $stu_id != $_SESSION['stu_id']) {
        echo "<p class='error'>You are not the owner. Please visit another page from the menu.</p>";
        require "footer.php";
        exit();
    }
}
function check_owner_admin($stu_id) { // Check if user is owner or admin
     if(isset($_SESSION['stu_id']) && ($stu_id != $_SESSION['stu_id'] && $_SESSION['access'] != 1)) {
         echo "<p class='error'>You do not have the authorization status to view this page.</p>";
        require "footer.php";
        exit();
     }
}