<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Song;

class MusicControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $artist;
    protected $album;
    protected $song;

    protected function setUp(): void
    {
        parent::setUp();

        // Create artist, album, and song
        $this->artist = Artist::create(['name' => 'Test Artist']);
        $this->album = Album::create(['title' => 'Test Album', 'artist_id' => $this->artist->id, 'artwork' => 'test_artwork.jpg', 'genre' => 'Test Genre']);
        $this->song = Song::create(['title' => 'Test Song', 'album_id' => $this->album->id]);
    }

    public function testGetAlbums()
    {
        $response = $this->get("/albums");

        $expected = count(Album::all());
        $actual = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $this->assertCount($expected, $actual);
    }

}
