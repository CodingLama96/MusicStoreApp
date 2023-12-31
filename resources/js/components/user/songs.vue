<template>
  <div class="bg-gray-100 min-h-screen">
    <nav class="bg-blue-500 p-4 text-white">
      <div class="container mx-auto flex justify-between items-center">
        <span class="text-2xl font-semibold">Songs</span>
        <router-link to="/user/dashboard" class="text-white">Back to Dashboard</router-link>
      </div>
    </nav>

    <div class="container mx-auto p-4 relative">
      <h2 class="text-2xl font-semibold mb-4">Songs for Album: {{ currentAlbum.title }}</h2>
      <button
        @click="buyAlbum"
        class="absolute top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-700"
      >Buy Album</button>
      <ul>
        <li
          v-for="(song, index) in albumSongs"
          :key="index"
          class="mb-4 p-4 border border-gray-300 rounded-lg"
        >
          <h3 class="text-xl font-semibold mb-2">{{ song.title }}</h3>
          <p class="text-gray-600">{{ song.artist }}</p>
          <button
            @click="downloadSong(song)"
            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700"
          >Download Song</button>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Songs",
  data() {
    return {
      currentAlbum: {},
      albumSongs: []
    };
  },
  mounted() {
    this.fetchAlbumDetails();
    this.fetchAlbumSongs();
  },
  methods: {
    fetchAlbumDetails() {
      const albumId = this.$route.params.albumId;

      axios
        .get(`/albums/${albumId}`)
        .then(response => {
          this.currentAlbum = response.data;
        })
        .catch(error => {
          console.error("Error fetching album details", error);
        });
    },
    fetchAlbumSongs() {
      const albumId = this.$route.params.albumId;

      axios
        .get(`/albums/${albumId}/songs`)
        .then(response => {
          this.albumSongs = response.data;
        })
        .catch(error => {
          console.error("Error fetching album songs", error);
        });
    },
    buyAlbum() {
      const albumId = this.$route.params.albumId;
      axios
        .post(`/purchase/${albumId}`)
        .then(response => {
          alert(response.data.message);
        })
        .catch(error => {
          console.error("Error purchasing album", error);
          alert("Error purchasing album. Please try again.");
        });
    },
    downloadSong(song) {
      const downloadLink = `/storage/${song.audio}`;

      window.location.href = downloadLink;
    }
  }
};
</script>
