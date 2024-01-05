<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Artist;
use App\Models\Album;

class ArtistControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $artist1;
    protected $artist2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artist1 = Artist::create(['name' => 'Artist 1']);
        $this->artist2 = Artist::create(['name' => 'Artist 2']);
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

    public function testGetAlbumsByArtist()
    {
        $artist = Artist::create(['name' => 'Test Artist']);
        $album = Album::create([
            'title' => 'Album 1',
            'artist_id' => $artist->id,
            'artwork' => 'album1.jpg',
            'genre' => 'Rock',
        ]);

        $response = $this->get("/artists/{$artist->id}/albums");

        $expected = [
            'albums' => [
                ['id' => $album->id, 'title' => 'Album 1'],
            ],
        ];

        $response->assertStatus(200)
            ->assertJson($expected);
    }
}
