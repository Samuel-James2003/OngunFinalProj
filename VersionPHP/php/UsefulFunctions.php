<?php
require "Alerts.php";
require "ReadID.php";
require "NavbarFilling.php";
function echoHtmlCode($title) {
    echo '<!doctype html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<title>'.$title.'</title>';
    echo '<meta charset="utf-8" />';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />';
    echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />';
    echo '</head>';
    echo '<body>';
    echo '<header>';
    // You can add your navbar code here
    echo '</header>';
    echo '<main>' . '</main>';
    echo '<footer>';
    // You can add your footer code here
    echo '</footer>';
    echo '<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>';
    echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>';
    echo '</body>';
    echo '</html>';
}
?>