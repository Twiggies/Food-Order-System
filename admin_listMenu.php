<?php
include_once("html_header.php");

$shopID = $_GET['targetId'];
$shop = $system->getRestaurantByID($shopID);
$pageTitle = $shop->getName() . " Menu List - Admin View"; //change "Template" to whatever needed
?>

<html lang="en">

<head>
    <link href="admin1.css" rel="stylesheet">
    <script>
        document.title = <?php echo json_encode($pageTitle) ?>;
    </script>
</head>

<body>
    <div id="adminContainer">
        <?php
        if (!$system->isLoggedIn()) {
            echo "<h3 style= 'text-align: center'>Error: No permission</h3>";
        } else {
            if ($system->getSession()->isAdmin()) {
                echo "<div id='sidebar'>";
                echo "<img class='shopLogo' src='"   . $shop->getLogo()   .   "'><br><br>";
                echo "<a href='admin_addMenu.php?shopID=" . $shopID . "'><button id='addR' type='button'>Add Menu</button></a>";
                echo "</div>";

                echo "<div id='main'>";
                echo "<h2>Menu for " . $shop->getName() . "</h2>";
                echo "<table id='menus' border='solid'>";
                echo "<tr>";
                echo "<th class='id'>ID</th>";
                echo "<th class='name'>Name</th>";
                echo "<th class='details'>Description</th>";
                echo "<th class='price'>Price (RM)</th>";
                echo "<th>Picture</th>";
                echo "</tr>";

                $num = 1;
                foreach ($system->getMenusFromRes($shopID) as $menu) {
                    $details = [];
                    foreach ($menu->getDescription() as $item) {
                        list($name, $amount) = $item;
                        $details[] = "$name x$amount";
                    }
                    echo "<tr>";
                    echo "<td>" . $num . "</td>";
                    echo "<td>" . $menu->getName() . "</td>";
                    echo "<td>" . implode(",", $details) . "</td>";
                    echo "<td>" . $menu->getPrice() . "</td>";
                    echo "<td><img src='" . $menu->getLogo() . "'></td>";
                    echo "</tr>";
                    $num++;
                }

                echo "</table>";
                echo "</div>";
            } else {
                echo "<h3 style= 'text-align: center'>Error: No permission</h3>";
            }
        }
        ?>
    </div>
</body>

<?php
include_once("footer.php");
?>

</html>