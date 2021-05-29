<?php
include_once("html_header.php");

$pageTile = "Fast Food Order - Order History";
?>

<html lang="en">

<head>
    <link href="cartStyle.css" rel="stylesheet">
    <script>
        document.title = <?php echo json_encode($pageTile) ?>;
    </script>
</head>

<div id="cartContainer">
    <!-- INSERT CODE HERE -->
    <div id="cartMain">
        <?php
        if (!$system->isLoggedIn()) {
            echo "<div id='overlay'>Account <a href='login.php'>log in</a> is required to view cart.</div>";
        }
        ?>
        <table style="text-align: center">
            <tr>
                <th>Order</th>
                <th>Date</th>
                <th>Total Price</th>
            </tr>
            <?php
            foreach ($system->getOrders($system->getSession()->getUsername()) as $order) {
                $menus = [];
                $totalPrice = 0;
                foreach ($order->getMenus() as $id => $menu) {
                    $menus[] = "- " . $menu->getName() . " x" . $menu->getAmount();
                    $totalPrice += $menu->getPrice() * $menu->getAmount();
                }
                $menusName = implode("<br>", $menus);
                echo "<tr>";
                echo "<td>" . $menusName . "</td>";
                echo "<td>" . date("H:i:sa d-m-Y", $order->getTimestamp()) . "</td>";
                echo "<td>" . $totalPrice . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

    <div id="cartLeftBar">
        <?php
        if ($system->isLoggedIn()) {
            echo $system->getSession()->getUsername()  .  "'s order history.";
        } else {
            echo "Not signed in.<br>Please <a href='login.php'>sign in here</a> to view your cart.";
        }
        ?>
    </div>

</div>

<?php
include_once("footer.php");
?>

</html>