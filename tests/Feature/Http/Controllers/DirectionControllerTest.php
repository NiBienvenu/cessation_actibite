<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Direction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DirectionController
 */
final class DirectionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $directions = Direction::factory()->count(3)->create();

        $response = $this->get(route('directions.index'));

        $response->assertOk();
        $response->assertViewIs('direction.index');
        $response->assertViewHas('directions');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('directions.create'));

        $response->assertOk();
        $response->assertViewIs('direction.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DirectionController::class,
            'store',
            \App\Http\Requests\DirectionStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $nom = fake()->word();

        $response = $this->post(route('directions.store'), [
            'nom' => $nom,
        ]);

        $directions = Direction::query()
            ->where('nom', $nom)
            ->get();
        $this->assertCount(1, $directions);
        $direction = $directions->first();

        $response->assertRedirect(route('directions.index'));
        $response->assertSessionHas('direction.id', $direction->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $direction = Direction::factory()->create();

        $response = $this->get(route('directions.show', $direction));

        $response->assertOk();
        $response->assertViewIs('direction.show');
        $response->assertViewHas('direction');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $direction = Direction::factory()->create();

        $response = $this->get(route('directions.edit', $direction));

        $response->assertOk();
        $response->assertViewIs('direction.edit');
        $response->assertViewHas('direction');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DirectionController::class,
            'update',
            \App\Http\Requests\DirectionUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $direction = Direction::factory()->create();
        $nom = fake()->word();

        $response = $this->put(route('directions.update', $direction), [
            'nom' => $nom,
        ]);

        $direction->refresh();

        $response->assertRedirect(route('directions.index'));
        $response->assertSessionHas('direction.id', $direction->id);

        $this->assertEquals($nom, $direction->nom);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $direction = Direction::factory()->create();

        $response = $this->delete(route('directions.destroy', $direction));

        $response->assertRedirect(route('directions.index'));

        $this->assertSoftDeleted($direction);
    }
}
