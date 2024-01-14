<!doctype html>
<html lang="en">

<head>
    <title>User page</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <?php
    require 'UsefulFunctions.php';
    session_start();
    $servername = 'localhost';
    $dbname = "bdvacances";
    $username = 'root';
    $pass = '';
    $UserID = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : 0;
    FillNavBar($UserID);
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->query("SELECT
            p.PersonID AS PersonID,
            p.pName,
            p.pSurname,
            p.pAddress,
            p.pEmail,
            pt.TypeID
          FROM
            t_person p
          LEFT JOIN
            t_persontype pt ON p.PersonID = pt.PersonID");
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $i = false;
    foreach ($res as $row) {
        if ($row['PersonID'] == $UserID) {
            if (!$i) {
                $i = true;
                $UserEmail = $row['pEmail'];
                $UserName = $row['pName'];
                $UserSurname = $row['pSurname'];
                $UserAddress = $row['pAddress'];
                echo '<div class="container-sm">';
                echo '<h2>Update your profile</h2>';
                echo '<form id="update-form" method="post" enctype="multipart/form-data" novalidate>';
                echo '    <div class="row g-3">';
                echo '        <div class="col-12">';
                echo '            <div class="form-group">';
                echo '                <label for="email-update">Email: *</label>';
                echo '                <input type="email" class="form-control" id="email-update" value=' . $UserEmail . ' name="up_email" required>';
                echo '            </div>';
                echo '            <div class="form-group">';
                echo '                <label for="password-update">Password: *</label>';
                echo '                <input type="password" class="form-control" id="password-update" placeholder="Re-enter your password" name="up_password" required>';
                echo '            </div>';
                echo '        </div>';
                echo '        <!-- Left Column -->';
                echo '        <div class="col-md-6">';
                echo '            <div class="form-group">';
                echo '                <label for="firstname-update">First Name:</label>';
                echo '                <input type="text" class="form-control" id="firstname-update" value=' . $UserName . ' name="up_firstname">';
                echo '            </div>';
                echo '            <div class="form-group">';
                echo '                <label for="surname-update">Surname:</label>';
                echo '                <input type="text" class="form-control" id="surname-update" value=' . $UserSurname . ' name="up_surname">';
                echo '            </div>';
                echo '<div class="form-group">';
                echo '<label for="Address-update">Address:</label>';
                echo '<input type="text" class="form-control" id="address-update" value="' . htmlspecialchars($UserAddress) . '" name="up_address">';
                echo '</div>';
                echo '</div>';
                echo '<div class="col-md-1" style="border-right: 1px solid #ccc; height: 100%;"></div>';
                echo '<div class="col-md-5">';
                echo '<div class="form-group">';
                echo '<label for="type-update">Choose your status:</label>';
                echo '<div class="form-check form-switch">';
                if ($row['TypeID'] == 1) {
                    echo '<input class="form-check-input" type="checkbox" id="Client-update" name="up_client" onclick="toggleSwitch("Client-update")" checked>';
                } else {
                    echo '<input class="form-check-input" type="checkbox" id="Client-update" name="up_client" onclick="toggleSwitch("Client-update")">';
                }
                echo '<label class="form-check-label" for="Client-update">Client</label>';
                echo '</div>';
                echo '<div class="form-check form-switch">';
                if ($row['TypeID'] == 2) {
                    echo '<input class="form-check-input" type="checkbox" id="Worker-update" name="up_worker" onclick="toggleSwitch("Worker-update")" checked>';
                } else {
                    echo '<input class="form-check-input" type="checkbox" id="Worker-update" name="up_worker" onclick="toggleSwitch(Worker-update)">';
                }
                echo '<label class="form-check-label" for="Worker-update">Worker</label>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '<br>';
                echo '<input type="hidden" name="update" value="update">';
                echo '<button type="submit" class="btn btn-success" name="update" value="update">Update</button>';
                echo '</form>';
            } else {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {toggleSwitch('Worker-update');});
                    </script>";
            }

        }
    }
    ?>
    <?php
    if (isset($_POST["update"]) && $_POST["update"] == "update") {
        if (
            ValidateEntry(
                $_POST["up_password"],
                $_POST["up_firstname"],
                $_POST["up_surname"],
                $_POST["up_address"],
                $_POST["up_email"],
                $fileinfo,
                isset($_POST['up_client']) ? $_POST['up_client'] : null,
                isset($_POST['up_worker']) ? $_POST['up_worker'] : null
            )
        ) {
            if (filter_var($_POST["up_email"], FILTER_VALIDATE_EMAIL)) {
                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $verif = $conn->query("SELECT pPassword FROM t_person WHERE PersonID =" . $UserID);
                    $res = $verif->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($res as $row) {
                        if ((!password_verify($Password, $row['pPassword']))) {
                            Bs_dismissable_alert("danger", "Error", "Wrong password bitch");
                            break;
                        } else {
                            // Requête UPDATE pour mettre à jour les informations dans t_person
                            $sql = "UPDATE t_person SET 
                                    pName = ?,
                                    pSurname = ?,
                                    pAddress = ?,
                                    pPassword = ?,
                                    pEmail = ?
                                    WHERE PersonID = ?";
            
                            $stmt = $conn->prepare($sql);
                            $hashedString = password_hash($_POST["up_password"], PASSWORD_DEFAULT);
            
                            $stmt->execute([
                                $_POST["up_firstname"],
                                $_POST["up_surname"],
                                $_POST["up_address"],
                                $hashedString,
                                $_POST["up_email"],
                                $UserID
                            ]);
            
                            // Requête DELETE pour supprimer les enregistrements dans t_persontype
                            $sqlDelete = "DELETE FROM t_persontype WHERE PersonID = " .$UserID;
                            $stmtDelete = $conn->prepare($sqlDelete);
                            $stmtDelete->execute([$UserID]);
            
                            // Requête INSERT pour ajouter les nouveaux enregistrements dans t_persontype
                            $sqlInsert = "INSERT INTO t_persontype (PersonID, TypeID) VALUES (?, ?)";
                            $stmtInsert = $conn->prepare($sqlInsert);
            
                            if (isset($_POST["up_client"])) {
                                $stmtInsert->execute([$UserID, "1"]);
                            }
                            if (isset($_POST["up_worker"])) {
                                $stmtInsert->execute([$UserID, "2"]);
                            }
                        }
                    }
                } catch (PDOException $e) {
                    Bootstrap_alert("danger", "Error", $e->getMessage());
                }
            } else {
                Bootstrap_alert("danger", "Error", "Invalid email address");
            }
        }
    }


    ?>
    <footer>
        <script>function toggleSwitch(id) {
                if (id === 'Client-update') {
                    document.getElementById('Client-update').checked = true;
                } else if (id === 'Worker-update') {
                    document.getElementById('Worker-update').checked = true;
                }
            }</script>
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