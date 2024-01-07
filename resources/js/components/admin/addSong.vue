<template>
  <div class="add-album-bg-gray-100 min-h-screen">
    <navbar></navbar>
    <h2 class="text-2xl font-semibold mb-4">Add New Song</h2>
    <form @submit.prevent="addSong" class="flex flex-col space-y-4">
      <div class="flex items-center">
        <label class="mr-2 text-gray-700">Song Title:</label>
        <input v-model="newSongTitle" required class="p-2 border border-gray-300 rounded" />
      </div>
      <div class="flex items-center">
        <label class="mr-2 text-gray-700">Album ID:</label>
        <input
          v-model="newSongAlbumId"
          type="number"
          required
          class="p-2 border border-gray-300 rounded"
        />
      </div>
      <div class="flex items-center">
        <label class="mr-2 text-gray-700">Audio:</label>
        <input type="file" @change="handleAudioChange" required />
      </div>
      <button type="submit" class="bg-blue-500 text-white px-3 py-2 rounded">Add Song</button>
    </form>

    <div class="mt-8">
      <h2 class="text-2xl font-semibold mb-4">List of Songs</h2>
      <table class="min-w-full bg-white border border-gray-300">
        <thead>
          <tr>
            <th class="py-2 px-4 border-b text-left">Title</th>
            <th class="py-2 px-4 border-b text-left">Album ID</th>
            <th class="py-2 px-4 border-b text-left">Audio</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="song in songs" :key="song.id">
            <td class="py-2 px-4 border-b">{{ song.title }}</td>
            <td class="py-2 px-4 border-b">{{ song.album_id }}</td>
            <td class="py-2 px-4 border-b">{{ song.audio }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import navbar from "./navbar.vue";
  
export default {
  components: {
    navbar,
  },
  data() {
    return {
      newSongTitle: "",
      newSongAlbumId: null,
      newSongAudio: "",
      songs: []
    };
  },
  mounted() {
    this.newSongAlbumId = this.$route.params.albumId;
    this.fetchSongs();
  },
  methods: {
    async fetchSongs() {
      try {
        const response = await axios.get(`/admin/songs/${this.newSongAlbumId}`);
        this.songs = response.data;
      } catch (error) {
        console.error("Error fetching songs:", error);
      }
    },
    handleAudioChange(event) {
      this.newSongAudio = event.target.files[0];
    },
    async addSong() {
      try {
        const formData = new FormData();
        formData.append("title", this.newSongTitle);
        formData.append("album_id", this.newSongAlbumId);
        formData.append("audio", this.newSongAudio);

        const response = await axios.post(
          `/admin/songs/${this.newSongAlbumId}`,
          formData
        );
        console.log("Song added successfully:", response.data);
        await this.fetchSongs();
        // this.$router.push(`/admin/addAlbum/${this.newSongAlbumId}`);
      } catch (error) {
        console.error("Error adding song:", error);
      }
    }
  }
};
</script>