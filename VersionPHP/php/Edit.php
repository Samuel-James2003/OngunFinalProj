<?php
session_start();
require "UsefulFunctions.php";
$UserID = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
}
