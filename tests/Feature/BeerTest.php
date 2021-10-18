<?php

namespace Tests\Feature;

use App\Models\Beer;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\RoleUserSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BeerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_beers()
    {
        Beer::factory(3)->create();
        $response = $this->get(route('beers.index'));

        $response->assertOk();
    }

    public function test_get_beer()
    {
        $beer = Beer::factory()->create();
        $response = $this->get(route('beers.show', ['beer' => $beer]));

        $response->assertOk();
    }

    public function test_create_beer()
    {
        $this->admin();

        Storage::fake();

        $name = 'Test name';
        $desc = 'Test desc';
        $img = UploadedFile::fake()->image('img.png');

        $request = $this->postJson(route('admin.beers.store'), [
            'name' => $name,
            'desc' => $desc,
            'img' => $img,
        ]);

        $request->assertStatus(201);

        $beer = Beer::first();

        $this->assertNotNull($beer);
        $this->assertEquals($name, $beer->name);
        $this->assertEquals($desc, $beer->desc);
    }

    public function test_update_beer()
    {
        $this->admin();

        Storage::fake();

        $beer = Beer::factory()->create();

        $name = 'Update test name';
        $desc = 'Update test desc';
        $img = UploadedFile::fake()->image('img.png');

        $request = $this->postJson(route('admin.beers.update', ['beer' => $beer]), [
            'name' => $name,
            'desc' => $desc,
            'img' => $img,
            '_method' => 'put',
        ]);

        $request->assertStatus(200);

        $beer = Beer::first();

        $this->assertNotNull($beer);
        $this->assertEquals($name, $beer->name);
        $this->assertEquals($desc, $beer->desc);
    }

    public function test_delete_beer()
    {
        $this->admin();

        $beer = Beer::factory()->create();

        $request = $this->postJson(route('admin.beers.destroy', ['beer' => $beer]), [
            '_method' => 'delete',
        ]);

        $request->assertStatus(204);
    }

    private function admin()
    {
        $this->seed([
            UserSeeder::class,
            RoleSeeder::class,
            RoleUserSeeder::class,
        ]);

        Sanctum::actingAs(User::first());
    }
}
