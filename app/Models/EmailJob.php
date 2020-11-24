<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailJob extends Model
{
    use HasFactory;

    protected $table = 'email_jobs';

    public function monthly_email()
    {
        return $this->belongsTo(MonthlyEmail::class);
    }
}
