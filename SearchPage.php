<?php
include_once("html_header.php");

$pageTitle = "Fast Food Order - Search Result"; //change "Template" to whatever needed

$searchValue = $_GET["value"];
?>

<html lang="en">

<head>
    <link href="searchPage.css" rel="stylesheet">
    <script>
        document.title = <?php echo json_encode($pageTitle) ?>;
    </script>
</head>

<body>
    <div id="searchContainer">
        <div id="searchMain">
            <?php
            $menus = $system->searchMenu($searchValue);
            if (!empty($menus)) {
                /** @var Menu $menu */
                foreach ($menus as $menu) {
                    $logo = $menu->getLogo();
                    $id = $menu->getId();
                    echo "<div id = 'menuContainer' style='border-style: solid;'>";
                    echo "<img src='$logo' width='128px' height='128px'>";
                    echo "<br><b>" . $menu->getName() . "</b>";
                    echo "<br>Price:" . $menu->getPrice();
                    echo "<a href='MenuPage.php?MenuId=$id'><button id='viewButton'>View</button></a>";
                    echo "</div>";
                }
            } else {
                echo "No menu can be found by the name " . $searchValue;
            }
            ?>
        </div>
    </div>
</body>

<?php
include_once("footer.php");
?>

</html>