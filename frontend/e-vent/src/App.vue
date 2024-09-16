<script setup lang="ts">
import Header from './components/Header.vue';
import Footer from './components/Footer.vue';

</script>

<template>
  <Header></Header>
    <div class="content">
      
    <router-view></router-view>
    </div>
    
    <Footer></Footer>
</template>

<style scoped>

.content{
  position: relative;
  padding-bottom: 50px;
  margin-top: 70px;

}

Footer {
  
  position: relative;
  width: 100%; height: 50px;
  bottom: 0; left: 0; right: 0;
  /* Reste du CSS... */

    }
</style>

