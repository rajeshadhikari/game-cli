<?php
namespace App;

class Application
{
    static public $app = null;

    static public $instances = [];

    private $commands=[];

    protected $config = [];

    protected $items = [];

    protected $rooms = [];

    static protected $user = null;

    public function __construct($config = [])
    {
        Application::$app = $this;
        static::setInstance($this);

        $this->loadConfig($config);

    }

    public static function setInstance($instance)
    {
        if ($instance === null) {
            unset(static::$instances[get_called_class()]);
        } else {
            static::$instances[get_called_class()] = $instance;
        }
    }

    public function setCommand($command)
    {
        if ($command) {
            $this->commands[get_class($command)] = $command;
        }
    }    
    
    public function getCommands(){
        return $this->commands;
    }

    public function handleCommnad($command, $input=''){
        if(!$command) {
            if(isset($this->commands['App\Commands\HelpCommand'])){
                $this->commands['App\Commands\HelpCommand']->handle();
            }
        } else {
            $command->handle($input);
        }
    }

    public function setUser($user)
    {
        if(static::$user == null){
            static::$user = $user;
        }
    }    

    public function getUser()
    {
        return static::$user;
    } 
    
    public function run()
    {
        $this->startUpWithData();

        while(1){
            $stdin = fopen('php://stdin', 'r');    
            $input = fgets($stdin);
            $input = trim(preg_replace('!\s+!', ' ', $input));
            $command = $this->validateCommand($input);
            $this->handleCommnad($command, $input);
        }
    }

    public static function triggerCommand($command)
    {
        $command = Application::$app->validateCommand($command);
        Application::$app->handleCommnad($command, $command);
    }


    function validateCommand($input) {
        $output = false;
        foreach($this->commands as $command){
            if (preg_match("/{$command->regexRule}/i", $input, $matches)) {
                return $command;
            }    
        }
        return $output;
    }    

    public function loadConfig(&$config){
        $this->config = array_merge($this->config, $config);
        if(!empty($this->config['commands'])) {
            $this->loadCommands($this->config['commands']);
        }
    }
    public function loadCommands($commands){
        foreach ($commands as $id => $command) {
            $this->setCommand((new $command));
        }
    }

    public function addRoom(Room $room){
        $this->rooms[strtolower($room->getName())] = $room;
    }

    public function getRoomByName($roomName){
        return isset($this->rooms[$roomName]) ? $this->rooms[$roomName] : false;
    }

    public function getRooms(){
        return $this->rooms;
    }

    private function startUpWithData(){
        echo "Game starting...\n";
        sleep(1);
        echo "Enter your name :";
        $stdin = fopen('php://stdin', 'r');    
        $username =ucwords(trim(fgets($stdin)," \n\r\t\'\""));
        
        echo "Welcome :{$username}\n";

        $backpack = new Backpack(50);
        $user = User::getInstance($username, $backpack);
        $this->setUser($user);

        /**
         * place some items in the rooms
         */
        $rifle = new Item('Rifle', 5);
        $bomb = new Item('Bomb', 2);
        $sword = new Item('Sword', 10);
        $bananas = new Item('Bananas', 1);

        $room1 = new Room('room1');
        $room1->addItem($rifle);
        $room1->addItem($bomb);
        $room1->addItem($sword);
        $room1->addItem($bananas);
        for($i=0;$i<=8;$i++){
            $room1->addItem(clone $rifle);
            $room1->addItem(clone $bomb);
            $room1->addItem(clone $sword);
        }
        $this->addRoom($room1);
        $room2 = new Room('room2');
        for($i=0;$i<=10;$i++){
            $room2->addItem(clone $rifle);
            $room2->addItem(clone $sword);
            $room2->addItem(clone $bananas);
        }
        $this->addRoom($room2);
        $room3 = new Room('room3');
        for($i=0;$i<=2;$i++){
            $room3->addItem(clone $bomb);
            $room3->addItem(clone $bananas);
        }        
        $this->addRoom($room3);
        //room1<=>room2<=>room3
        $this->getRoomByName($room1->getName())->connectRoom($room2->getName());
        $this->getRoomByName($room2->getName())->connectRoom($room1->getName());
        $this->getRoomByName($room2->getName())->connectRoom($room3->getName());
        $this->getRoomByName($room3->getName())->connectRoom($room2->getName());


        /* end */

    }
    
    public static function trimInput($input){
        return trim($input," \n\r\t\'\"");
    }

    public function validRoomToGo($room){
        $room = strtolower($room);
        $userLocation = Application::$app->getUser()->getLocation();
        if($userLocation instanceof Room) {
            if($room == $userLocation->getName()){
                echo "Yor are in the same the \"{$room}\"\n";
                return false;
            }        
            if(!in_array($room, $userLocation->getConnectedRooms())){
                return false;
            }
        }

        return isset($this->rooms[$room]) ? $this->rooms[$room] : false;
    } 

    public function getRoomsToGo(){
        $rooms = [];
        $userLocation = Application::$app->getUser()->getLocation();
        if($userLocation instanceof Room) {
            $rooms = $userLocation->getConnectedRooms();
        }else{
            $rooms = array_keys($this->getRooms());            
        }
        return $rooms;
    } 
    
}
