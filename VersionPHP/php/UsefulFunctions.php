<?php
require "Alerts.php";
require "ReadID.php";
require "NavbarFilling.php";

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
function echoHtmlCode($title, $jobID, $ID)
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

        echo '<div class="form-group">
      <label for="datetime">Date and Time:</label>
      <input type="datetime-local" class="form-control" id="datetime" name="datetime" required>
    </div>

    <div class="form-group">
      <label for="options">Select an option:</label>
      <select class="form-control" id="options" name="options" required>';

        $options = array("Option 1", "Option 2", "Option 3");
        
        foreach ($options as $option) {
            echo "<option value='" . htmlspecialchars($option) . "'>" . htmlspecialchars($option) . "</option>";
        }
        echo '</select>';

    }
    echo '</main>';
    echo '<footer>';
    // You can add your footer code here
    echo '</footer>';
    echo '<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>';
    echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>';
    echo '</body>';
    echo '</html>';
}
?>