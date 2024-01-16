<!doctype html>
<html lang="en">

<head>
    <title>Addministration</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <header>
    </header>
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
    ?>
    <div class="container">
        <center>
            <?php
            //echo $stmt->rowCount();
            // Display records in the table
            echo "<table class='table table-bordered'>";
            echo "<thead class='thead-dark'><tr><th>Select</th><th>ID</th><th>Menu name</th><th>Menu path</th><th>SubMenuID</th><th>SubMenu name</th><th>Submenu path</th></tr></thead>";

            $stmt = $conn->query("SELECT t_menu.MenuID, t_menu.MName, t_menu.MPath, t_submenu.SubMenuID, t_submenu.SMName, t_submenu.SMPath
        FROM t_menu
        LEFT JOIN t_submenu ON t_menu.MenuID = t_submenu.MenuID
        ORDER BY t_menu.MenuID;
        ");
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                foreach ($res as $row) {
                    echo "<tr>";
                    echo "<td><form action='CRUDmenu.php' method='post'>";
                    echo "<input type='hidden' name='menu_id' value='" . $row["MenuID"] . "'>";
                    echo "<input type='hidden' name='submenu_id' value='" . $row["SubMenuID"] . "'>";
                    echo "<button type='submit' name='delete' class='btn btn-danger'>-</button>";
                    echo "</form></td>";
                    echo "<td>" . $row["MenuID"] . "</td>";
                    echo "<td>" . $row["MName"] . "</td>";
                    echo "<td>" . $row["MPath"] . "</td>";
                    echo "<td>" . $row["SubMenuID"] . "</td>";
                    echo "<td>" . $row["SMName"] . "</td>";
                    echo "<td>" . $row["SMPath"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No records found</td></tr>";
            }

            echo "</table>";

            $deleted = isset($_SESSION['deleted']) ? $_SESSION['deleted'] : 0;
            if ($deleted) {
                Bs_dismissable_alert("primary", "Delete successful", "Successfully deleted the entry");
                $_SESSION['deleted'] = null;
            }
            ?>
            <br>
        </center>

    </div>

    <form id="Addmenu" action='CRUDmenu.php' method="post">
        <div class="form-group">
            <label for="">Menu name:</label>
            <input type="text" class="form-control" id="menu-Name" placeholder="Enter menu name" name="m_name" required>
        </div>
        <div class="form-group">
            <label for="menu path">Menu path:</label>
            <input type="text" class="form-control" id="menu-path" placeholder="Enter menu path" name="m_path" required>
        </div>

        <input type="hidden" name="submit" value="submit">
        <button type="submit" class="btn btn-primary" name="submit" value="submit">Sumbit</button>
    </form>
    <main>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>