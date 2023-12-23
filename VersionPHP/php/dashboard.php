<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styles for the overlay background of the popup */
        #login-register-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 999;
        }

        /* Styles for the content of the popup */
        #login-register-popup .popup-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            padding: 20px;
        }

        /* Styles for the close button within the popup */
        .close-button {
            position: absolute;
            top: 5px;
            right: 5px;
            font-size: 24px;
            background: none;
            border: none;
            cursor: pointer;
        }
    </style>

</head>

<body>
    <!-- Navbar for both pages -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Your Website</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.html">Dashboard</a>
                </li>
                <li class="nav-item">
                    <button id="show-login-reg" class="btn btn-link">login</button>
                </li>
            </ul>
        </div>
    </nav>
    <div>
        <?php
        // Display table header
        echo "<table>";
        echo "<tr><th>ID</th><th>Date Created</th><th>Completion</th><th>CCategory</th></tr>";

        // Display records in the table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td><input type='checkbox' name='selected_rows[]' value='" . $row['id'] . "'></td>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["DateCreated"] . "</td>";
                if ($row["isDoneWorker"] == 1) {

                    //make the cell red
                    if ($row["isDoneWorker"] == 1) {
                        //make cell yellow
                        if ($row["isDone"] == 1) {
                            //make cell green
                        }
                    }
                }
                echo "<td>" . "State" . "</td>";
                echo "<td>" . $row["CName"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No records found</td></tr>";
        }
        // Close the table
        echo "</table>";
        ?>
        <input type="submit" value="Process Selected Rows">
    </div>
    <!-- TODO: Make a page for add(edit can go there too) -->
    
     <div>
        <button type="button" onclick="location.href='add_record.php'">Add</button>
        <button type="button" >Delete</button>
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