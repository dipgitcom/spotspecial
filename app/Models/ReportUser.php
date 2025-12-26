<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportUser extends Model
{
    protected $table = 'report_user'; // make sure your table name is exactly this

    protected $fillable = [
        'reporter_id',
        'reported_user_id',
        'reason_id', // foreign key to report_reason table
        'report_reason', // optional custom reason text
        'report_status',
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function reportedUser()
    {
        return $this->belongsTo(User::class, 'reported_user_id');
    }

    public function reason()
    {
        return $this->belongsTo(ReportReason::class, 'reason_id');
    }
}
