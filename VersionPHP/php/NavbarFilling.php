<?php
function FillNavBar($ID)
{
    echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">';

    $servername = 'localhost';
    $dbname = "bdvacances";
    $username = 'root';
    $pass = '';
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($ID == 1) {
        $stmt = $conn->query("SELECT t_menu.MenuID, t_menu.MName, t_menu.MPath, t_submenu.SubMenuID, t_submenu.SMName, t_submenu.SMPath
    FROM t_menu
    LEFT JOIN t_submenu ON t_menu.MenuID = t_submenu.MenuID
    ORDER BY t_menu.MenuID;
    ");
    }
    else{
        $stmt = $conn->query("SELECT t_menu.MenuID, t_menu.MName, t_menu.MPath, t_submenu.SubMenuID, t_submenu.SMName, t_submenu.SMPath
        FROM t_menu
        LEFT JOIN t_submenu ON t_menu.MenuID = t_submenu.MenuID
        WHERE t_menu.MName != 'admin'
        ORDER BY t_menu.MenuID;");
    }

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

    echo '<div class="btn-group">';
    foreach ($navItems as $menuID => $menuItem) {
        if (empty($menuItem['submenus'])) {
            echo '<button type="button" class="btn btn-primary" onclick="location.href=\'' . $menuItem['MPath'] . '\'">' . $menuItem['MName'] . '</button>';
        } else {
            echo '<button type="button" class="btn btn-primary" onclick="location.href=\'#\'">' . $menuItem['MName'] . '</button>';
        }
        if (!empty($menuItem['submenus'])) {
            echo '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            echo '<span class="visually-hidden">Toggle Dropdown</span>';
            echo '</button>';
            echo '<div class="dropdown-menu">';

            foreach ($menuItem['submenus'] as $submenu) {
                echo '<a class="dropdown-item" href="' . $submenu['SMPath'] . '">' . $submenu['SMName'] . '</a>';
            }

            echo '</div>';
        }
    }
    echo '</div>';
    echo '<script src="https://unpkg.com/@popperjs/core@2"></script>';
    echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-rBSUqQn39dzKUeUQkSTgN5K7LhCfr9ji2nEkj0QCOrUtWCCRoC64I2enWMEFuJhA" crossorigin="anonymous"></script>';
    echo "<script>$('.dropdown-toggle').dropdown()</script>";
}


?>