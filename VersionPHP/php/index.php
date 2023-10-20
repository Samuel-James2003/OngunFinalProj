<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ServiceFinder</title>
    <!-- Add Botstrap CSS -->
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
        <a class="navbar-brand" href="#">Menu</a>
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
                    <a class="nav-link" id="show-login-reg">Login</a>
                </li>
            </ul>
        </div>
    </nav>



    <!-- Entry Page Content -->
    <div class="container">
        <center>
            <h1>Welcome to Your Website</h1>
        </center>
        <p>This is the entry page content.</p>
    </div>



    <!-- Login/Register Popup -->
    <div id="login-register-popup">
        <div class="popup-content">
            <button id="close-popup" class="close-button">&#215;</button>
            <br>
            <h2>Login or Register</h2>
            <form id="login-form" method="post">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email-login" placeholder="Enter your email" name="log_email">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter your password" name="log_password">
                </div>
                <input type="hidden" name="login" value="login">
                <button type="submit" class="btn btn-primary" name="submit" value="login">Login</button>
            </form>
            <form id="register-form" style="display: none;" method="post">
                <div class="form-group">
                    <label for="email-register">Email:</label>
                    <input type="email" class="form-control" id="email-register" placeholder="Enter your email" name="reg_email">
                </div>
                <div class="form-group">
                    <label for="password-register">Password:</label>
                    <input type="password" class="form-control" id="password-register" placeholder="Enter your password" name="reg_password">
                </div>
                <div class="form-group">
                    <label for="firstname-register">First Name:</label>
                    <input type="firstname" class="form-control" id="firstname-register" placeholder="Enter your first name" name="reg_firstname">
                </div>
                <div class="form-group">
                    <label for="surname-register">Surname:</label>
                    <input type="surname" class="form-control" id="surname-register" placeholder="Enter your surname" name="reg_surname">
                </div>
                <div class="form-group">
                    <label for="Address-register">Address:</label>
                    <input type="Address" class="form-control" id="address-register" placeholder="Enter your address" name="reg_address">
                </div>
                <div class="form-group">
                    <label for="custom-file">Place your eid file here:</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile" accept=".eid">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>
                <input type="hidden" name="register" value="register">
                <button type="submit" class="btn btn-success" name="register" value="register">Register</button>
            </form>
            <form id="forgotpassword-form" style="display: none;" method="post">
                <div class="form-group">
                    <label for="email-register">Email:</label>
                    <input type="email" class="form-control" id="email-register" placeholder="Enter your email">
                </div>
                <input type="hidden" name="forgotpass" value="forgotpass">
                <button type="submit" class="btn btn-warning" name="submit" value="forgotpass">Send new
                    password</button>
            </form>
            <button id="switch-to-register" class="btn btn-link">Switch to Register</button>
            <button id="switch-to-login" class="btn btn-link" style="display: none;">Switch to Login</button>
            <button id="switch-to-forgotpass" class="btn btn-link">I forgot my password</button>
        </div>
    </div>



    <!-- Add Bootstrap JS and jQuery for popup functionality -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    <div>

        <!-- PHP Code -->
        <?php
        //session_start();
        $servername = 'localhost';
        $dbname = "bdvacances";
        $username = 'root';
        $pass = '';
        if (isset($_POST["login"]) && $_POST["login"] == "login") {

            try {
                $Email = $_POST["log_email"];
                $Password = $_POST["log_password"];
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);

                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $conn->query("SELECT * FROM t_person");

                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($res as $row) {
                    if (($row['pEmail'] == $Email) && ($row['pPassword'] == $Password)) {
                        echo 'login sucessful';
                    }
                }
            } catch (PDOException $e) {
                echo "Error: '" . $e->getMessage();
            }
        }
        if (isset($_POST["register"]) && $_POST["register"] == "register") {
            if (!empty($_POST["reg_password"]) && !empty($_POST["reg_firstname"]) && !empty($_POST["reg_surname"]) && !empty($_POST["reg_address"]) && !empty($_POST["reg_email"]))
                // if ((strlen($_POST["reg_password"]) >= 8) && (strlen($_POST["reg_firstname"]) >= 2) && (strlen($_POST["reg_address"]) >= 15)) {
                //Ligne à erreur ... jsp pourquoi 
                if (filter_var($_POST["reg_email"], FILTER_VALIDATE_EMAIL)) {
                    try {
                        echo "hello bitch";
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        echo 'connexion réussie <br>';
                        $sql = "INSERT INTO t_person (pName, pSurname, pAddress, pPassword, pEmail) 
                            VALUES (?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([$_POST["reg_firstname"], $_POST["reg_surname"], $_POST["reg_address"], $_POST["reg_password"], $_POST["reg_email"]]);
                    } catch (PDOException $e) {
                        echo "Error: '" . $e->getMessage();
                    }
                }

            //Il faut trouver une façon elegante d'afficher les erreurs

        }

        ?>
    </div>
    <script>
        // Function to handle the click event on the "show-login-reg" element
        $("#show-login-reg").click(function() {
            // Show the login/register popup
            $("#login-register-popup").show();

            // Handle the switch to register form
            $("#switch-to-register").click(function() {
                // Hide the switch-to-register button and show the switch-to-login button
                $("#switch-to-register").hide();
                $("#switch-to-login").show();
                // Hide the login form and show the register form
                $("#login-form").hide();
                $("#register-form").show();
            });

            // Handle the switch back to the login form
            $("#switch-to-login").click(function() {
                // Hide the switch-to-login button and show the switch-to-register button
                $("#switch-to-login").hide();
                $("#switch-to-register").show();
                // Hide the register form and show the login form
                $("#register-form").hide();
                $("#login-form").show();
            });

            // Handle the switch to the forgot password form
            $("#switch-to-forgotpass").click(function() {
                // Hide both the login and register forms
                $("#login-form").hide();
                $("#register-form").hide();
                // Show the forgot password form
                $("#forgotpassword-form").show();
                // Show both the switch-to-register and switch-to-login buttons
                $("#switch-to-register").show();
                $("#switch-to-login").show();
            });

            // Handle the click event to close the popup
            $("#close-popup").click(function() {
                // Hide the login/register popup
                $("#login-register-popup").hide();
            });

            // Handle file drop event for registration
            const fileInput = document.getElementById("customFile");
            fileInput.addEventListener("drop", function(event) {
                event.preventDefault();
                const file = event.dataTransfer.files[0];
                if (file) {
                    // Handle the dropped file, e.g., validate and process it
                    var label = document.querySelector('label[for="customFile"]');
                    label.textContent = file.name; // Update the label with the file name
                }
            });
        });
    </script>



    <!-- Add Bootstrap JS and jQuery for navbar functionality -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
</body>

</html>