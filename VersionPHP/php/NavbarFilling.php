<?php
function FillNavBar()
{
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

        $navItems[$menuID]['submenus'][] = [
            'SMName' => $row['SMName'],
            'SMPath' => $row['SMPath'],
        ];
       
    }

    // Generate the Bootstrap-styled navigation bar
    echo '<nav class="navbar navbar-expand-lg navbar-light bg-light">';
    echo '<div class="collapse navbar-collapse" id="navbarNav">';
    echo '<ul class="navbar-nav">';

    foreach ($navItems as $menuID => $menuItem) {
        echo '<li class="nav-item">';
        echo '<a class="nav-link" href="' . $menuItem['MPath'] . '">' . $menuItem['MName'] . '</a>';

        // Check if there are submenus
        if (!empty($menuItem['submenus'])) {
            echo '<ul class="dropdown-menu">';
            echo "Hellooo there";
            foreach ($menuItem['submenus'] as $submenu) {
                echo '<li>';
                echo '<a class="dropdown-item" href="' . $submenu['SMPath'] . '">' . $submenu['SMName'] . '</a>';
                echo '</li>';
            }
            echo '</ul>';
        }

        echo '</li>';
    }

    echo '</ul>';
    echo '</div>';
    echo '</nav>';
}
?>
