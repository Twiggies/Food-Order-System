<?php
include_once("html_header.php");

$pageTitle = "Fast Food Order - Shopping Cart"; //change "Template" to whatever needed



?>

<html lang="en">

<head>
    <link href="cartStyle.css" rel="stylesheet">
    <script>
        document.title = <?php echo json_encode($pageTitle) ?>;
    </script>
</head>

<body>
    <div id="cartContainer">
        <div id="cartMain">
            <?php
            if (!$system->isLoggedIn()) {
                echo "<div id='overlay'>Account <a href='login.php'>log in</a> is required to view cart.</div>";
            } else {
                echo "<table style='text-align:center'>";
                echo "<tr>";
                echo "<th>Product</th>";
                echo "<th>Quantity</th>";
                echo "<th>Unit Price</th>";
                echo "<th>Total Price</th>";
                echo "</tr>";
                foreach ($system->getSession()->getCart() as $menu) {
                    echo "<tr>";
                    echo "<td>" . $menu->getName() . "</td>";
                    echo "<td>" . $menu->getAmount() . "</td>";
                    echo "<td>" . sprintf('%0.2f', $menu->getPrice()) . "</td>";
                    echo "<td>" . sprintf('%0.2f', $menu->getAmount() * $menu->getPrice()) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            ?>
        </div>

        <div id="cartLeftBar">
            <?php
            if ($system->isLoggedIn()) {
                echo $system->getSession()->getUsername()  .  "'s shopping cart.";
            } else {
                echo "Not signed in.<br>Please <a href='login.php'>sign in here</a> to view your cart.";
            }
            ?>
        </div>

        <div id="cartRightBar">
            <div id="priceOutput">
                GRAND TOTAL: <br>
                <?php
                if ($system->isLoggedIn()) {
                    $totalprice = 0;
                    foreach ($system->getSession()->getCart() as $menu) {
                        $totalprice += $menu->getPrice() * $menu->getAmount();
                    }
                    echo "RM" . sprintf('%0.2f', $totalprice);
                } else {
                    echo "N/A";
                }
                ?>
            </div>
            <br>
            <?php
            if ($system->isLoggedIn()) {
                echo "<a href='Payment.php'><button class='checkoutBtn'>Checkout</button></a>";
            } else {
                echo "<button class='checkoutBtn' disabled>Not Available</button>";
            }

            ?>
        </div>

    </div>
</body>

<?php
include_once("footer.php");
?>

<html>