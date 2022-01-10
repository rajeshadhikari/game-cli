<?php
namespace App\Commands;

use App\Application;

class ItemsCommand
{
    protected $command = 'items';
    public $help = 'prints out the list of items in the backpack.';
    public $signature = 'items';
    public $regexRule = '^(items)$';

    public function handle($input)
    {
        $user = Application::$app->getUser();
        $backpack = $user->getBackpack();
        if($items = $backpack->getItems()){
            echo "Items in {$user->getName()}'s backpack : ","\n";
            echo str_pad('Item', 25), str_pad('Qty', 20), str_pad('weight', 20), "\n";
            foreach($items as $item){
                echo str_pad( $item->getName(), 25), str_pad($item->getQuantity(),20), str_pad($item->getWeight(),20),"\n";
            }
        } else {
            echo "{$user->getName()}'s backpack is empty.","\n";
        }
        echo "backpack (weight of items) : ",$backpack->getWeight(),"kg \n";
        echo "backpack (max weight limit) : ",$backpack->getWeightLimit(),"kg \n\n";

        $location = Application::$app->getUser()->getLocation();
        if($location && !empty($location->getItems())) {
            echo "Items in the room : ", $location->getName(),"\n";            
            echo str_pad('Item', 25), str_pad('Qty', 20), str_pad('weight', 20), "\n";
            foreach($location->getItems() as $item){
                echo str_pad( $item->getName(), 25), str_pad($item->getQuantity(),20), str_pad($item->getWeight(),20),"\n";
            }     
        } else{
            echo "No Items at this location","\n";            
        }   

    }    
}
