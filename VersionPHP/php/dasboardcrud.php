<?php
session_start();
require "UsefulFunctions.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        echoHtmlCode("Addition");
        echo "add button has been pressed";
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
                $stmt = $conn->prepare("DELETE FROM t_job WHERE JobID = :jobId");
                $stmt->bindParam(':jobId', $jobId);
                $stmt->execute();
                $_SESSION['deleted'] = true;
            }
            if (isset($_POST['edit'])) {
                echo "The edit button has been pressed for ";
                echo $jobId;
            }
           
        } catch (\Throwable $th) {}
        header("Location: ./dashboard.php");
    }
}
?>