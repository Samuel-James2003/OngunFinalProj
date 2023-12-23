<!-- PHP Code -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

                if (($row['pEmail'] == $Email) && (password_verify($Password, $row['pPassword']))) {
                    echo 'login sucessful';
                }
            }
        } catch (PDOException $e) {
            echo "Error: '" . $e->getMessage();
        }
    }
    if (isset($_POST["register"]) && $_POST["register"] == "register") {
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
}
?>