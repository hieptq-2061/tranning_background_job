<?php

namespace App\Console\Commands;

use App\Jobs\SendMail;
use App\Mail\WelcomeMail;
use App\Models\EmailJob;
use App\Models\MonthlyEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
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
        DB::transaction(function () {
            $user_emails = User::take(1000)->pluck('email')->toArray();
            $monthlyEmail = MonthlyEmail::create([
                'total_jobs' => count($user_emails),
            ]);
            $now = Carbon::now();
            $arr_email_jobs = array_map(
                function ($email) use ($monthlyEmail, $now) {
                    return [
                        'email' => $email,
                        'monthly_email_id' => $monthlyEmail->id,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                },
                $user_emails
            );
            EmailJob::insert($arr_email_jobs);

            $email_jobs = $monthlyEmail->email_jobs;
            foreach ($email_jobs as $email_job) {
                SendMail::dispatch($email_job->id)->onQueue('email');
            }

            $this->info("Successfully!");
        });
    }
}
