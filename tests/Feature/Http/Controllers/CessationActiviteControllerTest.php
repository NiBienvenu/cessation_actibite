<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CessationActivite;
use App\Models\Employe;
use App\Models\Motif;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CessationActiviteController
 */
final class CessationActiviteControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $cessationActivites = CessationActivite::factory()->count(3)->create();

        $response = $this->get(route('cessation-activites.index'));

        $response->assertOk();
        $response->assertViewIs('cessationActivite.index');
        $response->assertViewHas('cessationActivites');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('cessation-activites.create'));

        $response->assertOk();
        $response->assertViewIs('cessationActivite.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CessationActiviteController::class,
            'store',
            \App\Http\Requests\CessationActiviteStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $employe = Employe::factory()->create();
        $date_entree = Carbon::parse(fake()->date());
        $date_sortie = Carbon::parse(fake()->date());
        $motif = Motif::factory()->create();
        $description = fake()->text();

        $response = $this->post(route('cessation-activites.store'), [
            'employe_id' => $employe->id,
            'date_entree' => $date_entree->toDateString(),
            'date_sortie' => $date_sortie->toDateString(),
            'motif_id' => $motif->id,
            'description' => $description,
        ]);

        $cessationActivites = CessationActivite::query()
            ->where('employe_id', $employe->id)
            ->where('date_entree', $date_entree)
            ->where('date_sortie', $date_sortie)
            ->where('motif_id', $motif->id)
            ->where('description', $description)
            ->get();
        $this->assertCount(1, $cessationActivites);
        $cessationActivite = $cessationActivites->first();

        $response->assertRedirect(route('cessationActivites.index'));
        $response->assertSessionHas('cessationActivite.id', $cessationActivite->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $cessationActivite = CessationActivite::factory()->create();

        $response = $this->get(route('cessation-activites.show', $cessationActivite));

        $response->assertOk();
        $response->assertViewIs('cessationActivite.show');
        $response->assertViewHas('cessationActivite');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $cessationActivite = CessationActivite::factory()->create();

        $response = $this->get(route('cessation-activites.edit', $cessationActivite));

        $response->assertOk();
        $response->assertViewIs('cessationActivite.edit');
        $response->assertViewHas('cessationActivite');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CessationActiviteController::class,
            'update',
            \App\Http\Requests\CessationActiviteUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $cessationActivite = CessationActivite::factory()->create();
        $employe = Employe::factory()->create();
        $date_entree = Carbon::parse(fake()->date());
        $date_sortie = Carbon::parse(fake()->date());
        $motif = Motif::factory()->create();
        $description = fake()->text();

        $response = $this->put(route('cessation-activites.update', $cessationActivite), [
            'employe_id' => $employe->id,
            'date_entree' => $date_entree->toDateString(),
            'date_sortie' => $date_sortie->toDateString(),
            'motif_id' => $motif->id,
            'description' => $description,
        ]);

        $cessationActivite->refresh();

        $response->assertRedirect(route('cessationActivites.index'));
        $response->assertSessionHas('cessationActivite.id', $cessationActivite->id);

        $this->assertEquals($employe->id, $cessationActivite->employe_id);
        $this->assertEquals($date_entree, $cessationActivite->date_entree);
        $this->assertEquals($date_sortie, $cessationActivite->date_sortie);
        $this->assertEquals($motif->id, $cessationActivite->motif_id);
        $this->assertEquals($description, $cessationActivite->description);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $cessationActivite = CessationActivite::factory()->create();

        $response = $this->delete(route('cessation-activites.destroy', $cessationActivite));

        $response->assertRedirect(route('cessationActivites.index'));

        $this->assertModelMissing($cessationActivite);
    }
}
