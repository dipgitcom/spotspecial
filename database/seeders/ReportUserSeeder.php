<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReportUser;

class ReportUserSeeder extends Seeder
{
    public function run()
    {
        // Assuming you have at least two users in your users table
        ReportUser::insert([
            [
                'report_by' => 1,
                'reported_user_id' => 2,
                'report_reason' => 'Abusive language in comments.',
                'report_status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'report_by' => 2,
                'reported_user_id' => 1,
                'report_reason' => 'Spam profile.',
                'report_status' => 'reviewed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'report_by' => 3,
                'reported_user_id' => 1,
                'report_reason' => 'Sharing inappropriate content.',
                'report_status' => 'resolved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
