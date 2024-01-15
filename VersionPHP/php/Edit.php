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
    if (isset($_POST['Edit'])) {
        $dateCreated = $_POST["datetime"]; 
        $catID = $_POST["options"];
        $jobID = $_SESSION["jobID"];
        $sqlJob = "UPDATE t_job SET CatID = :catID, DateCreated = :dateCreated WHERE JobID = :jobID";
        $stmt = $conn->prepare($sqlJob);
        $stmt->bindParam(':catID', $catID);
        $stmt->bindParam(':dateCreated', $dateCreated);
        $stmt->bindParam(':jobID', $jobID);
        $stmt->execute();

        $isDoneClient = $_POST["isDoneClient"];
        $isDoneWorker = $_POST["isDoneWorker"];
        $isDone = $_POST["isDone"];
        $contractID = $_SESSION["contractID"];
        $sqlContract = "UPDATE t_contract SET isDoneClient = :isDoneClient, isDoneWorker = :isDoneWorker, isDone = :isDone WHERE ContractID = :contractID";
        $stmt = $conn->prepare($sqlContract);
        $stmt->bindParam(':isDoneClient', $isDoneClient);
        $stmt->bindParam(':isDoneWorker', $isDoneWorker);
        $stmt->bindParam(':isDone', $isDone);
        $stmt->bindParam(':contractID', $contractID);
        $stmt->execute();
        // Insert new data into t_pivcontract
        // $sqlPivContract = "UPDATE t_pivcontract SET PersonID = :userID WHERE ContractID = :contractID";
        // $stmt = $conn->prepare($sqlPivContract);
        // $stmt->bindParam(':userID', $UserID);
        // $stmt->bindParam(':contractID', $contractID);
        // $stmt->execute();
        $_SESSION["jobID"] = null;
        $_SESSION["contractID"] = null;
        header("Location: ./dashboard.php");
    }
}
?> 

