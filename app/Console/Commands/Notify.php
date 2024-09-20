<?php

namespace App\Console\Commands;

use App\Mail\NotifyEmail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class Notify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send email notify for all user every day';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //   $user = User::select('email')->get();
        $emails = User::pluck('email')->toArray();
        $data = ['title' => 'programming', 'body' => 'php'];

        foreach ($emails as $email) {
            //how to send emails in laravel
            Mail::To($email)->send(new NotifyEmail($data));

        }

    }
}