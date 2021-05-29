<?php
session_start();
include_once("OrderingSystem.php");
$system = new OrderingSystem();

//register
if(isset($_POST["register"])){
    echo "Register request recieved <br>";
    if($system->register($_POST["username"], $_POST["password"], $_POST["address"])){
        echo "Register successful <br>";
    } else {
        echo "Register failed <br>";
    }
}

//login
if(isset($_POST["login"])){
    echo "Login request recieved <br>";
    if($system->login($_POST["username"], $_POST["password"])){
        echo "Login successful <br>";
    } else {
        echo "Login failed <br>";
    }
}

//logout
if(isset($_POST["logout"])){
    echo "Logout request recieved <br>";
    if($system->logout()){
        echo "Logout successful <br>";
    } else {
        echo "Not signed in <br>";
    }
}

//settings
if(isset($_POST["settings"])){
    echo "Settings request recieved <br>";
    if($system->updatePassword($_POST["oldPass"], $_POST["newPass"])){
        echo "Password changed successfully <br>";
    } else {
        echo "Password change failed <br>";
    }
}


//session
if(isset($_POST["session"])){
    echo "Session request recieved <br>";
    print_r($system->getSession());
}

//delete account
if(isset($_POST["delete"])){
    echo "Delete account request recieved <br>";
    if($system->isLoggedIn()){
        $system->deleteAccount($system->getSession()->getUsername());
        echo "Account deleted <br>";
    } else {
        echo "Not logged in <br>";
    }
}

//restaurant
if(isset($_POST["restaurant"])){
    echo "Add restaurant request recieved <br>";
    $system->addRestaurant($_POST["resname"], $_POST["reslogo"]);
}

//menu
if(isset($_POST["menu"])){
    echo "Add menu request recieved <br>";
    $system->addMenu($_POST["menuname"], $_POST["menufood"], $_POST["menudrink"], $_POST["menurestaurant"], $_POST["menuprice"], $_POST["menulogo"]);
}

if(isset($_POST["addCart"])){
    echo "Add to cart request recieved <br>";
    if($system->isLoggedIn()){
        $menuId = $_POST["menucart"] ?? -1;
        $menu = $system->getMenuFromId($menuId);
        if($menu instanceof Menu){
            if($system->addToCart($menu)){
                echo "Added to cart <br>";
            } else {
                echo "Not logged in <br>";
            }
        } else {
            echo "Cannot be added to cart <br>";
        }
    } else {
        echo "Not logged in <br>";
    }
}

if(isset($_POST["viewCart"])){
    echo "View cart request recieved <br>";
    if($system->isLoggedIn()){
        print_r($system->getSession()->getCart());
    } else {
        echo "Not logged in <br>";
    }
}

if(isset($_POST["placeOrder"])){
    echo "Place order request recieved <br>";
    if($system->isLoggedIn()){
       if($system->placeOrder()){
           echo "Order placed successful <br>";
       } else {
           echo "Order cannot be placed <br>";
       }
    } else {
        echo "Not logged in <br>";
    }
}

?>

