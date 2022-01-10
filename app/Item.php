<?php
namespace App;

class Item
{
    private $name;
    private $weight;
    private $quantity;

    public function __construct($name, $weight) {
        $this->name = $name;
        $this->weight = $weight;
        $this->quantity = 1;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getWeight()
    {
        return $this->weight;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }  
    public function incrementQty(){
        $this->quantity++;
        return true;
    }
    public function decrementQty(){
        if($this->quantity > 0){
            $this->quantity--;
            return true;
        }
        return false;
    }

    public function __clone()
    {
        $this->quantity = 1;
    }

}
