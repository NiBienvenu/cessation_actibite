<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Application;
use App\Models\Commissariat;
use App\Models\Direction;
use App\Models\Employe;
use App\Models\Fonction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EmployeController
 */
final class EmployeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $employes = Employe::factory()->count(3)->create();

        $response = $this->get(route('employes.index'));

        $response->assertOk();
        $response->assertViewIs('employe.index');
        $response->assertViewHas('employes');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('employes.create'));

        $response->assertOk();
        $response->assertViewIs('employe.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EmployeController::class,
            'store',
            \App\Http\Requests\EmployeStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $matricule = fake()->word();
        $nom = fake()->word();
        $prenom = fake()->word();
        $genre = fake()->word();
        $adresse = fake()->word();
        $email = fake()->safeEmail();
        $profil = fake()->word();
        $phone = fake()->phoneNumber();
        $is_active = fake()->boolean();
        $fonction = Fonction::factory()->create();
        $direction = Direction::factory()->create();
        $commissariat = Commissariat::factory()->create();
        $application = Application::factory()->create();

        $response = $this->post(route('employes.store'), [
            'matricule' => $matricule,
            'nom' => $nom,
            'prenom' => $prenom,
            'genre' => $genre,
            'adresse' => $adresse,
            'email' => $email,
            'profil' => $profil,
            'phone' => $phone,
            'is_active' => $is_active,
            'fonction_id' => $fonction->id,
            'direction_id' => $direction->id,
            'commissariat_id' => $commissariat->id,
            'application_id' => $application->id,
        ]);

        $employes = Employe::query()
            ->where('matricule', $matricule)
            ->where('nom', $nom)
            ->where('prenom', $prenom)
            ->where('genre', $genre)
            ->where('adresse', $adresse)
            ->where('email', $email)
            ->where('profil', $profil)
            ->where('phone', $phone)
            ->where('is_active', $is_active)
            ->where('fonction_id', $fonction->id)
            ->where('direction_id', $direction->id)
            ->where('commissariat_id', $commissariat->id)
            ->where('application_id', $application->id)
            ->get();
        $this->assertCount(1, $employes);
        $employe = $employes->first();

        $response->assertRedirect(route('employes.index'));
        $response->assertSessionHas('employe.id', $employe->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $employe = Employe::factory()->create();

        $response = $this->get(route('employes.show', $employe));

        $response->assertOk();
        $response->assertViewIs('employe.show');
        $response->assertViewHas('employe');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $employe = Employe::factory()->create();

        $response = $this->get(route('employes.edit', $employe));

        $response->assertOk();
        $response->assertViewIs('employe.edit');
        $response->assertViewHas('employe');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EmployeController::class,
            'update',
            \App\Http\Requests\EmployeUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $employe = Employe::factory()->create();
        $matricule = fake()->word();
        $nom = fake()->word();
        $prenom = fake()->word();
        $genre = fake()->word();
        $adresse = fake()->word();
        $email = fake()->safeEmail();
        $profil = fake()->word();
        $phone = fake()->phoneNumber();
        $is_active = fake()->boolean();
        $fonction = Fonction::factory()->create();
        $direction = Direction::factory()->create();
        $commissariat = Commissariat::factory()->create();
        $application = Application::factory()->create();

        $response = $this->put(route('employes.update', $employe), [
            'matricule' => $matricule,
            'nom' => $nom,
            'prenom' => $prenom,
            'genre' => $genre,
            'adresse' => $adresse,
            'email' => $email,
            'profil' => $profil,
            'phone' => $phone,
            'is_active' => $is_active,
            'fonction_id' => $fonction->id,
            'direction_id' => $direction->id,
            'commissariat_id' => $commissariat->id,
            'application_id' => $application->id,
        ]);

        $employe->refresh();

        $response->assertRedirect(route('employes.index'));
        $response->assertSessionHas('employe.id', $employe->id);

        $this->assertEquals($matricule, $employe->matricule);
        $this->assertEquals($nom, $employe->nom);
        $this->assertEquals($prenom, $employe->prenom);
        $this->assertEquals($genre, $employe->genre);
        $this->assertEquals($adresse, $employe->adresse);
        $this->assertEquals($email, $employe->email);
        $this->assertEquals($profil, $employe->profil);
        $this->assertEquals($phone, $employe->phone);
        $this->assertEquals($is_active, $employe->is_active);
        $this->assertEquals($fonction->id, $employe->fonction_id);
        $this->assertEquals($direction->id, $employe->direction_id);
        $this->assertEquals($commissariat->id, $employe->commissariat_id);
        $this->assertEquals($application->id, $employe->application_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $employe = Employe::factory()->create();

        $response = $this->delete(route('employes.destroy', $employe));

        $response->assertRedirect(route('employes.index'));

        $this->assertSoftDeleted($employe);
    }
}
