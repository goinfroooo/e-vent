<template>
    <header class="bg-light fixed-top py-1">
        <nav class="navbar navbar-expand-md  navbar-light bg-light">
            <div class="container-fluid">
                <router-link to="/" class="navbar-brand text-uppercase fw-bold text-brand ms-4">
                    <span class="bg-primary bg-gradient p-1 rounded-3 text-light">E</span> Commerce
                </router-link>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end me-3" id="navbarNav">
                    <ul v-if="isConnected" class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a v-if="profil" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{profil.name}} 
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><router-link to="/profil" class="dropdown-item">Mon profil</router-link></li>
                                <li><router-link to="/historique" class="dropdown-item">Mes commandes</router-link></li>
                                <li><button  class="dropdown-item" @click="deconnect()">Deconnexion</button></li>
                            </ul>
                        </li>
                        <li class="nav-item flex-grow-1 text-center">
                            <div class="d-inline-block position-relative">
                                <router-link to="/panier" class="nav-link">Panier</router-link>
                                <div class="position-absolute top-0 start-100 bg-warning text-white px-2 rounded-pill">
                                    {{ cart_qte }}
                                </div>
                            </div>
                        </li>





                    </ul>
                    <ul v-else  class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link " data-bs-toggle="modal" data-bs-target="#modal_connexion">Connexion</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        
    </header>

    <!-- Modal -->
    <div class="modal" id="modal_connexion" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Connexion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="./contact_form_treatment.php" id="connexion_form">
                    <div class="mb-3">
                        <label for="contact_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="connexion_email" name="connexion_email" placeholder="prenom.nom@email.com">
                    </div>
                    <div class="mb-3">
                        <label for="connexion_password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="connexion_password" name="connexion_password" placeholder="">
                    </div>

                    <input class="btn btn-primary w-100" type="button" value = "Connexion" v-on:click="submit_connexion_form()">
            </form>
        <p>Pas encore inscrit ? Inscrivez vous <router-link to="/Registration" @click="closeModal">ici</router-link></p>
    
        </div>
            <div class="modal-footer">
                <button id="btn_dismiss_modal_connexion" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
        </div>
    </div>
</template>

<script setup lang="ts">


import { AskCsrfToken,setCookie, deleteCookie,getCookie } from "../scripts/token";
import Config from "../scripts/config";

import { onMounted,onBeforeUnmount,ref,Ref } from "vue";


interface profilItem {
    name: string;
    birthday: string;
    email: string;
    adresse_livraison: string;
    adresse_facturation: string;
    phone: string;
    user_token: string;
    created_at: string;
    // Autres propriétés nécessaires
    }   

    interface ProfilInfo {
        [key: string]: string | null;
    }

const isConnected = ref(false);
const profil: Ref<profilItem | null> = ref<profilItem | null>(null);
const cart_qte: Ref<number |null> = ref <number |null> (null);
const cart_qte_interval: Ref<number | null> =ref<number | null>(null);
    
const submit_connexion_form = async () => {
    // Récupérer les données du formulaire
    try {

        let form = document.getElementById('connexion_form');
        if (form instanceof HTMLFormElement) {
            let  formData = new FormData(form);
            const route = "/user/get_connected";
            // Envoyer les données via Fetch
            await AskCsrfToken ();

            let options = {
                method: 'POST',
                headers: {
                    "X-CSRF-TOKEN":getCookie("X-CSRF-TOKEN"),
                },
                body: formData,
            }
            console.log (options);
            fetch(Config.backendConfig.apiUrl+route, options)
            .then(response => {
                console.log(response)
                if (!response.ok) {

                    console.warn(response);
                    if (response.status==401 ){
                        throw new Error("Unauthorized");
                    }
                    
                }
                return response.json();
            }) // Si le script PHP renvoie du JSON
            .then(data => {
                // Traiter la réponse du serveur (si nécessaire)
                //console.log(data);
                setCookie("USER-TOKEN", data.user_token, 30);
                const profil_info: ProfilInfo = data;
                delete profil_info["user_token"];

                const password = formData.get("password");
                if (password !== null) {
                    profil_info["password"] = password.toString(); 
                }
                setCookie("Profil",JSON.stringify(profil_info),30)
                alert ("connected");

            })
            .catch(error => {
                console.log(error);
                if (error instanceof Error) {
                    // Erreur de réseau ou d'analyse JSON
                    alert("Erreur : " + error.message + ". Veuillez c l'administrateur du site.");
                } else {
                    // Erreur de réponse HTTP
                    alert("Erreur HTTP : " + error + ". Veuillez vérifier votre connexion Internet.");
                }
            });
        } else {
            return -1;
        }
    }catch (error) {
        console.error(error);
    }

    
};

const get_cart_qte = async () => {
    // Récupérer les données du formulaire
    
    try {
        if (!isConnected.value) {
            return 1;
        }
        const route = "/cart/get_qte_tot";
        // Envoyer les données via Fetch
        await AskCsrfToken ();

        let options = {
            method: 'POST',
            headers: {
                "X-CSRF-TOKEN": getCookie("X-CSRF-TOKEN"),
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                "user_token": getCookie("USER-TOKEN"),
            }),
        }
        //console.log(options);
        const response = await fetch(Config.backendConfig.apiUrl+route, options);
            if (!response.ok) {
                throw new Error('La requête a échoué.');
            }
            
            const data = await response.json();
            // Utilisez les données récupérées ici
            
            //console.log(data);
            cart_qte.value = data.qte;
            return 0;
    } catch (error) {
        console.error(error);
    }
};

const deconnect = () => {

    deleteCookie("USER-TOKEN");
    deleteCookie("Profil");
}

const closeModal = () => {
    const btn_dismiss = document.getElementById("btn_dismiss_modal_connexion");
    if (btn_dismiss) {
        btn_dismiss.click();
    }
}

onMounted( () => {
  cart_qte_interval.value = setInterval(get_cart_qte, 1000) as unknown as number ;
});



onBeforeUnmount( () => {
  
    if (cart_qte_interval.value !== null) {
        clearInterval(cart_qte_interval.value);
    }
});

// Définir l'intervalle de 5 secondes en millisecondes
setInterval(() => {
    isConnected.value = getCookie("USER-TOKEN") === "" ? false : true;
    profil.value = getCookie("Profil")==="" ? null : JSON.parse(getCookie("Profil"));
}, 1000);


</script>

<style scoped lang="scss">


</style>