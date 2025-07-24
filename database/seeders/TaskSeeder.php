<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            [
                'title' => 'Complete Laravel Project Setup',
                'description' => 'Set up the basic Laravel project structure with proper configuration and dependencies.',
                'status' => 'Done'
            ],
            [
                'title' => 'Design Database Schema',
                'description' => 'Create the database migration for tasks table with proper fields and relationships.',
                'status' => 'Done'
            ],
            [
                'title' => 'Implement Task CRUD Operations',
                'description' => 'Create controllers and views for creating, reading, updating, and deleting tasks.',
                'status' => 'Done'
            ],
            [
                'title' => 'Add Bootstrap Styling',
                'description' => 'Implement responsive Bootstrap design with modern UI components and color-coded status indicators.',
                'status' => 'Done'
            ],
            [
                'title' => 'Test Application Functionality',
                'description' => 'Test all CRUD operations, form validation, and user interface interactions.',
                'status' => 'In Progress'
            ],
            [
                'title' => 'Deploy to Production',
                'description' => 'Deploy the Task Manager application to a production server with proper configuration.',
                'status' => 'To Do'
            ],
            [
                'title' => 'Add Task Categories',
                'description' => 'Implement task categorization feature to organize tasks by different categories.',
                'status' => 'To Do'
            ],
            [
                'title' => 'Create Task Reports',
                'description' => 'Add reporting functionality to generate task completion statistics and analytics.',
                'status' => 'To Do'
            ]
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
