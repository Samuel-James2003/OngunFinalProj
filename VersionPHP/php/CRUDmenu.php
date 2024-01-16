<?php
session_start();
require "UsefulFunctions.php";
//$UserID = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = 'localhost';
    $dbname = "bdvacances";
    $username = 'root';
    $pass = '';
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_POST['submit'])) {
        //Add
        $name = $_POST["m_name"];
        $path = $_POST["m_path"];

        $sqlContract = "INSERT INTO t_menu (MName, MPath) VALUES (:name, :path)";
        $stmt = $conn->prepare($sqlContract);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':path', $path);
        $stmt->execute();


    }
    if (isset($_POST['delete'])) {
        //Delete

        try {
            if (isset($_POST['menu_id'])) {
                $delID = $_POST['menu_id'];
                //Delete menu
                $stmt = $conn->prepare("DELETE FROM t_menu WHERE MenuID = :delID");
                $stmt->bindParam(':delID', $delID);
                $stmt->execute();
                $_SESSION['deleted'] = true;
                
            }
            if (isset($_POST['submenu_id'])) {
                $delID = $_POST['submenu_id'];
                //Delete submenu
                $stmt = $conn->prepare("DELETE FROM t_submenu WHERE SubMenuID = :delID");
                $stmt->bindParam(':delID', $delID);
                $stmt->execute();
                $_SESSION['deleted'] = true;
            }
            
        } catch (\Throwable $th) {
        }
    }
    header("Location: ./admininistrate.php");
}
?>