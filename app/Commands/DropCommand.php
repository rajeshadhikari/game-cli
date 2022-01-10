<?php
namespace App\Commands;

use App\Application;

class DropCommand
{
    protected $command = 'drop';
    public $help = 'will drop the item and execute the items command';
    public $signature = 'drop "item name"';
    public $regexRule = '^(drop) ([\"\'])(.*?)\2$';

    public function handle($input)
    {
        $itemName = Application::trimInput(substr($input, strlen($this->command)+1));
        $backpack = Application::$app->getUser()->getBackpack();
        $room = Application::$app->getUser()->getLocation();
        $backpack = Application::$app->getUser()->getBackpack();
        if(empty($room)){
            //wrong action
            echo "Error! Please go to the room.","\n";
            return;
        }                
        $item = $backpack->getItemByName($itemName);
        if(!$item){
            //wrong action
            echo "Error! no such item exist in backpack", "\n";
            return;
        }
        $item = clone $item;
        echo 'Dropping...', "\n";
        if($backpack->removeItem($item)) {
            $room->addItem($item);
        }
        echo "Backpack Weight(kg) : ", $backpack->getWeight(), "kg\n";

    }    
}
