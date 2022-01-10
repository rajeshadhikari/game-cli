<?php
namespace App;

class Room
{
    private $name;
    private $items=[];
    private $connectedRooms = [];


    public function __construct($name) {
        $this->name = $name;
    }

    
    public function getName()
    {
        return $this->name;
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

    function hasItem(Item $item){
        $key = ucwords($item->getName());
        if(isset($this->items[$key])){
            return true;
        } else {
            return false;
        }
    }    

    public function getItemByName(string $itemName){
        $itemName = ucwords($itemName);
        return isset($this->items[$itemName]) ? $this->items[$itemName] : false;
    }   

    public function getItems(){
        return $this->items;
    }      

    public function connectRoom(string $room){
        $room = strtolower($room);
        if($room != $this->name) {
            $this->connectedRooms[$room]=$room;
            return true;
        }
        return false;
    }

    public function getConnectedRooms(){
        return $this->connectedRooms;
    }    

}
