<?php

namespace Tests\Unit\Controllers;

use App\Models\Album;
use App\Models\User;
use App\Models\Artist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        $this->token = $this->user->createToken('authToken')->plainTextToken;
    }

    private function createAlbums($count, $genrePrefix = 'Genre')
    {
        $albums = [];
        for ($i = 1; $i <= $count; $i++) {
            $artist = Artist::create([
                'name' => "Artist $i",
            ]);
            // Create an album with the associated artist
            $albums[] = Album::create([
                'title' => "Album $i",
                'artist_id' => $artist->id,
                'artwork' => "artwork$i.jpg",
                'genre' => "$genrePrefix $i",
            ]);
        }

        return $albums;
    }

    public function testPurchaseAlbum()
    {
        $albums = $this->createAlbums(1);

        $response = $this->actingAs($this->user)->postJson("/purchase/{$albums[0]->id}");

        $expectedStatus = 200;
        $actualStatus = $response->status();
        $this->assertEquals($expectedStatus, $actualStatus);

        $expectedJson = ['message' => 'Album purchased successfully'];
        $actualJson = $response->json();
        $this->assertEquals($expectedJson, $actualJson);
    }

    public function testGetPurchases()
    {
        $albums = $this->createAlbums(3);

        $this->user->albums()->attach([$albums[0]->id, $albums[1]->id, $albums[2]->id]);

        $response = $this->actingAs($this->user)
            ->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->getJson('/purchases');

        $expected = [
            'purchased_albums' => [
                ['id', 'title', 'artist_id', 'artwork', 'genre'],
            ],
        ];

        $response->assertStatus(200)->assertJsonStructure($expected);
    }


}
