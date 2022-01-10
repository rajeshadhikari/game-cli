<?php
namespace App;

class User
{
    static protected $instance = null;
    private $name;
    private $location;
    private $backpack;

    private function __construct($name, $backpack) {
        $this->name  = $name;
        $this->backpack = $backpack;
    }

    static public function getInstance($name, $backpack)
    {
        if(static::$instance == null){
            static::$instance = new User($name, $backpack);
        }
        return static::$instance;
    }


    function getName(){
        return $this->name;
    }

    function getLocation(){
        return $this->location;
    }

    function getBackpack(){
        return $this->backpack;
    }

    function setLocation($location){
        $this->location = $location;
    }    

}
