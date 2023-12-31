<template>
  <div class="add-album-container container mx-auto p-4">
    <h2 class="text-2xl font-semibold mb-4">Add New Album</h2>
    <form @submit.prevent="addAlbum" class="flex flex-col space-y-4">
      <div class="flex items-center">
        <label class="mr-2 text-gray-700">Album Title:</label>
        <input v-model="newAlbumTitle" required class="p-2 border border-gray-300 rounded" />
      </div>
      <div class="flex items-center">
        <label class="mr-2 text-gray-700">Artist ID:</label>
        <input
          v-model="newAlbumArtistId"
          type="number"
          required
          class="p-2 border border-gray-300 rounded"
        />
      </div>
      <div class="flex items-center">
        <label class="mr-2 text-gray-700">Artwork:</label>
        <input
          type="file"
          ref="artworkInput"
          @change="handleArtworkChange"
          accept="image/*"
          required
          class="p-2 border border-gray-300 rounded"
        />
      </div>
      <div class="flex items-center">
        <label class="mr-2 text-gray-700">Genre:</label>
        <input v-model="newAlbumGenre" required class="p-2 border border-gray-300 rounded" />
      </div>
      <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">Add Album</button>
    </form>

    <div class="mt-8">
      <h2 class="text-2xl font-semibold mb-4">List of Albums</h2>
      <table class="min-w-full bg-white border border-gray-300">
        <thead>
          <tr>
            <th class="py-2 px-4 border-b text-left">Title</th>
            <th class="py-2 px-4 border-b text-left">Artist ID</th>
            <th class="py-2 px-4 border-b text-left">Artwork</th>
            <th class="py-2 px-4 border-b text-left">Genre</th>
            <th class="py-2 px-4 border-b text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="album in albums" :key="album.id">
            <td class="py-2 px-4 border-b">{{ album.title }}</td>
            <td class="py-2 px-4 border-b">{{ album.artist_id }}</td>
            <td class="py-2 px-4 border-b">
              <img
                :src="'/storage/' + album.artwork"
                alt="Album Artwork"
                class="w-16 h-16 object-cover rounded-md"
              />
            </td>
            <td class="py-2 px-4 border-b">{{ album.genre }}</td>
            <td class="py-2 px-4 border-b">
              <button
                @click="addSongForAlbum(album.id)"
                class="bg-blue-500 text-white px-2 py-1 rounded"
              >Add Song</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      newAlbumTitle: "",
      newAlbumArtistId: null,
      newAlbumGenre: "",
      artworkFile: null,
      albums: []
    };
  },
  mounted() {
    this.newAlbumArtistId = this.$route.params.artistId;
    this.fetchAlbums();
  },
  methods: {
    async fetchAlbums() {
      try {
        const response = await axios.get(
          `/admin/albums/${this.newAlbumArtistId}`
        );
        this.albums = response.data;
      } catch (error) {
        console.error("Error fetching albums:", error);
      }
    },
    async addAlbum() {
      try {
        const formData = new FormData();
        formData.append("title", this.newAlbumTitle);
        formData.append("artist_id", this.newAlbumArtistId);
        formData.append("artwork", this.artworkFile);
        formData.append("genre", this.newAlbumGenre);

        const response = await axios.post(
          `/admin/addAlbum/${this.newAlbumArtistId}`,
          formData
        );
        console.log("Album added successfully:", response.data);

        await this.fetchAlbums();
      } catch (error) {
        console.error("Error adding album:", error);
      }
    },
    handleArtworkChange(event) {
      this.artworkFile = event.target.files[0];
    },
    addSongForAlbum(albumId) {
      this.$router.push(`/admin/addSong/${albumId}`);
    }
  }
};
</script>
