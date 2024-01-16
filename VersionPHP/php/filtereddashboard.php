<!doctype html>
<html lang="en">
    <head>
        <title>Filtered</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>
<?php 

$queryType = isset($_GET['query']) ? $_GET['query'] : 'all';
session_start();
    $UserID = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : 0;
    require 'UsefulFunctions.php';
    FillNavBar($UserID);
    $servername = 'localhost';
    $dbname = "bdvacances";
    $username = 'root';
    $pass = '';
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    switch ($queryType) {
        case 'completed':
            $stmt = $conn->prepare("SELECT 
            j.JobID,
            j.DateCreated,
            c.isDoneWorker,
            c.isDoneClient,
            c.isDone,
            cat.CName
        FROM 
            t_job j
        JOIN 
            t_contract c ON j.ContractID = c.ContractID
        JOIN 
            t_pivcontract pc ON c.ContractID = pc.ContractID
        JOIN 
            t_category cat ON j.CatID = cat.CatID
        WHERE c.isDone = 1");
            break;
        case 'notcompleted':
            $stmt = $conn->prepare("SELECT 
            j.JobID,
            j.DateCreated,
            c.isDoneWorker,
            c.isDoneClient,
            c.isDone,
            cat.CName
        FROM 
            t_job j
        JOIN 
            t_contract c ON j.ContractID = c.ContractID
        JOIN 
            t_pivcontract pc ON c.ContractID = pc.ContractID
        JOIN 
            t_category cat ON j.CatID = cat.CatID
        WHERE c.isDone = 0");
            break;
        default:
            $stmt = $conn->prepare("SELECT 
            j.JobID,
            j.DateCreated,
            c.isDoneWorker,
            c.isDoneClient,
            c.isDone,
            cat.CName
        FROM 
            t_job j
        JOIN 
            t_contract c ON j.ContractID = c.ContractID
        JOIN 
            t_pivcontract pc ON c.ContractID = pc.ContractID
        JOIN 
            t_category cat ON j.CatID = cat.CatID");
            break;
        }
        $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the results as needed
    echo "<pre>";
    print_r($result);
    echo "</pre>";
?>
    <body>
        <header>
            <!-- place navbar here -->
        </header>
        <main></main>
        <footer>
            <!-- place footer here -->
        </footer>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
