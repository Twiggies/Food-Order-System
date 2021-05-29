<?php

class Session{

    const DEFAULT = 0;
    const ADMIN = 1;

    public $type;
    public $username;
    public $password;
    public $address;
    /** @var Menu[] */
    public $cart = [];

    public function __construct($username, $password, $address, $type){
        $this->username = $username;
        $this->password = $password;
        $this->address = $address;
        $this->type = $type;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getAddress(){
        return $this->address;
    }

    

    public function getType(){
        return $this->type;
    }

    public function setPassword($newPassword){
        $this->password = $newPassword;
    }

    public function setAddress($newAddress) {
        $this->address = $newAddress;
        return true;
    }

    public function addToCart(Menu $menu){
        if (!isset($this->cart[$menu->getID()])) {
        $this->cart[$menu->getID()] = $menu;
        }
        else {
            $this->cart[$menu->getID()]->addAmount();
        }
    }

    public function getCart(){
        return $this->cart;
    }

    public function resetCart(){
        $this->cart = [];
    }

    public function isAdmin(){
        return $this->type == self::ADMIN;
    }
}

?>