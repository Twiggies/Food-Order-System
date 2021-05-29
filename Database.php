<?php
include_once("Session.php");

class Database {

    public function __construct(){
        $this->initDatabase();
    }

    public function initDatabase(){
        $connection = mysqli_connect("localhost", "root", "", "ffdb");
        if($connection){
            $queries = [
                "CREATE TABLE IF NOT EXISTS Orders(OrderId INT NOT NULL AUTO_INCREMENT, CustomerName VARCHAR(30) , Orders VARCHAR(100), OrderTime VARCHAR(20), PRIMARY KEY (OrderId), FOREIGN KEY (CustomerName) REFERENCES Account(AccountName))",
                "CREATE TABLE IF NOT EXISTS Menu(MenuId INT NOT NULL AUTO_INCREMENT, MenuRestaurant INT, MenuName VARCHAR(30), MenuData VARCHAR(100), MenuPrice DOUBLE(10,2), MenuLogo VARCHAR(100) , PRIMARY KEY (MenuId), FOREIGN KEY (MenuRestaurant) REFERENCES Restaurant(RestaurantId))",
                "CREATE TABLE IF NOT EXISTS Restaurant(RestaurantId INT NOT NULL AUTO_INCREMENT, RestaurantName VARCHAR(30), RestaurantLogo VARCHAR (30), PRIMARY KEY (RestaurantId))",
                "CREATE TABLE IF NOT EXISTS Account(AccountId INT NOT NULL AUTO_INCREMENT, AccountName VARCHAR(30) UNIQUE, AccountPassword VARCHAR(20), DeliveryAddress VARCHAR(100), AccountType INT, PRIMARY KEY (AccountId))"
            ];
            foreach($queries as $query){
                mysqli_query($connection, $query);
            }
        }
        mysqli_close($connection);
    }

    /**
     * @param $name
     * @param $url
     */
    public function addRestaurant($name, $url){
        $connection = mysqli_connect("localhost", "root", "", "ffdb");
        $query = "INSERT INTO Restaurant (RestaurantName, RestaurantLogo) VALUES ('$name', '$url')";
        mysqli_query($connection, $query);
        mysqli_close($connection);
    }

    /**
     * @param $name
     * @param $foods food1:amount1,food2:amount2,default:0
     * @param $drinks drinks1:amount1,drinks2:amount2,default:0
     * @param $restaurantId
     * @param $price
     * @param $url
     */
    public function addMenu($name, $foods, $drinks, $restaurantId, $price, $url){
        $menuData = implode("/", [$foods, $drinks]);
        echo $menuData;

        $connection = mysqli_connect("localhost", "root", "", "ffdb");
        $query = "INSERT INTO Menu (MenuRestaurant, MenuName, MenuData, MenuPrice, MenuLogo) VALUES ($restaurantId, '$name', '$menuData', $price, '$url')";
        mysqli_query($connection, $query);
        mysqli_close($connection);
    }

    /**
     * @param string $customerName
     * @param Menu[] $menus
     */
    public function addOrder($customerName, $menus){
        $menusIds = [];
        foreach($menus as $menu){
            if(!isset($menusIds[$menu->getId()])){
                $menusIds[$menu->getId()] = $menu;
            } else {
                $menusIds[$menu->getId()]->addAmount();
            }
        }
        $menusData = [];
        /**
         * @var int $menuId
         * @var Menu $menu
         */
        foreach($menusIds as $menuId => $menu){
            $menusData[] = "$menuId:" . $menu->getAmount();
        }
        $orders = implode(",", $menusData);
        $timestamp = time();
        $connection = mysqli_connect("localhost", "root", "", "ffdb");
        $query = "INSERT INTO Orders (CustomerName, Orders, OrderTime) VALUES ('$customerName', '$orders', $timestamp)";
        mysqli_query($connection, $query);
        mysqli_close($connection);
    }

