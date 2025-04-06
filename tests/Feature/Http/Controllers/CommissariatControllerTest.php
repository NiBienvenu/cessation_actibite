<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Commissariat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CommissariatController
 */
final class CommissariatControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $commissariats = Commissariat::factory()->count(3)->create();

        $response = $this->get(route('commissariats.index'));

        $response->assertOk();
        $response->assertViewIs('commissariat.index');
        $response->assertViewHas('commissariats');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('commissariats.create'));

        $response->assertOk();
        $response->assertViewIs('commissariat.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CommissariatController::class,
            'store',
            \App\Http\Requests\CommissariatStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $nom = fake()->word();

        $response = $this->post(route('commissariats.store'), [
            'nom' => $nom,
        ]);

        $commissariats = Commissariat::query()
            ->where('nom', $nom)
            ->get();
        $this->assertCount(1, $commissariats);
        $commissariat = $commissariats->first();

        $response->assertRedirect(route('commissariats.index'));
        $response->assertSessionHas('commissariat.id', $commissariat->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $commissariat = Commissariat::factory()->create();

        $response = $this->get(route('commissariats.show', $commissariat));

        $response->assertOk();
        $response->assertViewIs('commissariat.show');
        $response->assertViewHas('commissariat');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $commissariat = Commissariat::factory()->create();

        $response = $this->get(route('commissariats.edit', $commissariat));

        $response->assertOk();
        $response->assertViewIs('commissariat.edit');
        $response->assertViewHas('commissariat');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CommissariatController::class,
            'update',
            \App\Http\Requests\CommissariatUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $commissariat = Commissariat::factory()->create();
        $nom = fake()->word();

        $response = $this->put(route('commissariats.update', $commissariat), [
            'nom' => $nom,
        ]);

        $commissariat->refresh();

        $response->assertRedirect(route('commissariats.index'));
        $response->assertSessionHas('commissariat.id', $commissariat->id);

        $this->assertEquals($nom, $commissariat->nom);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $commissariat = Commissariat::factory()->create();

        $response = $this->delete(route('commissariats.destroy', $commissariat));

        $response->assertRedirect(route('commissariats.index'));

        $this->assertSoftDeleted($commissariat);
    }
}
