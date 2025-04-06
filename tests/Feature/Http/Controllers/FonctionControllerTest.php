<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Fonction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\FonctionController
 */
final class FonctionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $fonctions = Fonction::factory()->count(3)->create();

        $response = $this->get(route('fonctions.index'));

        $response->assertOk();
        $response->assertViewIs('fonction.index');
        $response->assertViewHas('fonctions');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('fonctions.create'));

        $response->assertOk();
        $response->assertViewIs('fonction.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\FonctionController::class,
            'store',
            \App\Http\Requests\FonctionStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $nom = fake()->word();

        $response = $this->post(route('fonctions.store'), [
            'nom' => $nom,
        ]);

        $fonctions = Fonction::query()
            ->where('nom', $nom)
            ->get();
        $this->assertCount(1, $fonctions);
        $fonction = $fonctions->first();

        $response->assertRedirect(route('fonctions.index'));
        $response->assertSessionHas('fonction.id', $fonction->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $fonction = Fonction::factory()->create();

        $response = $this->get(route('fonctions.show', $fonction));

        $response->assertOk();
        $response->assertViewIs('fonction.show');
        $response->assertViewHas('fonction');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $fonction = Fonction::factory()->create();

        $response = $this->get(route('fonctions.edit', $fonction));

        $response->assertOk();
        $response->assertViewIs('fonction.edit');
        $response->assertViewHas('fonction');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\FonctionController::class,
            'update',
            \App\Http\Requests\FonctionUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $fonction = Fonction::factory()->create();
        $nom = fake()->word();

        $response = $this->put(route('fonctions.update', $fonction), [
            'nom' => $nom,
        ]);

        $fonction->refresh();

        $response->assertRedirect(route('fonctions.index'));
        $response->assertSessionHas('fonction.id', $fonction->id);

        $this->assertEquals($nom, $fonction->nom);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $fonction = Fonction::factory()->create();

        $response = $this->delete(route('fonctions.destroy', $fonction));

        $response->assertRedirect(route('fonctions.index'));

        $this->assertSoftDeleted($fonction);
    }
}
