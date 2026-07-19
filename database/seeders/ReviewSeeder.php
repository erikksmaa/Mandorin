<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $project = Project::where('title', 'Renovasi Rumah Minimalis')->first();

        if (!$project) {
            return;
        }
        
        Review::updateOrCreate(

            [
                'project_id' => $project->id,
            ],

            [
                'customer_id' => $project->customer_id,
                'rating' => 5,
                'review' => 'Hasil pekerjaan sangat rapi, komunikasi baik, dan proyek selesai tepat waktu.',
            ]

        );
    }
}