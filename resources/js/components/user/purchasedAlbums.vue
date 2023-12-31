<template>
  <div class="bg-gray-100 min-h-screen">
    <nav class="bg-blue-500 p-4 text-white">
      <div class="container mx-auto flex justify-between items-center">
        <span class="text-2xl font-semibold">Purchased Albums</span>
        <router-link to="/user/dashboard" class="text-white">Back to Dashboard</router-link>
      </div>
    </nav>

    <div class="container mx-auto p-4">
      <input
        v-model="searchQuery"
        type="text"
        class="p-2 border rounded-md focus:outline-none focus:border-blue-500"
        placeholder="Search albums"
      />
      <select v-model="sortKey" class="mb-4 p-2 border border-gray-300 rounded-lg">
        <option value="title">Sort by Title</option>
        <option value="artist.name">Sort by Artist</option>
      </select>

      <h2 class="text-2xl font-semibold mb-4">Your Purchased Albums</h2>

      <ul>
        <li
          v-for="(album, index) in filteredAlbumsData"
          :key="index"
          class="mb-4 p-4 border border-gray-300 rounded-lg"
        >
          <strong>{{ album.title }}</strong>
          by {{ album.artist ? album.artist.name : 'Unknown Artist' }}
        </li>
      </ul>
    </div>
  </div>
</template>
  
  
  <script>
import axios from "axios";

export default {
  name: "PurchasedAlbums",
  data() {
    return {
      purchasedAlbums: [],
      filteredAlbumsData: [], // New property to store filtered data
      searchQuery: "",
      sortKey: "title"
    };
  },

  async mounted() {
    await this.fetchPurchasedAlbums();
    this.fetchFilteredAlbums();
  },

  watch: {
    searchQuery: "fetchFilteredAlbums",
    sortKey: "fetchFilteredAlbums"
  },

  computed: {
    filteredAlbums() {
      if (
        !Array.isArray(this.purchasedAlbums) ||
        this.purchasedAlbums.length === 0
      ) {
        return [];
      }

      return this.purchasedAlbums
        .flat() // Flatten the array of arrays
        .filter(
          album =>
            album &&
            album.title.toLowerCase().includes(this.searchQuery.toLowerCase())
        );
    }
  },

  methods: {
    fetchPurchasedAlbums() {
      axios
        .get("/purchases")
        .then(response => {
          this.purchasedAlbums = response.data;
          console.log("Purchased Albums:", this.purchasedAlbums);
        })
        .catch(error => {
          console.error("Error fetching purchased albums", error);
        });
    },
    fetchFilteredAlbums() {
      axios
        .get("/purchases/search", {
          params: {
            search: this.searchQuery,
            sort: this.sortKey
          }
        })
        .then(response => {
          console.log("API Response:", response.data); // Log the response
          this.filteredAlbumsData = response.data;
          console.log("Filtered Albums:", this.filteredAlbumsData);
        })
        .catch(error => {
          console.error("Error fetching filtered albums", error);
        });
    }
  }
};
</script>
  