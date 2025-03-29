<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_paginated_projects_in_index_view(): void
    {
        Project::factory()->count(15)->create();

        $response = $this->get(route('projects.index'));

        $response->assertStatus(Response::HTTP_OK);

        $response->assertViewIs('projects.index');

        $projectsFromView = $response->viewData('projects');
        $this->assertNotNull($projectsFromView);
        $this->assertEquals(10, $projectsFromView->count());
    }

    /** @test */
    public function it_can_store_a_new_project_and_redirect(): void
    {
        $data = [
            'name'        => 'New Project',
            'description' => 'Project description here',
        ];

        $response = $this->post(route('projects.store'), $data);

        $response->assertRedirect(route('projects.index'));

        $this->assertDatabaseHas('projects', [
            'name'        => 'New Project',
            'description' => 'Project description here',
        ]);
    }

    /** @test */
    public function it_displays_the_edit_form_for_a_specific_project(): void
    {
        $project = Project::factory()->create();

        $response = $this->get(route('projects.edit', $project));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertViewIs('projects.edit');

        $response->assertViewHas('project', $project);
    }

    /** @test */
    public function it_can_update_an_existing_project(): void
    {
        $project = Project::factory()->create([
            'name' => 'Old Project Name',
        ]);

        $newData = [
            'name'        => 'Updated Project Name',
            'description' => 'Updated description',
        ];

        $response = $this->put(route('projects.update', $project), $newData);

        $response->assertRedirect(route('projects.index'));

        $this->assertDatabaseHas('projects', [
            'id'          => $project->id,
            'name'        => 'Updated Project Name',
            'description' => 'Updated description',
        ]);
    }

    /** @test */
    public function it_can_destroy_a_project(): void
    {
        $project = Project::factory()->create();

        $response = $this->delete(route('projects.destroy', $project));

        $response->assertRedirect(route('projects.index'));
        $response->assertSessionHas('success', 'Project deleted successfully!');

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
