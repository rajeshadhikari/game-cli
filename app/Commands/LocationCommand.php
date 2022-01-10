<?php
namespace App\Commands;

use App\Application;

class LocationCommand
{
    protected $command = 'location';
    public $help = 'prints out the current player location and the list of exits';
    public $signature = 'location';
    public $regexRule = '^(location)$';

    
    public function handle()
    {
        $rooms = Application::$app->getRoomsToGo();

        $location = Application::$app->getUser()->getLocation();
        echo 'Your Location : ', (!empty($location)) ? $location->getName() : 'Outside Room.',"\n\n";
        sleep(1);        
        if(!empty($rooms)){
            echo "Available rooms are : \n";
            $k = 1;
            foreach($rooms as $room){
                echo "[".($k++)."] {$room}\n";
            }
        }    
            
    }    
}
