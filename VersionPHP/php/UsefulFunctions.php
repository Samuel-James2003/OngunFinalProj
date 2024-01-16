<?php
require "Alerts.php";
require "ReadID.php";
require "NavbarFilling.php";
require "Chat.php";

function ValidateEntry($password, $firstname, $surname, $address, $mail, $fileinfo, $switchclient, $switchworker)
{
    if ($switchclient != null || $switchworker != null) {
        if ($fileinfo != null && !empty($password) && !empty($mail) && strlen($password) >= 8) {
            return true;
        } elseif (
            !empty($password) && !empty($firstname) && !empty($surname) && !empty($address) && !empty($mail) && strlen($firstname) >= 2
            && strlen($address) >= 8 && strlen($password) >= 8
        )
            return true;
    } else {
        Bs_dismissable_alert("danger", "Error", "Missing field or not enough characters");
        return false;
    }
}
function echoStartHtmlCode($title, $jobID, $ID)
{
    echo '<!doctype html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<title>' . $title . '</title>';
    echo '<meta charset="utf-8" />';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />';
    echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />';
    echo '</head>';
    echo '<body>';
    echo '<header>';
    FillNavBar($ID);
    echo '</header>';
    echo '<main>';
    if ($title == "Addition" || $title == "Edit") {

        $servername = 'localhost';
        $dbname = "bdvacances";
        $username = 'root';
        $pass = '';
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if ($title == "Edit") {
                $_SESSION["jobID"] = $jobID;
                if (isset($_SESSION["Type"])) {
                    $Type = $_SESSION["Type"];
                }
                if ($ID == 1) {
                    $stmt = $conn->prepare("SELECT 
                    j.JobID,
                    j.DateCreated,
                    c.isDoneClient,
                    c.isDoneWorker,
                    c.isDone,
                    c.ContractID,
                    cat.CName
                FROM 
                    t_job j
                JOIN 
                    t_contract c ON j.ContractID = c.ContractID
                JOIN 
                    t_pivcontract pc ON c.ContractID = pc.ContractID
                JOIN 
                    t_category cat ON j.CatID = cat.CatID WHERE j.JobID =" . $jobID);
                } else {

                    $stmt = $conn->prepare("SELECT 
                j.JobID,
                j.DateCreated,
                c.isDoneClient,
                c.isDoneWorker,
                c.isDone,
                c.ContractID,
                cat.CName
            FROM 
                t_job j
            JOIN 
                t_contract c ON j.ContractID = c.ContractID
            JOIN 
                t_pivcontract pc ON c.ContractID = pc.ContractID
            JOIN 
                t_category cat ON j.CatID = cat.CatID WHERE j.JobID =" . $jobID . " AND pc.PersonID = " . $ID);
                
                   
                }
                $stmt->execute();
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                //echo $stmt->rowCount();
                foreach ($res as $row) {
                    $_SESSION["contractID"] = $row["ContractID"];
                    echo '<form action="' . $title . '.php" method="post"><div class="form-group">
          <label for="datetime">Date and Time:</label>
          <input type="datetime-local" class="form-control" id="datetime" name="datetime" value="' . $row["DateCreated"] . '"required>
        </div>
    
        <div class="form-group">
          ';
                    if ($ID == 1) {
                        echo '<div class="form-check">
                        <input type="checkbox" class="form-check-input" id="isDoneClient" name="isDoneClient" value="1" ' . ($row["isDoneClient"] == 1 ? 'checked' : '') . '>
                        <label class="form-check-label" for="isDoneClient">Is Done Client</label>
                    </div>';

                        echo '<div class="form-check">
                        <input type="checkbox" class="form-check-input" id="isDoneWorker" name="isDoneWorker" value="1" ' . ($row["isDoneWorker"] == 1 ? 'checked' : '') . '>
                        <label class="form-check-label" for="isDoneWorker">Is Done Worker</label>
                    </div>';

                        echo '<div class="form-check">
                        <input type="checkbox" class="form-check-input" id="isDone" name="isDone" value="1" ' . ($row["isDone"] == 1 ? 'checked' : '') . '>
                        <label class="form-check-label" for="isDone">Is Done</label>
                    </div>
                    <label for="options">Select an option:</label>
                    <select class="form-control" id="options" name="options" value=""required>';
                    } else {
                        if ($Type == "c") {
                            echo '<div class="form-check">
                <input type="checkbox" class="form-check-input" id="isDoneClient" name="isDoneClient" value="1" ' . ($row["isDoneClient"] == 1 ? 'checked' : '') . '>
                <label class="form-check-label" for="isDoneClient">Is Done Client</label>
            </div>
            <label for="options">Select an option:</label>
          <select class="form-control" id="options" name="options" value=""required>';
                        } elseif ($Type == "w") {
                            echo '<div class="form-check">
                                <input type="checkbox" class="form-check-input" id="isDoneWorker" name="isDoneWorker" value="1" ' . ($row["isDoneWorker"] == 1 ? 'checked' : '') . '>
                                <label class="form-check-label" for="isDoneWorker">Is Done Worker</label>
                            </div>
                            <label for="options">Select an option:</label>
                            <select class="form-control" id="options" name="options" value=""required>';
                        }
                    }
                }
            } else {
                echo '<form action="' . $title . '.php" method="post"><div class="form-group">
          <label for="datetime">Date and Time:</label>
          <input type="datetime-local" class="form-control" id="datetime" name="datetime" value=""required>
        </div>
    
        <div class="form-group">
          <label for="options">Select an option:</label>
          <select class="form-control" id="options" name="options" required>';
            }
            $stmt = $conn->prepare("SELECT * FROM t_category");
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($res as $row) {
                echo "<option value='" . htmlspecialchars($row['CatID']) . "'>" . htmlspecialchars($row['CName']) . "</option>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        echo '</select>';
        echo '<button type="submit" name=' . $title . ' class="btn btn-primary">' . $title . '</button>';
        echo "</form>";

    }
}
function echoEndHtmlCode()
{
    echo '</main>';
    echo '<footer>';
    // You can add your footer code here
    echo '</footer>';
    echo '<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>';
    echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>';
    echo '</body>';
    echo '</html>';
}

function displayTable($conn, $type)
{
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
    JOIN 
        t_persontype pt ON pc.PersonID = pt.PersonID
    JOIN 
        t_type t ON pt.TypeID = t.TypeID
    WHERE 
        t.tName = :tName");
    
    $stmt->bindParam(':tName', $type, PDO::PARAM_INT);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display records in the table
    if ($stmt->rowCount() > 0) {
        echo "<table class='table table-bordered'>";
        echo "<thead class='thead-dark'><tr><th>ID</th><th>Date Created</th><th>Completion</th><th>Category</th></tr></thead>";
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
                echo '<span class="badge bg-success">Complete</span>';
            } elseif ($row["isDoneClient"] == 1) {
                echo '<span class="badge bg-warning">Client complete</span>';
            } elseif ($row["isDoneWorker"] == 1) {
                echo '<span class="badge bg-info">Worker complete</span>';
            } else {
                echo '<span class="badge bg-danger">Incomplete</span>';
            }
            echo "</td>";
            echo "<td>" . $row["CName"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No records found for $type</p>";
    }
}

?>
?>