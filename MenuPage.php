<?php
include_once("html_header.php");

$pageTitle = "Fast Food Order - Menu"; //change "Template" to whatever needed

$menuId = $_GET["MenuId"];
$menu = $system->getMenuFromId($menuId);
$id = $menu->getRestaurantId();

if (isset($_POST["toCart"])) {
    $menu->setAmount($_POST["quantity"]);
    $system->addToCart($menu);
    echo "<script>window.alert('Add to cart successfully.'); window.location.replace('RestaurantList.php?RestaurantID=$id')</script>";
}

?>

<html lang="en">

<head>
    <link href="menuStyle.css" rel="stylesheet">
    <script>
        document.title = <?php echo json_encode($pageTitle) ?>;
    </script>
</head>

<body>
    <div id="menuContainer">
        <!-- INSERT CODE HERE -->
        <div id="menuMain">
            <h3>Foods</h3>
            <table style="text-align:center">
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                </tr>
                <?php
                $menu = $system->getMenuFromId($menuId);
                foreach ($menu->getFoods() as $food) {
                    list($name, $amount) = $food;
                    echo "<tr>";
                    echo "<td>" . $name . "</td>";
                    echo "<td>" . $amount . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
            <br>
            <h3>Drinks</h3>
            <table style="text-align:center">
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                </tr>
                <?php
                foreach ($menu->getDrinks() as $drink) {
                    list($name, $amount) = $drink;
                    echo "<tr>";
                    echo "<td>" . $name . "</td>";
                    echo "<td>" . $amount . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>

        <div id="menuLeftBar">
            <?php
            $resId = $menu->getRestaurantId();
            echo "Menu from restaurant: <a href='RestaurantList.php?RestaurantID=$resId'>" . $system->getRestaurantByID($resId)->getName() . "</a>";
            ?>
        </div>

        <div id="menuLeftName">
            <?php
            echo "<b>" . $menu->getName() . "</b>";
            ?>
        </div>

        <div id="menuLeftLogo">
            <?php
            $path = $menu->getLogo();
            echo "<img style='width: 128px; height: 128px;' src='$path'>";
            ?>
        </div>

        <div id="menuLeftPrice">
            <?php
            echo "<b>Menu's Price: RM" . $menu->getPrice() . "</b>";
            ?>
        </div>

        <div id="menuRightBar">
            <?php
            if(!$system->isLoggedIn()){
                echo "Account <a href='login.php'>log in</a> is required to add menu to cart.";
            } else {
                echo "<h3>Quantity</h3>";
                echo "<form class='addForm' action='' method='post'>";
                echo "<input type='hidden' name='toCart' value='1'>";
                echo "<p>";
                echo "<input type='number' min='1' max='5' value='1' name='quantity'>";
                echo "</p>";
                echo "<br> <button class='addBtn' name='toCart' type='submit'>Add to cart</button>";
                echo "</form>";
            }
            ?>
        </div>

    </div>
</body>

<?php
include_once("footer.php");
?>

<html>