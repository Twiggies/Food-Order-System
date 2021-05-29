<?php
include_once("html_header.php");
$RestaurantID = $_GET["RestaurantID"];
$restaurant = $system->getRestaurantByID($RestaurantID);
$pageTitle = "Fast Food Order - ".$restaurant->getName(); //change "Template" to whatever needed
?>

<html lang="en">

<head>
    <script>
        document.title = <?php echo json_encode($pageTitle) ?>;
    </script>
    <style>
    #restaurantImage {
        width: auto;
        height :150;
    }

    #foodPhoto {
        width: auto;
        height :80;
    }

    table, td {
        margin-top: 2em;
        border: 2px solid black;
        border-collapse: collapse;
        padding: 2em;
        font-size: 25px;
        font-family: Arial, Helvetica, sans-serif;
    }

    .restaurantContainer{
        background-color: #f5bc51;
        padding: 2em;
    }
    
    #restaurantTable{
        background-color: #f5bc51;
        text-align: center;
        margin: auto;
    }
    </style>
</head>

<body>
    <div class="restaurantContainer">
        <?php 
            echo "<h2>".$restaurant->getName()."</h2>";
            $image = $restaurant->getLogo();
            
            echo "<img src='$image'  id='restaurantImage'>";
        ?>
        <table id="restaurantTable">
        <tr>
            <th>Menu</th>
            <th>Description</th>
            <th>Price</th>
            <th></th>
        </tr>
        <?php
                foreach($system->getMenusFromRes($RestaurantID) as $menu){
                    $description = [];
                    $id = $menu->getId();
                    foreach($menu->getDescription() as $item){
                        list($name, $amount) = $item;
                        $description[] = "$name x$amount";
                    }
                    echo "<tr>";
                    echo "<td><a href='MenuPage.php?MenuId=$id'>" . $menu->getName() . "</a></td>";
                    echo "<td>" . implode(",", $description) . "</td>";
                    echo "<td>" . $menu->getPrice() . "</td>";
                    echo "<td><img src='" .$menu->getLogo() . "' id='foodPhoto'></td>";
                    echo "</tr>";
                }
        ?>
        </table>
    </div>
</body>
    
<?php
include_once("footer.php");
?>

</html>