    /**
     * @param $username
     * @param $password
     */
    public function addUser($username, $password, $address){
        $connection = mysqli_connect("localhost", "root", "", "ffdb");
        $type = Session::DEFAULT;
        $query = "INSERT INTO Account (AccountName, AccountPassword, DeliveryAddress, AccountType) VALUES ('$username', '$password', '$address', $type)";
        mysqli_query($connection, $query);
        mysqli_close($connection);
    }

    /**
     * @param $username
     */
    public function removeUser($username){
        $connection = mysqli_connect("localhost", "root", "", "ffdb");
        $query = "DELETE FROM Account WHERE AccountName = '$username'";
        mysqli_query($connection, $query);
        mysqli_close($connection);
    }

    /**
     * @param $username
     */
    public function updateUserPassword($username, $newPassword){
        $connection = mysqli_connect("localhost", "root", "", "ffdb");
        $query = "UPDATE Account SET AccountPassword = '$newPassword' WHERE AccountName = '$username'";
        mysqli_query($connection, $query);
        mysqli_close($connection);
    }

    /**
     * @return array
     */
    public function getRestaurants(){
        $connection = mysqli_connect("localhost", "root", "", "ffdb");
        $result =  mysqli_query($connection, "SELECT * FROM Restaurant");
        $res = [];
        while($data = mysqli_fetch_array($result)){
            $res[] = $data;
        }
        mysqli_close($connection);
        return $res;
    }

    /**
     * @return array
     */
    public function getMenusFromRes($restaurantId){
        $connection = mysqli_connect("localhost", "root", "", "ffdb");
        $result =  mysqli_query($connection, "SELECT * FROM Menu WHERE MenuRestaurant = $restaurantId");
        $menus = [];
        while($data = mysqli_fetch_array($result)){
            $menus[] = $data;
        }
        mysqli_close($connection);
        return $menus;
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function getMenuFromId($id){
        $connection = mysqli_connect("localhost", "root", "", "ffdb");
        $query =  mysqli_query($connection, "SELECT * FROM Menu WHERE MenuId = $id");
        mysqli_close($connection);
        if($query){
            $data = mysqli_fetch_array($query);
            return $data;
        }else {
            return [];
        }
    }

    /**
     * @param $name
     *
     * @return array
     */
    public function searchMenuByName($name){
        $connection = mysqli_connect("localhost", "root", "", "ffdb");
        $query =  mysqli_query($connection, "SELECT * FROM Menu WHERE MenuName LIKE '%$name%'");
        $menuData = [];
        while($data = mysqli_fetch_array($query)){
            $menuData[] = $data;
        }
        mysqli_close($connection);
        return $menuData;
    }

    /**
     * @param $customerName
     *
     * @return array
     */
    public function getOrders($customerName){
        $connection = mysqli_connect("localhost", "root", "", "ffdb");
        $result =  mysqli_query($connection, "SELECT * FROM Orders WHERE CustomerName = '$customerName'");
        $orders = [];
        while($data = mysqli_fetch_array($result)){
            $orders[] = $data;
        }
        mysqli_close($connection);
        return $orders;
    }

    /**
     * @param $username
     *
     * @return array
     */
    public function getUserData($username){
        $connection = mysqli_connect("localhost", "root", "", "ffdb");
        $result =  mysqli_query($connection, "SELECT * FROM Account WHERE AccountName = '$username'");
        if($result){
            $data = $result->fetch_assoc();
        } else {
            $data = [];
        }
        mysqli_close($connection);
        return $data;
    }

    /**
     * @param 
     *
     * @return address
     */
    public function getUserAddress($username){
        $connection = mysqli_connect("localhost", "root", "", "ffdb");
        $result =  mysqli_query($connection, "SELECT DeliveryAddress FROM Account WHERE AccountName = '$username'");
        if($result){
            $data = mysqli_fetch_array($result);
            $address = $data["DeliveryAddress"];
        } else {
            $address = null;
        }
        mysqli_close($connection);
        return $address;
    }
}
?>