<html lang="en">
    <body>
        ----------------<br>
        <b>Register</b>
        <form action = "" method = "post">
            <br> Username : <input type = "text" name = "username"/>
            <br> Password : <input type = "text" name = "password"/>
            <br> Address : <input type = "text" name = "address"/>
            <input type="hidden" name="register" value="1">
            <br> <input type = "submit"/>
        </form>
        <br>
        <b>Login</b>
        <form action = "" method = "post">
            <br> Username : <input type = "text" name = "username"/>
            <br> Password : <input type = "text" name = "password"/>
            <input type="hidden" name="login" value="1">
            <br> <input type = "submit"/>
        </form>

        <b>Logout</b>
        <form action = "" method = "post">
            <input type="hidden" name="logout" value="1">
            <br> <button name="logout" type="submit">Logout</button>
        </form>

        <b>Settings</b>
        <form action = "" method = "post">
            <input type="hidden" name="settings" value="1">
            <br> Old Password : <input type = "text" name = "oldPass"/>
            <br> New Password : <input type = "text" name = "newPass"/>
            <br> <button name="settings" type="submit">Change Password</button>
        </form>

        <b>Test Session</b>
        <form action = "" method = "post">
            <input type="hidden" name="session" value="1">
            <br> <button name="session" type="submit">View Session</button>
        </form>

        <b>Delete Account</b>
        <form action = "" method = "post">
            <input type="hidden" name="delete" value="1">
            <br> <button name="delete" type="submit">Delete</button>
        </form>

        <b>Restaurants</b>
        <table border="solid">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Logo</th>
            </tr>
            <?php
                foreach($system->getRestaurants() as $id => $restaurant){
                    echo "<tr>";
                    echo "<td>" . $id . "</td>";
                    echo "<td>" . $restaurant->getName() . "</td>";
                    echo "<td><img src='" . $restaurant->getLogo() . "'></td>";
                    echo "</tr>";
                }
            ?>
        </table>
        <form action = "" method = "post">
            <input type="hidden" name="restaurant" value="1">
            <br> Restaurant Name : <input type = "text" name = "resname"/>
            <br> Restaurant Logo : <input type = "text" name = "reslogo"/> Leave blank for default
            <br> <button name="restaurant" type="submit">Add restaurant</button>
        </form>

        <b>Menu</b>
        <table border="solid">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Restaurant</th>
                <th>Price</th>
                <th>Logo</th>
            </tr>
            <?php
            foreach($system->getRestaurants() as $id => $restaurant){
                foreach($system->getMenusFromRes($id) as $menu){
                    $description = [];
                    foreach($menu->getDescription() as $item){
                        list($name, $amount) = $item;
                        $description[] = "$name x$amount";
                    }
                    echo "<tr>";
                    echo "<td>" . $menu->getId() . "</td>";
                    echo "<td>" . $menu->getName() . "</td>";
                    echo "<td>" . implode(",", $description) . "</td>";
                    echo "<td>" . $restaurant->getName() . "</td>";
                    echo "<td>" . $menu->getPrice() . "</td>";
                    echo "<td><img src='" .$menu->getLogo() . "'></td>";
                    echo "</tr>";
                }
            }
            ?>
        </table>
        <form action = "" method = "post">
            <input type="hidden" name="menu" value="1">
            <br> Menu Name  : <input type = "text" name = "menuname"/>
            <br> Menu Food  : <input type = "text" name = "menufood"/> Format: food1:amount1,food2:amount2
            <br> Menu Drink : <input type = "text" name = "menudrink"/> Format: drink1:amount1,drink2:amount2
            <br> Menu Price : <input type="number" step="0.01" name = "menuprice"/>
            <br> Menu Logo : <input type = "text" name = "menulogo"/> Leave blank for default
            <br> Restaurant :
            <select name = "menurestaurant">
                <?php
                    foreach($system->getRestaurants() as $id => $restaurant){
                        echo "<option value='$id'>" . $restaurant->getName() . "</option>";
                    }
                ?>
            </select>
            <br> <button name="menu" type="submit">Add Menu</button>
        </form>

        <b>Add To Cart</b>
        <form action = "" method = "post">
            <input type="hidden" name="addCart" value="1">
            <br> Menus :
            <select name = "menucart">
                <?php
                    foreach($system->getRestaurants() as $id => $restaurant){
                        foreach($system->getMenusFromRes($id) as $menu){
                            $menuId = $menu->getId();
                            echo "<option value='$menuId'>" . $menu->getName() . "</option>";
                        }
                    }
                ?>
            </select>
            <br> <button name="addCart" type="submit">Add</button>
        </form>

        <b>Cart</b>
        <form action = "" method = "post">
            <input type="hidden" name="viewCart" value="1">
            <br> <button name="viewCart" type="submit">View Cart</button>
        </form>

        <form action = "" method = "post">
            <input type="hidden" name="placeOrder" value="1">
            <br> <button name="placeOrder" type="submit">Place Order</button>
        </form>

        <b>Orders</b>
        <table border="solid">
            <tr>
                <th>Customer Name</th>
                <th>Orders</th>
                <th>Time</th>
                <th>Total Price</th>
            </tr>
            <?php
                if($system->isLoggedIn()){
                    foreach($system->getOrders($system->getSession()->getUsername()) as $order){
                        $items = [];
                        foreach($order->getMenus() as $id => $menu){
                            $items[] = $menu->getName() . ":" . $menu->getAmount();
                        }
                        $menus = implode(",", $items);
                        echo "<tr>";
                        echo "<td>" . $order->getCustomer() . "</td>";
                        echo "<td>" . $menus . "</td>";
                        echo "<td>" . $order->getTimestamp() . "</td>";
                        echo "<td>" . $order->getTotalPrice() . "</td>";
                        echo "</tr>";
                    }
                }
            ?>
        </table>
    </body>
</html>
