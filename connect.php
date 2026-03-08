<?php

/*
   * Class: csci303sp26
   * User:  cecil
   * Date:  2/15/2026
   * Filename:  connect.php
 */
$dsn = "mysql:host=localhost;dbname=csci303sp26";
$user = "csci303sp26";
$pwd = "php-spring-2026";
$pdo = new PDO($dsn,$user,$pwd);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 