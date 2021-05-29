<?php


include_once("OrderingSystem.php");
$system = new OrderingSystem();

$pageTitle = "Fast Food Order - Payment"; //change "Template" to whatever needed


?>

<html lang="en">

<head>
    <title><?php echo "$pageTitle"; ?></title> <!-- page title in top bar -->
    <link rel="icon" href="assets/logo.png" type="image/x-icon"> <!-- logo at top bar -->
    <link href="baseStyle.css" rel="stylesheet">
    <link href="cartStyle.css" rel="stylesheet">
</head>

<body>
    <?php
    include_once("html_header.php");
    if (!empty($_POST["address"])) {
        $session = $system->getSession();
        if ($session->setAddress($_POST["address"])) {
            $system->setSession($session);
        }
    }

    if (isset($_POST["placeOrder"])) {
        if ($system->isLoggedIn()) {
            if ($system->placeOrder()) {
                echo "<script> window.alert('Order Placed. Please pay when the driver arrives. Thank you.'); window.location.replace('home.php')</script>";
            } else {
                echo "<script> window.alert('Order cannot be placed');</script>";
            }
        }
    }
    ?>



    <div id="payContainer">
        <!-- INSERT CODE HERE -->
        <div id="payMain">
            <?php
            if (!$system->isLoggedIn()) {
                echo "<div id='overlay'>Account <a href='login.php'>log in</a> is required to view cart.</div>";
            }
            ?>
            Address to be used for delivery is as follows:
            <div id="payAddress">
                <?php
                echo  $system->getSession()->getAddress();
                ?>
            </div>
            <br> Want to use another address? </br>
            <form action="" method="post">
                <br> Address : <input type="text" placeholder="Address" name="address" />

                <div id="priceContainer">
                    <div id="grandTotal">
                        Grand total:
                        <?php
                        $totalprice = 0;
                        foreach ($system->getSession()->getCart() as $menu) {
                            $totalprice += $menu->getPrice() * $menu->getAmount();
                        }
                        echo "RM" . $totalprice;
                        ?>
                    </div>
                </div>
                <div id="payButton">
                    <div id="CODbutton">
                        <button type="submit" name="placeOrder">Pay by COD</button>
                    </div>
                </div>
            </form>
        </div>

        <div id="payLeftBar">
            <?php
            if ($system->isLoggedIn()) {
                echo $system->getSession()->getUsername()  .  "'s shopping cart.";
            } else {
                echo "Not signed in.<br>Please <a href='login.php'>sign in here</a> to view your cart.";
            }
            ?>
        </div>



    </div>
</body>

<?php
include_once("footer.php");
?>

<html>