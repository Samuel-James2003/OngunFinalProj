<?php
session_start();
require "UsefulFunctions.php";
$UserID = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = 'localhost';
    $dbname = "bdvacances";
    $username = 'root';
    $pass = '';
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_POST['Addition'])) {

    }
}