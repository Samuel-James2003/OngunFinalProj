<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <!--Todo : Modular navbar for pages -->
    <?php //todo : read the database and echo the right pages for the navbar and check if there is a submenu in that case do what you must
    require 'NavbarFilling.php';
    FillNavBar();
    ?>

<div class="container">
    <center>
        <?php
        // Display table header
        echo "<table class='table table-bordered'>";
        echo "<thead class='thead-dark'><tr><th>Select</th><th>ID</th><th>Date Created</th><th>Completion</th><th>Category</th></tr></thead>";
        $servername = 'localhost';
        $dbname = "bdvacances";
        $username = 'root';
        $pass = '';
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
        pc.PersonID = '2';");

        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display records in the table
        if ($stmt->rowCount() > 0) {
            foreach ($res as $row) {
                echo "<tr>";
                echo "<td><input type='checkbox' name='selected_rows[]' value='" . $row['JobID'] . "'></td>";
                echo "<td>" . $row["JobID"] . "</td>";
                echo "<td>" . $row["DateCreated"] . "</td>";
                echo "<td>";
                if ($row["isDone"] == 1) {
                    echo '<span class="badge badge-success">State</span>';
                } elseif ($row["isDoneClient"] == 1) {
                    echo '<span class="badge badge-warning">State</span>';
                } elseif ($row["isDoneWorker"] == 1) {
                    echo '<span class="badge badge-info">State</span>';
                } else {
                    echo '<span class="badge badge-danger">State</span>';
                }
                echo "</td>";
                echo "<td>" . $row["CName"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No records found</td></tr>";
        }
        // Close the table
        echo "</table>";
        ?>
        <br>
        <input type="submit" class="btn btn-primary" value="Process Selected Rows">
    </center>
</div>

    <!-- TODO: Make a page for add(edit can go there too) -->

    <div>
        <button type="button" onclick="location.href='add_record.php'">Add</button>
        <button type="button">Delete</button>
        <button type="button" onclick="location.href='edit_records.php'">Edit</button>
    </div>
    <!-- Add Bootstrap JS and jQuery for popup functionality -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>

    <!-- Add Bootstrap JS and jQuery for navbar functionality -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
</body>

</html>