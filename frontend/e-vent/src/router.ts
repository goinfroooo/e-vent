import { createRouter, createWebHistory } from 'vue-router'
import Home from './components/Home.vue';
import Article from './components/Article.vue';
import Registration from './components/Registration.vue';
import Profil from "./components/Profil.vue";
import Panier from "./components/Panier.vue";
import Commande from "./components/Commande.vue";
import Historique from "./components/Historique.vue";


const routes = [
  {path: '/',name: 'Home',component: Home},
  {path: '/article/:token',name: 'Article',component: Article, props: true},
  {path: '/registration',name: 'Registration',component: Registration},
  {path: '/profil',name: 'Profil',component: Profil},
  {path: '/panier',name: 'Panier',component: Panier},
  {path: '/historique',name: 'Historique',component: Historique},
  {path: '/commande',name: 'Commande',component: Commande},

]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
