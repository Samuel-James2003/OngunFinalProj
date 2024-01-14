<?php
session_start();
require "UsefulFunctions.php";
$UserID = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        //Add
        echoHtmlCode("Addition",0,$UserID);
    }
    if (isset($_POST['job_id'])) {
        try {
            $jobId = $_POST['job_id'];
            $servername = 'localhost';
            $dbname = "bdvacances";
            $username = 'root';
            $pass = '';
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if (isset($_POST['delete'])) {
                //Delete
                $stmt = $conn->prepare("DELETE FROM t_job WHERE JobID = :jobId");
                $stmt->bindParam(':jobId', $jobId);
                $stmt->execute();
                $_SESSION['deleted'] = true;
                header("Location: ./dashboard.php");
            }
            if (isset($_POST['edit'])) {
                //Edit
                echoHtmlCode("Edit",$jobId, $UserID);
            }
           
        } catch (\Throwable $th) {}
    }
}
?>