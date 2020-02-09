<?php
//database_connection.php
include('../registration/server.php');

$connect = new PDO("mysql:host=localhost;dbname=todo", "root", "1");

session_start();

?>
