<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Motif;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MotifController
 */
final class MotifControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $motifs = Motif::factory()->count(3)->create();

        $response = $this->get(route('motifs.index'));

        $response->assertOk();
        $response->assertViewIs('motif.index');
        $response->assertViewHas('motifs');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('motifs.create'));

        $response->assertOk();
        $response->assertViewIs('motif.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MotifController::class,
            'store',
            \App\Http\Requests\MotifStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $titre = fake()->word();
        $contenu = fake()->text();
        $status = fake()->word();

        $response = $this->post(route('motifs.store'), [
            'titre' => $titre,
            'contenu' => $contenu,
            'status' => $status,
        ]);

        $motifs = Motif::query()
            ->where('titre', $titre)
            ->where('contenu', $contenu)
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $motifs);
        $motif = $motifs->first();

        $response->assertRedirect(route('motifs.index'));
        $response->assertSessionHas('motif.id', $motif->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $motif = Motif::factory()->create();

        $response = $this->get(route('motifs.show', $motif));

        $response->assertOk();
        $response->assertViewIs('motif.show');
        $response->assertViewHas('motif');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $motif = Motif::factory()->create();

        $response = $this->get(route('motifs.edit', $motif));

        $response->assertOk();
        $response->assertViewIs('motif.edit');
        $response->assertViewHas('motif');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MotifController::class,
            'update',
            \App\Http\Requests\MotifUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $motif = Motif::factory()->create();
        $titre = fake()->word();
        $contenu = fake()->text();
        $status = fake()->word();

        $response = $this->put(route('motifs.update', $motif), [
            'titre' => $titre,
            'contenu' => $contenu,
            'status' => $status,
        ]);

        $motif->refresh();

        $response->assertRedirect(route('motifs.index'));
        $response->assertSessionHas('motif.id', $motif->id);

        $this->assertEquals($titre, $motif->titre);
        $this->assertEquals($contenu, $motif->contenu);
        $this->assertEquals($status, $motif->status);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $motif = Motif::factory()->create();

        $response = $this->delete(route('motifs.destroy', $motif));

        $response->assertRedirect(route('motifs.index'));

        $this->assertModelMissing($motif);
    }
}
