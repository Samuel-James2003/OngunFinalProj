<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login and Register</title>
    <!-- Add your styles here -->

</head>

<body>

    <!-- Registration and Login Forms -->
    <div class="container-sm">
        <h2>Login or Register</h2>

        <!-- Login Form -->
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

        <!-- Registration Form -->
        <form id="register-form" method="post" style="display: none;">
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

        <!-- Forgot Password Form -->
        <form id="forgotpassword-form" method="post" style="display: none;">
            <div class="form-group">
                <label for="email-forgotpassword">Email:</label>
                <input type="email" class="form-control" id="email-forgotpassword" placeholder="Enter your email" name="for_email">
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
        <!-- PHP Code -->
        <?php
        require 'ReadID.php';
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

                    if (($row['pEmail'] == $Email) && (password_verify($Password, $row['pPassword']))) {
                        echo 'login sucessful';
                    }
                }
            } catch (PDOException $e) {
                echo "Error: '" . $e->getMessage();
            }
        }
        if (isset($_POST["register"]) && $_POST["register"] == "register") {
            if (!$_FILES['customFile']['error'] == 4 && !($_FILES['customFile']['size'] == 0 && !$_FILES['customFile']['error'] == 0)) {
                $fileinfo = extractDataFromFile($_FILES['customFile']['name']);
                
            }
            if (!empty($_POST["reg_password"]) && !empty($_POST["reg_firstname"]) && !empty($_POST["reg_surname"]) && !empty($_POST["reg_address"]) && !empty($_POST["reg_email"])) {
                if ((strlen($_POST["reg_password"]) >= 8) && (strlen($_POST["reg_firstname"]) >= 2) && (strlen($_POST["reg_address"]) >= 8)) {
                    //Ligne à erreur ... jsp pourquoi 
                    if (filter_var($_POST["reg_email"], FILTER_VALIDATE_EMAIL)) {
                        try {
                            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $sql = "INSERT INTO t_person (pName, pSurname, pAddress, pPassword, pEmail) 
                            VALUES (?, ?, ?, ?, ?)";
                            $stmt = $conn->prepare($sql);
                            $hashedString = password_hash($_POST["reg_password"], PASSWORD_DEFAULT);
                            $stmt->execute([$_POST["reg_firstname"], $_POST["reg_surname"], $_POST["reg_address"], $hashedString, $_POST["reg_email"]]);
                        } catch (PDOException $e) {
                            echo "Error: '" . $e->getMessage();
                        }
                    } else {
                        echo "Invalid email address. <br>";
                    }
                } else {
                    echo "Not enough character, Password min 8 characters, firstname min 2 characters and address min 8 characters <br>";
                }
            } else {
                echo "Missing field. <br>";
            }
        }

        if (isset($_POST["forgotpass"]) && $_POST["forgotpass"] == "forgotpass") {
            echo "hello";

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $conn->query("SELECT * FROM t_person");
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($res as $row) {
                    if ($row["pEmail"] == $_POST["for_email"]) {
                        echo '<div class="alert alert-primary" role="alert">
                         <h4 class="alert-heading">Email sent</h4>
                         <p>Email sent to ' . $_POST["for_email"] . '</p>
                         <hr>
                       </div>';
                    }
                }
            } catch (PDOException $e) {
                echo "Error: '" . $e->getMessage();
            }
        }

        ?>
    </div>

    <!-- Add Bootstrap JS and jQuery if needed -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>

    <script>
        // Run this script when the page is loaded
        $(document).ready(function() {
            // Handle the switch to register form
            $("#switch-to-register").click(function() {
                // Hide the switch-to-register button and show the switch-to-login button
                $("#switch-to-register").hide();
                $("#switch-to-login").show();
                // Hide the login form and show the register form
                $("#login-form").hide();
                $("#register-form").show();
                $("#forgotpassword-form").hide();
            });

            // Handle the switch back to the login form
            $("#switch-to-login").click(function() {
                // Hide the switch-to-login button and show the switch-to-register button
                $("#switch-to-login").hide();
                $("#switch-to-register").show();
                // Hide the register form and forgot form then show the login form
                $("#register-form").hide();
                $("#forgotpassword-form").hide();
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
        });
    </script>
    <script>
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
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
</body>

</html>