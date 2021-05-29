<?php

session_start();
include_once("OrderingSystem.php");
$system = new OrderingSystem();

if (isset($_POST["search"])) {
    $value = $_POST["searchValue"];
    $redirect = true;
} else {
    $redirect = false;
}
?>

<html lang="en">

<head>
    <link rel="icon" href="assets/logo.png" type="image/x-icon"> <!-- logo at top bar -->
    <link href="baseStyle.css" rel="stylesheet">
</head>

<body>
    <script>
        //toggle between show/hide on button click
        function clickShow(menu) {
            if (menu == 1) {
                document.getElementById("drop1").classList.toggle("show");
            }
            if (menu == 2) {
                document.getElementById("drop2").classList.toggle("show");
            }

            //hide dropdown menu when anywhere outside is clicked
            window.onclick = function(event) {
                if (!event.target.matches('.dropButton')) {
                    var dropdown = document.getElementsByClassName("dropContent");
                    var i;
                    for (i = 0; i < dropdown.length; i++) {
                        var openDropdown = dropdown[i];
                        if (openDropdown.classList.contains('show')) {
                            openDropdown.classList.remove('show');
                        }
                    }
                }
            }
        }
    </script>

    <script>
        var x = <?php echo $redirect ?>;
        if (x) {
            var searchVar = <?php echo "'$value'" ?>;
            var path = 'SearchPage.php?value=';
            location.href = path.concat(searchVar);
        }
    </script>

    <header>
        <!-- replace href "#" with corresponding pages name in the future -->
        <div id="logoRow">
            <a class="logo" href="home.php"><img src="assets/logo.png" alt="Fast Food Order" width=auto height="60"></a>

            <form class="searchBar" method='POST'>
                <input type="text" placeholder="Search" name="searchValue">
                <button name="search" type="submit">Search</button>
            </form>

            <div class="dropdown">
                <button onclick="clickShow(1)" class="dropButton">Account</button>
                <div id="drop1" class="dropContent">
                    <?php
                    if ($system->isLoggedIn()) {
                        echo "<a href='logout.php?doLogout=true'>Logout</a>
                        <a href='Orders.php'>Order history</a>
                        <a href='settings.php'>Settings</a>";
                        if ($system->getSession()->isAdmin()) {
                            echo "<a href='admin_listShop.php'>Admin - Restaurant List</a>";
                        }
                    } else {
                        echo "<a href='login.php'>Sign In</a>
                        <a href='Register.php'>Register</a>";
                    }
                    ?>
                </div>
            </div>

            <a class="cartImg" href="cart.php"><img src="assets/cart.png" alt="Shopping Cart" height="60" width=auto></a>
        </div>

        <div id="navigation">
            <div class="dropdown">
                <button onclick="clickShow(2)" class="dropButton">Restaurants</button>
                <div id="drop2" class="dropContent">
                    <?php
                    foreach ($system->getRestaurants() as $id => $restaurant) {
                        $name = $restaurant->getName();
                        echo "<a href='RestaurantList.php?RestaurantID=$id'>$name</a>";
                    }
                    ?>
                </div>
            </div>

            <div class="navbarMenu">
                <a class="navSelect" href="ContactUs.php">Contact Us</a>
                <a class="navSelect" href="home.php">Home</a>
            </div>
        </div>
    </header>
</body>
<html>
