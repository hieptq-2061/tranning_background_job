<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyEmail extends Model
{
    use HasFactory;

    protected $table = 'monthly_emails';

    protected $fillable = [
        'id',
        'total_jobs',
        'jobs_done',
        'ended_at',
        'created_at',
        'updated_at',
    ];

    public function getTotalRunningTimeAttribute()
    {
        $diffTime = Carbon::parse($this->ended_at ? $this->ended_at : Carbon::now())
            ->diff(Carbon::parse($this->created_at));
        $totalRunTime = $diffTime->d ? $diffTime->d . 'Ngày ' : '';
        $totalRunTime .= "$diffTime->h Giờ $diffTime->i Phút $diffTime->s Giây";
        return $totalRunTime;
    }

    # ------------Relationship function-----------------
    public function email_jobs()
    {
        return $this->hasMany(EmailJob::class);
    }
}
