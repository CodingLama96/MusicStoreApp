import { createApp } from "vue";
import Login from "./components/auth/login.vue";
import Register from "./components/auth/Register.vue";
import Logout from "./components/auth/Logout.vue";
import Welcome from './components/welcome.vue';
import AdminDashboard from './components/admin/dashboard.vue';
import UserDashboard from './components/user/dashboard.vue';
import Songs from './components/user/songs.vue';
import AddAlbum from './components/admin/addAlbum.vue';
import AddArtist from './components/admin/addArtist.vue';
import AddSong from './components/admin/addSong.vue';
import ShowAlbums from './components/user/showAlbums.vue';
import PurchasedAlbums from './components/user/PurchasedAlbums.vue';
import App from './components/App.vue';
import { createRouter, createWebHistory } from 'vue-router';

const routes = [
  //// Authentication
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/logout', component: Logout },


  { path: '/welcome', component: Welcome },
  { path: '/user/dashboard', component: UserDashboard },
  { path: '/user/showAlbums', component: ShowAlbums },
  { path: '/user/showPurchasedAlbums', component: PurchasedAlbums },
  { path: '/albums/:albumId/songs', name: 'Songs', component: Songs },

  // Admin route
  { path: '/admin/dashboard', component: AdminDashboard },
  { path: '/admin/addArtist', component: AddArtist },
  { path: '/admin/addSong/:albumId', component: AddSong },
  { path: '/admin/addAlbum/:artistId', component: AddAlbum },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});
createApp(App).use(router).mount('#app');