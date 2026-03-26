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