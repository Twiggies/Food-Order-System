<?php

class Menu {

    public $name;
    public $id;
    public $restaurant;
    public $foods = [];
    public $drinks = [];
    public $price;
    public $logo;
    public $amount = 1;

    public function __construct($id){
        $this->id = $id;
    }

    public function setRestaurant($id){
        $this->restaurant = $id;
    }

    public function getRestaurantId(){
        return $this->restaurant;
    }

    public function addAmount(){
        $this->amount += 1;
    }

    public function setAmount($amount){
        $this->amount = $amount;
    }

    public function getAmount(){
        return $this->amount;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function getId(){
        return $this->id;
    }

    public function setPrice($price){
        $this->price = $price;
    }

    public function getPrice(){
        return $this->price;
    }

    public function setLogo($url){
        $this->logo = $url;
    }

    public function getLogo(){
        return $this->logo;
    }

    /**
     * @param $name
     * @param $count
     */
    public function addFood($name, $count){
        $this->foods[] = [$name, $count];
    }

    /**
     * Return foods in [name, amount] format
     * for parsing purpose
     *
     * @return array
     */
    public function getFoods(){
        return $this->foods;
    }

    /**
     * @param $name
     * @param $count
     */
    public function addDrink($name, $count){
        $this->drinks[] = [$name, $count];
    }

    /**
     * Return drinks in [name, amount] format
     * for parsing purpose
     *
     * @return array
     */
    public function getDrinks(){
        return $this->drinks;
    }

    public function getDescription() : array {
        return array_merge($this->foods, $this->drinks);
    }
}

?>