<?php
include_once("Database.php");
include_once("Menu.php");
include_once("Restaurant.php");
include_once("Session.php");
include_once("Order.php");

class OrderingSystem {

    public $database = null;

    public function __construct(){
        $this->database = new Database();
    }

    public function getDatabase(){
        return $this->database;
    }

    public function register($username = "", $password = "", $address = ""): bool{
        // Empty fields
        if(empty($username) || empty($password) || empty($address)){
            return false;
        }
        // No duplicate username
        if(empty($this->getDatabase()->getUserData($username))){
            $this->getDatabase()->addUser($username, $password, $address);
            return true; // Account successfully created
        } else {
            return false; // Duplicate username
        }
    }

    public function login($username, $password): bool{
        // handle authentication and loading orders
        if(!empty($data = $this->getDatabase()->getUserData($username))){
            if($username === $data["AccountName"] && $password === $data["AccountPassword"]){
                $address = $this->getDatabase()->getUserAddress($username);
                $type = $data["AccountType"];
                $this->setSession(new Session($username, $password, $address, $type));
                return true; // successful login
            }
            return false; // wrong password
        } else {
            return false; // $username doesnt exist
        }
    }

    public function logout(){
        if($this->isLoggedIn()){
            unset($_SESSION["user"]);
            return true;
        }
        return false;
    }

    public function updatePassword($oldPassword, $newPassword){
        if(empty($oldPassword) || empty($newPassword)){
            return false;
        }
        if(!$this->isLoggedIn()){
            return false;
        }
        $session = $this->getSession();
        if($oldPassword == $session->getPassword()){ // very secured comparison
            $this->getDatabase()->updateUserPassword($session->getUsername(), $newPassword);
            $session->setPassword($newPassword);
            $this->setSession($session);
            return true;
        }
        return false;
    }

    public function deleteAccount($username){
        if($this->isLoggedIn()){
            if(!empty($data = $this->getDatabase()->getUserData($username))){
                $this->getDatabase()->removeUser($username);
                unset($_SESSION["user"]);
                return true; // removed account
            } else {
                return false; // error
            }
        }
        return false;
    }

    public function isLoggedIn(){
        return isset($_SESSION["user"]);
    }

    /**
     * @param $session
     */
    public function setSession($session){
        $_SESSION["user"] = serialize($session);
    }

    /**
     * @return Session|null
     */
    public function getSession(){
        if($this->isLoggedIn()){
            return unserialize($_SESSION["user"]);
        }
        return null;
    }

    /**
     * @param $name
     */
    public function addRestaurant($name, $url){
        if(!empty($name)){
            if(empty($url)){
                $url = "assets/defaultrestaurant.png";
            }
            $this->getDatabase()->addRestaurant($name, $url);
        }
    }

    /**
     * @return Restaurant[]
     */
    public function getRestaurants(){
        $restaurants = [];
        $resData = $this->getDatabase()->getRestaurants();
        foreach($resData as $data){
            $newRes = new Restaurant();
            $newRes->setName($data["RestaurantName"]);
            $newRes->setLogo($data["RestaurantLogo"]);
            $restaurants[$data["RestaurantId"]] = $newRes;
        }
        return $restaurants;
    }

    public function getRestaurantByID($id)
    {
        $restaurants = $this->getRestaurants();
        return $restaurants[$id];
    }

    /**
     * @param $name
     * @param $foods food1:amount1,food2:amount2,default:0
     * @param $drinks drinks1:amount1,drinks2:amount2,default:0
     * @param int $restaurantId
     * @param $price
     * @param $url
     *
     * @return bool
     */
    public function addMenu($name, $foods, $drinks, $restaurantId = -1, $price, $url): bool{
        if(empty($foods) || empty($drinks) || $restaurantId == -1 || empty($price)){
            return false;
        }
        $price = round($price, 2);
        if(empty($url)){
            $url = "assets/defaultmenu.png";
        }
        $this->getDatabase()->addMenu($name, $foods, $drinks, $restaurantId, $price, $url);
        return true;
    }

