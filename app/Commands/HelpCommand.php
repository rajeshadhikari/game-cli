<?php
namespace App\Commands;

use App\Application;

class HelpCommand
{
    protected $command = 'help';
    public $help = 'prints the list of commands.';
    public $signature = 'help';
    public $regexRule = '^(help)$';

    
    public function handle()
    {
        $padLength = 25;
        print "Please enter valid command.\n";
        foreach(Application::$app->getCommands() as $key => $command){
            echo str_pad( $command->signature, $padLength ), $command->help,"\n";        
        }

    }    
}
