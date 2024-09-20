<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class Expiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'expire users every 5 minute automatically';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $users = User::where('expire',0) -> get();//collections of users
        foreach($users as $user){
            $user -> update(['expire' => 1]);
        }
    }
}