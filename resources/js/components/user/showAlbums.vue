<template>
  <div class="bg-gray-100 min-h-screen">
    <nav class="bg-blue-500 p-4 text-white">
      <div class="container mx-auto flex justify-between items-center">
        <span class="text-2xl font-semibold">Albums Page</span>
        <div class="relative" @click="toggleDropdown">
          <button class="text-white">{{ currentUser.name }}</button>
          <div
            v-show="isDropdownOpen"
            class="absolute top-10 right-0 bg-white shadow-md p-2 rounded-lg"
          >
            <button @click="profile" class="block px-4 py-2 text-red-500 hover:bg-gray-100">Profile</button>
            <button @click="logout" class="block px-4 py-2 text-red-500 hover:bg-gray-100">Logout</button>
          </div>
        </div>
      </div>
    </nav>

    <div class="container mx-auto p-4">
      <h2 class="text-2xl font-semibold mb-4">Explore and Buy Albums, {{ currentUser.name }}!</h2>

      <div class="search-container mb-4">
        <input
          v-model="searchQuery"
          type="text"
          class="p-2 border rounded-md focus:outline-none focus:border-blue-500 w-full"
          placeholder="Search albums"
        />
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <div
          v-for="(album, index) in filteredAlbums"
          :key="index"
          class="mb-4 p-4 border border-gray-300 rounded-lg"
        >
          <img
            :src="album.artwork"
            alt="Album Artwork"
            class="w-full h-32 object-cover mb-2 rounded-md shadow-lg"
          />
          <h3 class="text-lg font-semibold mb-1">{{ album.title }}</h3>
          <p class="text-gray-600 mb-2">{{ album.artist }}</p>
          <p class="text-blue-500 mb-2">{{ album.genre }}</p>
          <button
            @click="viewAlbum(album)"
            class="block bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700"
          >View Album</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "AlbumsPage",
  data() {
    return {
      isDropdownOpen: false,
      currentUser: {
        name: ""
      },
      musicAlbums: [],
      searchQuery: ""
    };
  },
  mounted() {
    this.fetchUserData();
    this.fetchMusicAlbums();
  },
  computed: {
    filteredAlbums() {
      if (!Array.isArray(this.musicAlbums) || this.musicAlbums.length === 0) {
        return [];
      }

      return this.musicAlbums.filter(
        album =>
          album &&
          album.title.toLowerCase().includes(this.searchQuery.toLowerCase())
      );
    }
  },
  methods: {
    fetchMusicAlbums() {
      axios
        .get("/albums")
        .then(response => {
          this.musicAlbums = response.data.map(album => ({
            id: album.id,
            title: album.title,
            artist: album.artist,
            artwork: `/storage/${album.artwork}`,
            genre: album.genre
          }));
        })
        .catch(error => {
          console.error("Error fetching music albums", error);
        });
    },
    fetchUserData() {
      axios
        .get("/user")
        .then(response => {
          this.currentUser = response.data.user;
        })
        .catch(error => {
          console.error("Error fetching user data", error);
        });
    },
    toggleDropdown() {
      this.isDropdownOpen = !this.isDropdownOpen;
    },
    profile() {
      this.$router.push("/profile");
    },
    logout() {
      this.$router.push("/logout");
    },
    viewAlbum(album) {
      this.$router.push({ name: "Songs", params: { albumId: album.id } });
    }
  }
};
</script>

<style scoped>
/* Add any custom styles here */
</style>
