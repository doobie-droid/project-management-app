<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = Project::all();

        $taskNames = [
            'Design wireframes',
            'Implement core features',
            'Set up CI/CD pipeline',
            'Write API documentation',
            'Conduct QA testing',
            'Fix reported bugs',
            'Schedule project review',
            'Optimize database queries',
        ];

        foreach ($projects as $project) {
            for ($i = 0; $i < 5; $i++) {
                Task::create([
                    'project_id' => $project->id,
                    'name'       => sprintf("%s for %s", $taskNames[array_rand($taskNames)], $project->name),
                ]);
            }
        }
    }
}
