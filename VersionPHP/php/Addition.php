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
        $dateCreated = $_POST["datetime"]; 
        $catID = $_POST["options"];

        $sqlContract = "INSERT INTO t_contract (isDoneClient, isDoneWorker, isDone) VALUES (0, 0, 0)";
        $stmt = $conn->prepare($sqlContract);
        $stmt->execute();
       
        // Get the auto-generated ContractID from the last insert
        $contractID = $conn->lastInsertId();

        // Insert new data into t_job
        $dateCreated = date("Y-m-d H:i:s");  // Current date and time
        $sqlJob = "INSERT INTO t_job (CatID, DateCreated, ContractID) VALUES ($catID, '$dateCreated', $contractID)";
        $stmt = $conn->prepare($sqlJob);
        $stmt->execute();

        // Insert new data into t_pivcontract
        $sqlPivContract = "INSERT INTO t_pivcontract (PersonID, ContractID) VALUES ($UserID, $contractID)";
        $stmt = $conn->prepare($sqlPivContract);
        $stmt->execute();
        header("Location: ./dashboard.php");
    }
}