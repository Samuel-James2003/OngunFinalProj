<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login and Register</title>
    <style>
        .error {
            border: 2px solid red;
        }
    </style>
</head>

<body>
    <div>
        <?php
        ob_start(); //necessairy because php is a ******* fossil and i dont even know why i needed to spend 2 hours for this to fix it i am spechless 
        session_start();
        require 'UsefulFunctions.php';
        $servername = 'localhost';
        $dbname = "bdvacances";
        $username = 'root';
        $pass = '';
        $UserID = isset($_SESSION['UserID']) ? $_SESSION['UserID'] : 0;
        FillNavBar($UserID);
        ?>
    </div>
    <!-- Registration, Login and Forgot password Forms -->
    <div class="container-sm">
        <h2>Login or Register</h2>

        <!-- Login Form -->
        <form id="login-form" method="post" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email-login" placeholder="Enter your email"
                    name="log_email" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Input an email address
                </div>

            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password"
                    name="log_password" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Input a password
                </div>
            </div>
            <label for="type-login">Choose your status:</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="Client-login" name="log_client"
                    onclick="toggleSwitch('Client-login')" checked>
                <label class="form-check-label" for="Client-login">Client</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="Worker-login" name="log_worker"
                    onclick="toggleSwitch('Worker-login')">
                <label class="form-check-label" for="Worker-login">Worker</label>
            </div>
            <input type="hidden" name="login" value="login">
            <button type="submit" class="btn btn-primary" name="submit" value="login">Login</button>
        </form>

        <!-- Registration Form -->
        <form id="register-form" method="post" enctype="multipart/form-data" style="display: none;" novalidate>
            <div class="row g-3">
                <div class="col-12">
                    <div class="form-group">
                        <label for="email-register">Email: *</label>
                        <input type="email" class="form-control" id="email-register" placeholder="Enter your email"
                            name="reg_email" required>
                    </div>
                    <div class="form-group">
                        <label for="password-register">Password: *</label>
                        <input type="password" class="form-control" id="password-register"
                            placeholder="Enter your password" name="reg_password" required>
                    </div>
                </div>
                <!-- Left Column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="firstname-register">First Name:</label>
                        <input type="firstname" class="form-control" id="firstname-register"
                            placeholder="Enter your first name" name="reg_firstname">
                    </div>
                    <div class="form-group">
                        <label for="surname-register">Surname:</label>
                        <input type="surname" class="form-control" id="surname-register"
                            placeholder="Enter your surname" name="reg_surname">
                    </div>
                    <div class="form-group">
                        <label for="Address-register">Address:</label>
                        <input type="Address" class="form-control" id="address-register"
                            placeholder="Enter your address" name="reg_address">
                    </div>
                </div>
                <!-- Vertical Line -->
                <div class="col-md-1" style="border-right: 1px solid #ccc; height: 100%;"></div>
                <!-- Right Column -->
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="type-register">Choose your status:</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="Client-register" name="reg_client">
                            <label class="form-check-label" for="Client-register">Client</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="Worker-register" name="reg_worker">
                            <label class="form-check-label" for="Worker-register">Worker</label>
                        </div>
                        <label for="custom-file">Place your eid file here:</label>
                        <div class="custom-file">
                            <input type="file" class="form-control-file" name="customFile" id="customFile"
                                accept=".eid">
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="register" value="register">
            <button type="submit" class="btn btn-success" name="register" value="register">Register</button>
        </form>

        <!-- Forgot Password Form -->
        <form id="forgotpassword-form" method="post" style="display: none;">
            <div class="form-group">
                <label for="email-forgotpassword">Email:</label>
                <input type="email" class="form-control" id="email-forgotpassword" placeholder="Enter your email"
                    name="for_email">
            </div>
            <input type="hidden" name="forgotpass" value="forgotpass">
            <button type="submit" class="btn btn-warning" name="submit" value="forgotpass">Send new
                password</button>
        </form>

        <!-- Switch buttons -->
        <button id="switch-to-register" class="btn btn-link">Switch to Register</button>
        <button id="switch-to-login" class="btn btn-link" style="display: none;">Switch to Login</button>
        <button id="switch-to-forgotpass" class="btn btn-link">I forgot my password</button>
    </div>
    <div>
        <!--Login PHP-->
        <div>
            <?php
            if (isset($_POST["login"]) && $_POST["login"] == "login") {
                try {
                    $Email = $_POST["log_email"];
                    $Password = $_POST["log_password"];
                    if ($Email == "Admin@Admin" && $Password == "administrator") {
                        $_SESSION['UserID'] = 1;
                        $_SESSION['Type'] = "a";
                        $_SESSION['isLoggedinAs'] = "admin";
                        $_SESSION['ShowedLogin'] = true;
                        header("Location: ../php/dashboard.php");
                    } else {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);

                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stmt = $conn->query("SELECT * FROM t_person");
                        $stmt2 = $conn->query("SELECT * FROM t_persontype");

                        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $res2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($res as $row) {
                            if (($row['pEmail'] == $Email) && (password_verify($Password, $row['pPassword']))) {
                                $_SESSION['UserID'] = $row['PersonID'];
                                $_SESSION['ShowedLogin'] = true;
                                $_SESSION['Type'] = isset($_POST["log_client"])? "c":"w";
                                $_SESSION['isLoggedinAs'] = isset($_POST["log_client"])? "client":"worker";
                                header("Location: ../php/dashboard.php");
                                break;
                            }
                        }
                    }

                } catch (PDOException $e) {
                    Bootstrap_alert("danger", "Error", $e->getMessage());
                }

            }
            ?>
        </div>
        <!--Register PHP-->
        <div>
            <?php
            if (isset($_POST["register"]) && $_POST["register"] == "register") {
                $fileinfo = null;
                try {
                    if ($_FILES['customFile']['error'] != 4 && !($_FILES['customFile']['size'] == 0 && $_FILES['customFile']['error'] == 0)) {
                        $fileinfo = extractDataFromFile($_FILES['customFile']['tmp_name']);
                        if (!$fileinfo) {
                            $fileinfo = null;
                            Bootstrap_alert("danger", "Error", "File not found");
                        }
                    }
                } catch (Exception $e) {
                    Bootstrap_alert("danger", "Error", $e->getMessage());
                }
                if (
                    ValidateEntry(
                        $_POST["reg_password"],
                        $_POST["reg_firstname"],
                        $_POST["reg_surname"],
                        $_POST["reg_address"],
                        $_POST["reg_email"],
                        $fileinfo,
                        isset($_POST['reg_client']) ? $_POST['reg_client'] : null,
                        isset($_POST['reg_worker']) ? $_POST['reg_worker'] : null
                    )
                ) {
                    if (filter_var($_POST["reg_email"], FILTER_VALIDATE_EMAIL)) {
                        try {
                            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $sql = "INSERT INTO t_person (pName, pSurname, pAddress, pPassword, pEmail) 
                            VALUES (?, ?, ?, ?, ?)";
                            $sql2 = "INSERT INTO t_persontype (PersonID, TypeID) 
                            VALUES (?, ?)";
                            $stmt = $conn->prepare($sql);
                            $stmt2 = $conn->prepare($sql2);
                            $hashedString = password_hash($_POST["reg_password"], PASSWORD_DEFAULT);
                            if ($fileinfo == null) {
                                $stmt->execute([$_POST["reg_firstname"], $_POST["reg_surname"], $_POST["reg_address"], $hashedString, $_POST["reg_email"]]);
                            } else {
                                $stmt->execute([$fileinfo["firstname"], $fileinfo["name"], $fileinfo["streetandnumber"], $hashedString, $_POST["reg_email"]]);
                            }
                            if (isset($_POST["reg_client"])) {
                                $lastInsertId = $conn->lastInsertId();
                                $stmt2->execute([$lastInsertId, "1"]);
                            }
                            if (isset($_POST["reg_worker"])) {
                                $lastInsertId = $conn->lastInsertId();
                                $stmt2->execute([$lastInsertId, "2"]);
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
        </div>
        <!--Forgot password PHP-->
        <div>
            <?php
            if (isset($_POST["forgotpass"]) && $_POST["forgotpass"] == "forgotpass") {
                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $conn->query("SELECT * FROM t_person");
                    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($res as $row) {
                        if ($row["pEmail"] == $_POST["for_email"]) {
                            Bootstrap_alert("primary", "Email Sent", "Email sent to" . $_POST["for_email"]);
                        }
                    }
                } catch (PDOException $e) {
                    Bootstrap_alert("danger", "Error", $e->getMessage());
                }
            }
            ob_end_flush();
            ?>
        </div>
    </div>

    <!-- Add Bootstrap JS and jQuery if needed -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

    <script>
        // Run this script when the page is loaded
        $(document).ready(function () {
            // Handle the switch to register form
            $("#switch-to-register").click(function () {
                // Hide the switch-to-register button and show the switch-to-login and switch-to-forgotpass buttons
                $("#switch-to-forgotpass").show();
                $("#switch-to-register").hide();
                $("#switch-to-login").show();
                // Hide the login form and show the register form
                $("#login-form").hide();
                $("#register-form").show();
                $("#forgotpassword-form").hide();
            });

            // Handle the switch back to the login form
            $("#switch-to-login").click(function () {
                // Hide the switch-to-login button and show the switch-to-register and switch-to-forgotpass buttons
                $("#switch-to-login").hide();
                $("#switch-to-forgotpass").show();
                $("#switch-to-register").show();
                // Hide the register form and forgot form then show the login form
                $("#register-form").hide();
                $("#forgotpassword-form").hide();
                $("#login-form").show();
            });

            // Handle the switch to the forgot password form
            $("#switch-to-forgotpass").click(function () {
                // Hide both the login and register forms
                $("#login-form").hide();
                $("#register-form").hide();
                // Show the forgot password form
                $("#forgotpassword-form").show();
                // Show the switch-to-register and switch-to-login and hide switch-to-forgotpass buttons
                $("#switch-to-register").show();
                $("#switch-to-login").show();
                $("#switch-to-forgotpass").hide();
            });
        });

        // Handle file drop event for registration
        const fileInput = document.getElementById("customFile");
        fileInput.addEventListener("drop", function (event) {
            const file = event.dataTransfer.files[0];
            if (file) {
                // Handle the dropped file, e.g., validate and process it
                var label = document.querySelector('label[for="customFile"]');
                label.textContent = file.name; // Update the label with the file name
            }
        });

        function changeColor() {
            var textbox = document.getElementById('myTextbox');
            // Change the color to default (remove error class) on every input
            textbox.classList.remove('error');
        }
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
        function toggleSwitch(id) {
            if (id === 'Client-login') {
                // Si le switch Client est activé, désactive le switch Worker
                document.getElementById('Worker-login').checked = false;
            } else if (id === 'Worker-login') {
                // Si le switch Worker est activé, désactive le switch Client
                document.getElementById('Client-login').checked = false;
            }
        }
    </script>
</body>

</html>