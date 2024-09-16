<template>


  <div class="container mt-5" >
    <div v-if="!article" class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    <div v-else class="card d-flex align-items-center">
        <img :src="Config.backendConfig.apiUrl+article.img_path" class="card-img-top w-50 h-50" :alt="article.short_desc" >
        <div class="card-body">
            <h5 class="card-title">{{article.nom}}</h5>
            <p class="card-text">{{ article.description }}</p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Prix : {{formatPrice(article.prix)}}</li>
        </ul>
        <div class="card-body d-flex justify-content-center align-items-center">
          
          <input v-if="article.stock!=0" class="form-control me-3" id="qte" name="qte" type="number" min="0" :max="article.stock" step="1" value="1" style="width: 10%;">
          <button v-if="article.stock!=0"
            id="add-to-cart-btn"
            href="#"
            class="card-link btn btn-primary me-3"
            @click="add_to_cart($event)">
            Ajouter au panier
          </button>
          <p class="text-danger p-0 m-0">{{ article.stock }} article(s) restants</p>
          
        </div>
    </div>
  </div>

</template>
  
<script setup lang="ts">
  import { ref,Ref, onMounted } from 'vue';
  import { getCookie,AskCsrfToken} from "../scripts/token";
  import Config from "../scripts/config";
  import { articleItem } from '../scripts/interface';
  import { useRoute } from 'vue-router';
  import {formatPrice,get_article_data,showPopover} from "../scripts/commun";




  const article: Ref<articleItem | null> = ref<articleItem | null>(null);


const add_to_cart = async (event: Event) => {

  
    try {
      if (article.value === null ) {
            return -1;
          }
      const user_token = getCookie("USER-TOKEN");

      if (!user_token) {
        alert ("veuillez vous connectez ou creer un compte");
        return -1;
      }

      const qteElement = document.getElementById("qte") as HTMLInputElement | null;

      if (qteElement !== null) {
        const qteValue = qteElement.value;
        const route = "/cart/add";
        let options = {
            method: 'POST',
            headers: {
                "X-CSRF-TOKEN": getCookie("X-CSRF-TOKEN"),
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
              "article_token": article.value.token,
              "user_token": user_token,
              "qte": qteValue,
              
            }),
        }
        //console.log(options);

        
            const response = await fetch(Config.backendConfig.apiUrl + route, options);
            if (!response.ok) {
                throw new Error('La requête a échoué.');
            }
            const data = await response.json();

            article.value = await get_article_data(article.value.token);
            showPopover(event);
            return data.message==="sucess" ? 0 : -1;
      } else {
        console.error('Element with ID "qte" not found');
      }
      
      
      } catch (error) {
          console.error("Erreur lors de l'envoi du formulaire:", error);
          alert("erreur : veuillez contacter l'administrateur du site")
      }

}

onMounted( async () => {
  AskCsrfToken();
  const route = useRoute();
  const articleToken = route.params.token.toString(); 
  article.value = await get_article_data(articleToken);
  //console.log(article.value);
  
});



</script>

<style scoped lang="scss">


</style>
  