<?php

namespace App\Console\Commands;

use App\Jobs\SendMail;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendWelcomeMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:welcome_mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $user_emails = User::take(1000)->pluck('email')->toArray();
            foreach ($user_emails as $email) {
                SendMail::dispatch($email)->onQueue('email');
            }
            $this->info("Successfully!");
        } catch (\Exception $ex) {
            $this->info($ex);
        }
    }
}
