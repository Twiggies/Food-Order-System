<?php
include_once("html_header.php");

$pageTitle = "Fast Food Order - Restaurant List - Admin View"; //change "Template" to whatever needed
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
                echo "<div id='sidebar'>
                <a href='admin_addShop.php'><button id='addR' type='button'>Add Restaurant</button></a>
                </div>
                
                <div id='main'>
                <h2>Restaurants</h2>
                
                <table border='solid'>
                <tr>
                <th class='id'>ID</th>
                <th class='name'>Name</th>
                <th>Logo</th>
                </tr>";
                $num = 1;
                foreach ($system->getRestaurants() as $id => $restaurant) {
                    echo "<tr>";
                    echo "<td>" . $num . "</td>";  //used $num to avoid weird numbering if changes is made to database
                    echo "<td><a href='admin_listMenu.php?targetId=" . $id . "'>" . $restaurant->getName() . "</a></td>";
                    echo "<td><img src='" . $restaurant->getLogo() . "'></td>";
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