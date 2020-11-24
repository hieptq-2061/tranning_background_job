<?php

namespace App\Jobs;

use App\Mail\WelcomeMail;
use App\Models\EmailJob;
use App\Models\MonthlyEmail;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emailJobID;

    /**
     * Create a new job instance.
     *
     * @param $emailJobID
     * @param $monthlyEmailID
     */
    public function __construct($emailJobID)
    {
        $this->emailJobID = $emailJobID;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::transaction(function () {
            $now = Carbon::now();
            $emailJob = EmailJob::find($this->emailJobID);
            $emailJob->ended_at = $now;
            $emailJob->save();
            $sql = 'UPDATE monthly_emails SET jobs_done = jobs_done + 1 WHERE id=' . $emailJob->monthly_email_id;
            DB::statement($sql);
            $monthlyEmail = $emailJob->monthly_email;
            if ($monthlyEmail->jobs_done === $monthlyEmail->total_jobs) {
                $monthlyEmail->ended_at = $now;
                $monthlyEmail->save();
            }


            Mail::to($emailJob->email)->send(new WelcomeMail($emailJob->email));
        });
    }
}
