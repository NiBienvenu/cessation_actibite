<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Application;
use App\Models\User;
use App\Models\UserApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UserApplicationController
 */
final class UserApplicationControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $userApplications = UserApplication::factory()->count(3)->create();

        $response = $this->get(route('user-applications.index'));

        $response->assertOk();
        $response->assertViewIs('userApplication.index');
        $response->assertViewHas('userApplications');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('user-applications.create'));

        $response->assertOk();
        $response->assertViewIs('userApplication.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UserApplicationController::class,
            'store',
            \App\Http\Requests\UserApplicationStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $user = User::factory()->create();
        $application = Application::factory()->create();

        $response = $this->post(route('user-applications.store'), [
            'user_id' => $user->id,
            'application_id' => $application->id,
        ]);

        $userApplications = UserApplication::query()
            ->where('user_id', $user->id)
            ->where('application_id', $application->id)
            ->get();
        $this->assertCount(1, $userApplications);
        $userApplication = $userApplications->first();

        $response->assertRedirect(route('userApplications.index'));
        $response->assertSessionHas('userApplication.id', $userApplication->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $userApplication = UserApplication::factory()->create();

        $response = $this->get(route('user-applications.show', $userApplication));

        $response->assertOk();
        $response->assertViewIs('userApplication.show');
        $response->assertViewHas('userApplication');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $userApplication = UserApplication::factory()->create();

        $response = $this->get(route('user-applications.edit', $userApplication));

        $response->assertOk();
        $response->assertViewIs('userApplication.edit');
        $response->assertViewHas('userApplication');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UserApplicationController::class,
            'update',
            \App\Http\Requests\UserApplicationUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $userApplication = UserApplication::factory()->create();
        $user = User::factory()->create();
        $application = Application::factory()->create();

        $response = $this->put(route('user-applications.update', $userApplication), [
            'user_id' => $user->id,
            'application_id' => $application->id,
        ]);

        $userApplication->refresh();

        $response->assertRedirect(route('userApplications.index'));
        $response->assertSessionHas('userApplication.id', $userApplication->id);

        $this->assertEquals($user->id, $userApplication->user_id);
        $this->assertEquals($application->id, $userApplication->application_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $userApplication = UserApplication::factory()->create();

        $response = $this->delete(route('user-applications.destroy', $userApplication));

        $response->assertRedirect(route('userApplications.index'));

        $this->assertModelMissing($userApplication);
    }
}
