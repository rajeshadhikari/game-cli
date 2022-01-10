<?php
namespace App\Commands;

use App\Application;

class PickUpCommand
{
    protected $command = 'pick up';
    public $help = 'will pickup the item and execute the items command.';
    public $signature = 'pick up "item name"';
    public $regexRule = '^(pick up) ([\"\'])(.*?)\2$';

    public function handle($input)
    {
        $itemName = Application::trimInput(substr($input, strlen($this->command)+1));

        $backpack = Application::$app->getUser()->getBackpack();
        $room = Application::$app->getUser()->getLocation();
        $backpack = Application::$app->getUser()->getBackpack();
        if(empty($room)){
            //wrong action
            echo "Error! Please go to the room","\n";
            return;
        }                
        $item = $room->getItemByName($itemName);
        if(!$item){
            //wrong action
            echo "Error! no such item exist at location : ", $room->getName(),"\n";
            return;
        }
        $backpackWeight = $backpack->getWeight();
        if(($backpackWeight + $item->getWeight()) > $backpack->getWeightLimit()){
            echo "Please! drop some items from backpack to pick up this one.","\n";
            return;                    
        }
        $item = clone $item;
        echo 'Picking...', "\n";
        if($backpack->addItem($item)) {
            $room->removeItem($item);
        }
        echo "Backpack Weight(kg) : ", $backpack->getWeight(), "kg\n";

    }    
}
