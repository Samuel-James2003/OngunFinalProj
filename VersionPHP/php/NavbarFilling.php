<?php
function FillNavBar()
{
    echo ' <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelFumd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>';
    $servername = 'localhost';
    $dbname = "bdvacances";
    $username = 'root';
    $pass = '';
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->query("SELECT * FROM t_menu
    LEFT JOIN t_submenu ON t_menu.MenuID = t_submenu.MenuID
    ORDER BY t_menu.MenuID;
    ");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $navItems = [];
    foreach ($results as $row) {
        $menuID = $row['MenuID'];
        $submenuID = isset($row['SubMenuID']) ? $row['SubMenuID'] : "";

        if (!isset($navItems[$menuID])) {
            $navItems[$menuID] = [
                'MName' => $row['MName'],
                'MPath' => $row['MPath'],
                'submenus' => [],
            ];
        }

        if ($submenuID != "") {
            $navItems[$menuID]['submenus'][] = [
                'SMName' => $row['SMName'],
                'SMPath' => $row['SMPath'],
            ];

        }

    }
    foreach ($navItems as $menuID => $menuItem) {
        // Output main menu buttons
        echo '<div class="btn-group">';
        if (empty($menuItem['submenus'])) {
            echo '<button type="button" class="btn btn-primary" onclick="location.href=\'' . $menuItem['MPath'] . '\'">' . $menuItem['MName'] . '</button>';
        } else {
            echo '<button type="button" class="btn btn-primary" onclick="location.href=\'#\'">' . $menuItem['MName'] . '</button>';
        }
        // Output dropdown if there are submenus
        if (!empty($menuItem['submenus'])) {
            echo '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            echo '<span class="sr-only">Toggle Dropdown</span>';
            echo '</button>';
            echo '<div class="dropdown-menu">';

            // Output submenu buttons
            foreach ($menuItem['submenus'] as $submenu) {
                echo '<a class="dropdown-item" href="' . $submenu['SMPath'] . '">' . $submenu['SMName'] . '</a>';
            }

            echo '</div>';
        }

        echo '</div>';
    }
    echo '<script src="https://unpkg.com/@popperjs/core@2"></script>';
    echo "<script>
    $('.dropdown-toggle').dropdown() 
    </script>";
    echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>';
}
?>