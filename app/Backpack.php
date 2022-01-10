<?php
namespace App;

class Backpack
{
    private $weightLimit=0;
    private $items=[];
    public function __construct($weightLimit) {
        $this->weightLimit = $weightLimit;
    }    


    function addItem(Item $item){
        $key = ucwords($item->getName());
        if(isset($this->items[$key])){
            $this->items[$key]->incrementQty();
        } else {
            $this->items[$key] = $item;
        }
        return true;
    }
    
    function removeItem(Item $item){
        $key = ucwords($item->getName());
        if(isset($this->items[$key])){
            if($this->items[$key]->getQuantity() > 1){
                $this->items[$key]->decrementQty();
            }else{
                unset($this->items[$key]);
            }
        } else {
            return false;
        }
        return true;
    }

    public function getWeightLimit(){
        return $this->weightLimit;
    }

    public function getWeight(){
        $weight = 0;
        foreach($this->items as $item){
            $weight += ($item->getWeight()*$item->getQuantity());
        }
        return $weight;
    }

    public function getItems(){
        return $this->items;
    }    

    public function getItemByName(string $itemName){
        $itemName = ucwords($itemName);
        return isset($this->items[$itemName]) ? $this->items[$itemName] : false;
    }      
}