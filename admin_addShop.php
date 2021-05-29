<?php
include_once("html_header.php");

$pageTitle = "Add Restaurant - Admin View"; //change "Template" to whatever needed
?>

<html lang="en">

<head>
    <link href="admin2.css" rel="stylesheet">
    <script>
        document.title = <?php echo json_encode($pageTitle) ?>;
    </script>
</head>

<?php
if (isset($_POST["restaurant"])) {
    $system->addRestaurant($_POST["resname"], $_POST["reslogo"]);
    echo "<script>window.alert('Restaurant added successfully.'); window.location.replace('admin_listShop.php')</script>";
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
                echo "<input type='hidden' name='restaurant' value='1'>";
                echo "<p>";
                echo "<label> Restaurant Logo URL:</label> <input type='text' placeholder='(Leave blank for default)' name='reslogo'>";
                echo "</p>";
                echo "<p>";
                echo "<label> Restaurant Name:</label> <input type='text' name='resname'>";
                echo "</p>";
                echo "<br> <button class='addBtn' name='restaurant' type='submit'>Add Restaurant</button>";
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