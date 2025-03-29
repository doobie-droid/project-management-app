<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projectNamesAndDescriptions = [
            [
                'name'        => 'Company Website Redesign',
                'description' => 'Revamp the UI/UX of the corporate site and update branding.'
            ],
            [
                'name'        => 'Mobile App Launch',
                'description' => 'Develop a new cross-platform mobile application and go live.'
            ],
            [
                'name'        => 'Backend Migration',
                'description' => 'Migrate legacy backend to a modern cloud-based infrastructure.'
            ],
            [
                'name'        => 'Marketing Automation Setup',
                'description' => 'Implement tools to streamline email campaigns and lead management.'
            ],
            [
                'name'        => 'HR Onboarding Portal',
                'description' => 'Create a self-service portal for new employees and documentation.'
            ],
        ];

        foreach ($projectNamesAndDescriptions as $info) {
            Project::create([
                'name'        => $info['name'],
                'description' => $info['description'],
            ]);
        }
    }
}
