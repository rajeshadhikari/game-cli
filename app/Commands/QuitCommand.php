<?php
namespace App\Commands;

use App\Application;

class QuitCommand
{
    protected $command = 'quit';
    public $help = 'exits the game.';
    public $signature = 'quit';
    public $regexRule = '^(quit)$';

    
    public function handle()
    {
        die("\nBye Bye!!!\n\n");
    }    
}