    /**
     * @param $restaurantId
     *
     * @return Menu[]
     */
    public function getMenusFromRes($restaurantId){
        $menus = [];
        $menuData = $this->getDatabase()->getMenusFromRes($restaurantId);
        foreach($menuData as $data){
            $menus[] = $this->parseMenu($data);
        }
        return $menus;
    }

    /**
     * Get a Menu object from id
     * return null if menu doesnt exist
     *
     * @param $id
     *
     * @return Menu|null
     */
    public function getMenuFromId($id){
        $menuData = $this->getDatabase()->getMenuFromId($id);
        if(!empty($menuData)){
            $menu = $this->parseMenu($menuData);
            return $menu;
        } else {
            return null;
        }
    }

    /**
     * @param $name
     *
     * @return array
     */
    public function searchMenu($name){
        $menus = [];
        $searchResult = $this->getDatabase()->searchMenuByName($name);
        foreach($searchResult as $data){
            $menu = $this->parseMenu($data);
            $menus[] = $menu;
        }
        return $menus;
    }

    public function placeOrder(){
        if($this->isLoggedIn()){
            $session = $this->getSession();
            if(!empty($session->getCart())){
                $this->getDatabase()->addOrder($session->getUsername(), $session->getCart());
                $session->resetCart();
                $this->setSession($session);
                return true;
            }
        }
        return false;
    }

    public function addToCart(Menu $menu){
        if($this->isLoggedIn()){
            $session = $this->getSession();
            $session->addToCart($menu);
            $this->setSession($session);
            return true;
        }
        return false;
    }

    /**
     * @param $customerName
     *
     * @return Order[]
     */
    public function getOrders($customerName){
        $orderDatas = $this->getDatabase()->getOrders($customerName);
        $orders = [];
        foreach($orderDatas as $orderData){
            $orders[] = $this->parseOrder($orderData);
        }
        return $orders;
    }

    public function parseOrder($data) : Order {
        $order = new Order();
        $order->setCustomer($data["CustomerName"]);
        $items = explode(",", $data["Orders"]);
        $menus = [];
        $totalPrice = 0;
        foreach($items as $item){
            list($id, $amount) = explode(":", $item);
            $menu = $this->getMenuFromId($id);
            $menu->setAmount($amount);
            $menus[$id] = $menu;
            $totalPrice += $menu->getPrice();
        }
        $order->setMenus($menus);
        $order->setTotalPrice($totalPrice);
        $order->setTimestamp($data["OrderTime"]);
        return $order;
    }

    /**
     * Parse menu data into Menu object
     *
     * @param $data
     *
     * @return Menu
     */
    public function parseMenu($data) : Menu {
        $menu = new Menu($data["MenuId"]);
        $menu->setName($data["MenuName"]);
        $menu->setRestaurant($data["MenuRestaurant"]);
        $menu->setPrice($data["MenuPrice"]);
        $menu->setLogo($data["MenuLogo"]);
        list($foods, $drinks) = explode("/", $data["MenuData"]);
        $parsedFoods = $this->parseItem($foods);
        foreach($parsedFoods as $food){
            $menu->addFood($food[0], $food[1]);
        }
        $parseDrinks = $this->parseItem($drinks);
        foreach($parseDrinks as $drink){
            $menu->addDrink($drink[0], $drink[1]);
        }
        return $menu;
    }

    /**
     * Parse item data into array of [name, amount]
     *
     * @param $foodData
     */
    public function parseItem($itemData){
        $result = [];
        $items = explode(",", $itemData);
        foreach($items as $item){
            $exp = explode(":", $item);
            // Make sure data format is correct before parsing
            if(count($exp) > 1){
                $result[] = $exp;
            }
        }
        return $result;
    }
}

?>