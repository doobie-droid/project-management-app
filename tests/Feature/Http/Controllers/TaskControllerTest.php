<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_the_index_with_paginated_tasks(): void
    {
        $project = Project::factory()->create();
        Task::factory()->count(15)->create(['project_id' => $project->id]);

        $response = $this->get(route('tasks.index'));


        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('tasks.index');
        $response->assertViewHas('tasks');
        $response->assertViewHas('projects');
        $this->assertEquals(10, $response->viewData('tasks')->count());
    }

    /** @test */
    public function it_can_filter_tasks_by_project_id(): void
    {
        $projectA = Project::factory()->create();
        $projectB = Project::factory()->create();


        Task::factory()->count(5)->create(['project_id' => $projectA->id]);
        Task::factory()->count(3)->create(['project_id' => $projectB->id]);


        $response = $this->get(route('tasks.index', ['project_id' => $projectA->id]));
        $response->assertStatus(Response::HTTP_OK);

        $tasks = $response->viewData('tasks');
        $this->assertTrue($tasks->every(fn($task) => $task->project_id === $projectA->id));
    }

    /** @test */
    public function it_can_store_a_new_task(): void
    {
        $project = Project::factory()->create();

        $data = [
            'name' => 'Test Task',
            'project_id' => $project->id,
        ];

        $response = $this->post(route('tasks.store'), $data);

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('success', 'Task created successfully!');

        $this->assertDatabaseHas('tasks', [
            'name' => 'Test Task',
            'project_id' => $project->id,
        ]);
    }

    /** @test */
    public function it_can_show_the_edit_form(): void
    {
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.edit', $task->id));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('tasks.edit');
        $response->assertViewHas('task', $task);
    }

    /** @test */
    public function it_can_update_a_task(): void
    {
        $task = Task::factory()->create([
            'name' => 'Old Name',
        ]);

        $data = [
            'name' => 'New Name',
        ];

        $response = $this->put(route('tasks.update', $task->id), $data);

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('success', 'Task updated successfully!');

        $this->assertDatabaseHas('tasks', [
            'id'   => $task->id,
            'name' => 'New Name',
        ]);
    }

    /** @test */
    public function it_can_destroy_a_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', ['id' => $task]);
    }

    /** @test */
    public function it_can_reorder_tasks(): void
    {
        $task1 = Task::factory()->create(['priority' => 1]);
        $task2 = Task::factory()->create(['priority' => 2]);
        $task3 = Task::factory()->create(['priority' => 3]);

        $payload = [
            'order' => [
                ['id' => $task3->id, 'priority' => 10],
                ['id' => $task1->id, 'priority' => 11],
                ['id' => $task2->id, 'priority' => 12],
            ]
        ];

        $response = $this->postJson(route('tasks.reorder'), $payload);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('tasks', [
            'id'       => $task3->id,
            'priority' => 10,
        ]);
        $this->assertDatabaseHas('tasks', [
            'id'       => $task1->id,
            'priority' => 11,
        ]);
        $this->assertDatabaseHas('tasks', [
            'id'       => $task2->id,
            'priority' => 12,
        ]);
    }
}
