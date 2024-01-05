<?php
namespace Tests\Unit;

use App\Models\Artist;
use App\Models\Album;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $artist1;
    protected $artist2;
    protected $album1;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artist1 = Artist::create(['name' => 'Artist 1']);
        $this->artist2 = Artist::create(['name' => 'Artist 2']);

        $this->album1 = Album::create([
            'artist_id' => $this->artist1->id,
            'title' => 'Album 1',
            'artwork' => 'album1.jpg',
            'genre' => 'Test Genre',
        ]);
    }

    public function testGetArtists()
    {
        $response = $this->get('/artists');

        $expected = [
            'artists' => [
                ['id' => $this->artist1->id, 'name' => 'Artist 1'],
                ['id' => $this->artist2->id, 'name' => 'Artist 2'],
            ],
        ];

        $response->assertStatus(200)
            ->assertJson($expected);
    }

    public function testGetAlbums()
    {
        $response = $this->get('/albums');

        $expected = [
            [
                'id' => $this->album1->id,
                'title' => 'Album 1',
                'artist_id' => $this->artist1->id,
                'artwork' => 'album1.jpg',
                'genre' => 'Test Genre',
                'created_at' => $this->album1->created_at->toISOString(),
                'updated_at' => $this->album1->updated_at->toISOString(),
            ],
        ];

        $response->assertStatus(200)
            ->assertJson($expected);
    }
}
