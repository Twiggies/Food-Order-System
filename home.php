<?php
include_once("html_header.php");

$pageTitle = "Fast Food Order"; //change "Template" to whatever needed
?>

<html lang="en">

<head>
    <link href="homeStyle.css" rel="stylesheet">
    <script>
        document.title = <?php echo json_encode($pageTitle) ?>;
    </script>
</head>

<body>
    <div id="container">
        <h2>Featured menu</h2>
        <div id="featured">
            <?php
            $shopID = rand(1, 2);
            foreach ($system->getMenusFromRes($shopID) as $menu) {
                $menuID = $menu->getId();
                echo "<div id='box'>";
                echo "<img src='" . $menu->getLogo() . "'><br>";
                echo "<b>" . $menu->getName() . "</b><br>";
                echo "Price: RM " . $menu->getPrice();
                echo "<a href='MenuPage.php?MenuId=$menuID'><button id='viewButton'>View</button></a>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</body>

<?php
include_once("footer.php");
?>

</html>