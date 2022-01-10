<?php
namespace App\Commands;

use App\Application;

class GoToCommand
{
    protected $command = 'go to';
    public $help = 'player will move to the exit that connects the current room with the "room name" and will execute the location command';
    public $signature = 'go to "room name"';
    public $regexRule = '^(go to) ([\"\'])(.*?)\2$';

    
    public function handle($input)
    {
        $location = Application::trimInput(substr($input, strlen($this->command)+1));
        


        if($location = Application::$app->validRoomToGo($location)){
            echo 'Entering...', "\n";
            Application::$app->getUser()->setLocation($location);
            Application::triggerCommand('location');
        } else {
            echo 'Something went wrong...', "\n";
            $rooms = Application::$app->getRoomsToGo();
            if(!empty($rooms)){
                echo "Available rooms are : \n";
                $k = 1;
                foreach($rooms as $room){
                    echo "[".($k++)."] {$room}\n";
                }
            } 
        }        
    }    
}
