<template>
  
  <div class="dashboard bg-gray-100 min-h-screen">
    <navbar></navbar>
    <div class="add-artist-form">
      <h2 class="text-2xl font-semibold mb-4">Add New Artist</h2>
      <form
        @submit.prevent="addArtist"
        class="mb-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"
      >
        <label class="mr-2">Artist Name:</label>
        <input
          v-model="newArtistName"
          required
          class="p-2 border border-gray-300 rounded col-span-full md:col-span-2 lg:col-span-1"
        />
        <button
          type="submit"
          class="bg-blue-500 text-white px-4 py-2 rounded col-span-full md:col-span-1 lg:col-span-1"
        >Add Artist</button>
      </form>

      <div>
        <h2 class="text-2xl font-semibold mb-4">List of Artists</h2>
        <table class="min-w-full bg-white border border-gray-300">
          <thead>
            <tr>
              <th class="py-2 px-4 border-b text-left">ID</th>
              <th class="py-2 px-4 border-b text-left">Name</th>
              <th class="py-2 px-4 border-b text-left">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="artist in artists" :key="artist.id">
              <td class="py-2 px-4 border-b">{{ artist.id }}</td>
              <td class="py-2 px-4 border-b">{{ artist.name }}</td>
              <td class="py-2 px-4 border-b flex items-center">
                <button
                  @click="addAlbumForArtist(artist.id)"
                  class="bg-blue-500 text-white px-2 py-1 rounded mr-2"
                >Add Album</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
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
      newArtistName: "",
      artists: []
    };
  },
  mounted() {
    this.fetchArtists();
  },
  methods: {
    async fetchArtists() {
      try {
        const response = await axios.get("/admin/artists");
        this.artists = response.data;
      } catch (error) {
        console.error("Error fetching artists:", error);
      }
    },
    async addArtist() {
      try {
        const response = await axios.post("/admin/artists", {
          name: this.newArtistName
        });
        console.log("Artist added successfully:", response.data);
        await this.fetchArtists();
      } catch (error) {
        console.error("Error adding artist:", error);
      }
    },
    addAlbumForArtist(artistId) {
      this.$router.push(`/admin/addAlbum/${artistId}`);
    }
  }
};
</script>