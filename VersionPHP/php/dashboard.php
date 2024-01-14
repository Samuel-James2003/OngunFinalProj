<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php
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
    $logged = isset($_SESSION['ShowedLogin']) ? true : false;
    if ($logged) {
        $sql = "SELECT pEmail FROM t_person WHERE PersonID = :UserID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($res as $row) {
            Bs_dismissable_alert("secondary ", "Logged in", $row["pEmail"] . " is logged in");
        }
        $_SESSION['ShowedLogin'] = null;

    }

    ?>

    <?php
    ?>
    <div class="container">
        <center>
            <?php
            // Display table header
            echo "<table class='table table-bordered'>";
            echo "<thead class='thead-dark'><tr><th>Select</th><th>ID</th><th>Date Created</th><th>Completion</th><th>Category</th></tr></thead>";
            if ($UserID != 1) {
                $stmt = $conn->query("SELECT 
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
    WHERE 
        pc.PersonID = '" . $UserID . "';");
            }
            elseif($UserID == 1){
                $stmt = $conn->query("SELECT 
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
            }

            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Display records in the table
            
            if ($stmt->rowCount() > 0) {
                foreach ($res as $row) {
                    echo "<tr>";
                    echo "<td><form action='dashboardcrud.php' method='post'>";
                    echo "<input type='hidden' name='job_id' value='" . $row['JobID'] . "'>";
                    echo "<button type='submit' name='delete' class='btn btn-danger'>-</button>";
                    echo "<button type='submit' name='edit' class='btn btn-warning'>" . '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M7.127 22.562l-7.127 1.438 1.438-7.128 5.689 5.69zm1.414-1.414l11.228-11.225-5.69-5.692-11.227 11.227 5.689 5.69zm9.768-21.148l-2.816 2.817 5.691 5.691 2.816-2.819-5.691-5.689z"/>' . "</svg></button>";
                    echo "</form></td>";
                    echo "<td>" . $row["JobID"] . "</td>";
                    echo "<td>" . $row["DateCreated"] . "</td>";
                    echo "<td>";
                    if ($row["isDone"] == 1) {
                        echo '<span class="badge bg-success">State</span>';
                    } elseif ($row["isDoneClient"] == 1) {
                        echo '<span class="badge bg-warning">State</span>';
                    } elseif ($row["isDoneWorker"] == 1) {
                        echo '<span class="badge bg-info">State</span>';
                    } else {
                        echo '<span class="badge bg-danger">State</span>';
                    }
                    echo "</td>";
                    echo "<td>" . $row["CName"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No records found</td></tr>";
            }

            echo "</table>";
            ?>
            <br>
        </center>

    </div>

    <!-- TODO: Make a page for add(edit can go there too) -->
    <center>
        <form action='dashboardcrud.php' method='post'>
            <button type="submit" name="add" class="btn btn-primary">Add</button>
        </form>

    </center>
    <div>
        <?php

        $deleted = isset($_SESSION['deleted']) ? $_SESSION['deleted'] : 0;
        if ($deleted) {
            Bs_dismissable_alert("primary", "Delete successful", "Successfully deleted the entry");
            $_SESSION['deleted'] = null;
        }
        ?>
    </div>
    <footer>

        <!-- Bootstrap JavaScript Libraries -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
            </script>
    </footer>
    <!-- Add Bootstrap JS and jQuery for popup functionality -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>

</html>