<?php

class Restaurant {

    public $name;
    public $logo;

    public function setName($name){
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }

    public function setLogo($url){
        $this->logo = $url;
    }

    public function getLogo(){
        return $this->logo;
    }
}

?>