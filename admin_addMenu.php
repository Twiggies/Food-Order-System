<?php
include_once("html_header.php");

$shopID = $_GET['shopID'];
$shop = $system->getRestaurantByID($shopID);
$pageTitle = "Add Menu - " . $shop->getName() . " - Admin View"; //change "Template" to whatever needed
?>

<html lang="en">

<head>
    <link href="admin2.css" rel="stylesheet">
    <script>
        document.title = <?php echo json_encode($pageTitle) ?>;
    </script>
</head>

<?php
if (isset($_POST["menu"])) {
    $system->addMenu($_POST["menuname"], $_POST["menufood"], $_POST["menudrink"], $shopID, $_POST["menuprice"], $_POST["menulogo"]);
    echo "<script>window.alert('Menu added successfully.'); window.location.replace('admin_listMenu.php?targetId=" . $shopID . "')</script>";
}
?>

<body>
    <div id="container">
        <?php
        if (!$system->isLoggedIn()) {
            echo "<h3 style= 'text-align: center'>Error: No permission</h3>";
        } else {
            if ($system->getSession()->isAdmin()) {
                echo "<form class='addForm' action='' method='post'>";
                echo "<input type='hidden' name='menu' value='1'>";
                echo "<p>";
                echo "<label> Menu Name:</label> <input size='25' type='text' name='menuname' />";
                echo "</p>";
                echo "<p>";
                echo "<label> Menu Food:</label> <input size='25' type='text' placeholder='food1:amount1,food2:amount2' name='menufood' />";
                echo "</p>";
                echo "<p>";
                echo "<label> Menu Drink:</label> <input size='25' type='text' placeholder='drink1:amount1,drink2:amount2' name='menudrink' />";
                echo "</p>";
                echo "<p>";
                echo "<label> Menu Price:</label> <input type='number' step='0.01' name='menuprice' />";
                echo "</p>";
                echo "<p>";
                echo "<label> Menu Logo URL:</label> <input type='text' placeholder='Leave blank for default' name='menulogo' />";
                echo "</p>";
                echo "<br>";
                echo "<button class='addBtn' name='menu' type='submit'>Add Menu</button>";
                echo "</form>";
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