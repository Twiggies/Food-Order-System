<?php

class Order{

    public $totalPrice;
    /** @var Menu[] */
    public $menus;
    public $customerName;
    public $timestamp;

    public function setTimestamp($time){
        $this->timestamp = $time;
    }

    public function getTimestamp(){
        return $this->timestamp;
    }

    public function setCustomer($name){
        $this->customerName = $name;
    }

    public function getCustomer(){
        return $this->customerName;
    }

    public function setTotalPrice($price){
        $this->totalPrice = $price;
    }

    public function getTotalPrice(){
        return $this->totalPrice;
    }

    public function setMenus($menus){
        $this->menus = $menus;
    }

    /**
     * @return Menu[]
     */
    public function getMenus(){
        return $this->menus;

    }
}
?>