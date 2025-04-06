<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UserController
 */
final class UserControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $users = User::factory()->count(3)->create();

        $response = $this->get(route('users.index'));

        $response->assertOk();
        $response->assertViewIs('user.index');
        $response->assertViewHas('users');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('users.create'));

        $response->assertOk();
        $response->assertViewIs('user.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UserController::class,
            'store',
            \App\Http\Requests\UserStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $username = fake()->userName();
        $email = fake()->safeEmail();
        $password = fake()->password();
        $role = fake()->word();
        $profile_image = fake()->word();
        $phone = fake()->phoneNumber();
        $is_active = fake()->boolean();

        $response = $this->post(route('users.store'), [
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role' => $role,
            'profile_image' => $profile_image,
            'phone' => $phone,
            'is_active' => $is_active,
        ]);

        $users = User::query()
            ->where('username', $username)
            ->where('email', $email)
            ->where('password', $password)
            ->where('role', $role)
            ->where('profile_image', $profile_image)
            ->where('phone', $phone)
            ->where('is_active', $is_active)
            ->get();
        $this->assertCount(1, $users);
        $user = $users->first();

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('user.id', $user->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $user = User::factory()->create();

        $response = $this->get(route('users.show', $user));

        $response->assertOk();
        $response->assertViewIs('user.show');
        $response->assertViewHas('user');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $user = User::factory()->create();

        $response = $this->get(route('users.edit', $user));

        $response->assertOk();
        $response->assertViewIs('user.edit');
        $response->assertViewHas('user');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UserController::class,
            'update',
            \App\Http\Requests\UserUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $user = User::factory()->create();
        $username = fake()->userName();
        $email = fake()->safeEmail();
        $password = fake()->password();
        $role = fake()->word();
        $profile_image = fake()->word();
        $phone = fake()->phoneNumber();
        $is_active = fake()->boolean();

        $response = $this->put(route('users.update', $user), [
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role' => $role,
            'profile_image' => $profile_image,
            'phone' => $phone,
            'is_active' => $is_active,
        ]);

        $user->refresh();

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('user.id', $user->id);

        $this->assertEquals($username, $user->username);
        $this->assertEquals($email, $user->email);
        $this->assertEquals($password, $user->password);
        $this->assertEquals($role, $user->role);
        $this->assertEquals($profile_image, $user->profile_image);
        $this->assertEquals($phone, $user->phone);
        $this->assertEquals($is_active, $user->is_active);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $user = User::factory()->create();

        $response = $this->delete(route('users.destroy', $user));

        $response->assertRedirect(route('users.index'));

        $this->assertSoftDeleted($user);
    }
}
