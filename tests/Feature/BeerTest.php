<?php

namespace Tests\Feature;

use App\Models\Beer;
use App\Models\User;
use Faker\Factory;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BeerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_beers()
    {
        $response = $this->get('/api/beers');

        $response->assertOk();
    }

    public function test_get_admin_beers()
    {
        $this->auth();

        $response = $this->get('/api/admin/beers');

        $response->assertOk();
    }

    public function test_get_beer()
    {
        $response = $this->get('/api/beers/1');

        $response->assertOk();
    }

    private function auth()
    {
        Sanctum::actingAs(User::findByEmail('admin@test.test'));
    }
}
