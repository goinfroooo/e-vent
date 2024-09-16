<template>

<section class="inscription_form bg-white p-4 rounded-3 mt-3 mx-3 offset-top">
        <h1 class="d-flex justify-content-center ">Inscription</h1>
        <div class="container">
            <div class="row ">
                <form method="post" action="./contact_form_treatment.php" id="registration_form">
                    <div class="mb-3 d-flex">
                        <div class="me-3">
                            <label for="inscription_surname" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="inscription_surname" name="first_name" placeholder="">
                        </div>
                        <div class="me-3">
                            <label for="contact_name" class="form-label ">Nom</label>
                            <input type="text" class="form-control" id="inscription_name" name="last_name" placeholder="">
                        </div>
                        <div class="mb-3 champ">
                        <label for="inscription_date_naissance" class="form-label ">Date de naissance</label>
                        <input type="date" class="form-control" id="inscription_date_naissance" name="birthday" placeholder="prenom.nom@email.com">
                    </div>
                    </div>
                    <div class="mb-3 d-flex">
                        <div class="me-3 champ w-25">
                            <label for="phone_extension" class="form-label">&nbsp;</label>
                            <select id="phone_extension" class="form-select" aria-label="Default select example" >
                                <option  v-for="(extension,country) in phone_prefix" :value="extension" :selected="country==='FR'">{{ country +" "+ extension}} </option>
                            </select>
                        </div>
                        <div class="me-3 champ w-50">
                            <label for="phone" class="form-label ">Téléphone</label>
                            <input type="tel" pattern="[0-9]{9}" class="form-control" id="phone" name="phone" placeholder="ex 601234567">
                        </div>
                        <div class=" champ w-50">
                            <label for="inscription_email" class="form-label ">Email</label>
                            <input type="email" class="form-control" id="inscription_email" name="email" placeholder="prenom.nom@email.com">
                        </div>
                        
                    </div>
                    <adress_form></adress_form>
                    
                    <div class="mb-3 champ d-flex">
                        <div class="me-3">
                            <label for="password" class="form-label ">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="password">
                        </div>
                        <div class="me-3">
                            <label for="repeat_password" class="form-label ">Répetez le mot de passe</label>
                            <input type="password" class="form-control" id="repeat_password" name="repeat_password" placeholder="">
                        </div>
                    </div>


                    <div class="g-recaptcha" data-sitekey="your_site_key"></div>

                    <div>
                        <input type="hidden" id="captcha" name="captcha">
                    </div>
                    
                <input class="btn btn-primary w-100" type="button" value = "envoyer" @click="submit_inscription_form()">
                
                </form>
            </div>
        </div>
    </section>
  
</template>

<script setup lang="ts">
    import {onMounted} from 'vue';
    import { getCookie,AskCsrfToken} from "../scripts/token";
    import Config from "../scripts/config";
    import {phone_prefix} from "../scripts/commun";
    import adress_form from "./subcomponents/Adress_form.vue";

    

const formatData = (form: HTMLFormElement) => {
    const formData: FormData = new FormData(form);
    const name: string = (formData.get("first_name") || "") + " " + (formData.get("last_name") || "");
    const adress: string = (formData.get("adress_number") || "") + " " + (formData.get("adress") || "") + " " + (formData.get("postal_code") || "") + " " + (formData.get("city") || "") + " " + (formData.get("country") || "");
    const phone_extension_element = document.getElementById("phone_extension");
    const phone_extension_value = phone_extension_element instanceof HTMLInputElement ? phone_extension_element.value : ""
    const phone: string = phone_extension_value + " " + (formData.get("phone") || "");

    const finalFormData: FormData = new FormData();

    // Ajout d'un champ avec append
    finalFormData.append('name', name);
    finalFormData.append('birthday', formData.get("birthday") || "");
    finalFormData.append('email', formData.get("email") || "");
    finalFormData.append('adress', adress);
    finalFormData.append('phone', phone);
    finalFormData.append('password', formData.get("password") || "");

    return finalFormData;
};

    
    const submit_inscription_form = async () => {
        // Récupérer les données du formulaire

        const form = document.getElementById('registration_form');
        if (form instanceof HTMLFormElement) {
            const formData: FormData =  formatData(form);
            const route = "/user/create_user";
            console.log (formData);
            await AskCsrfToken ();

            let options = {
                method: 'POST',
                headers: {
                    "X-CSRF-TOKEN": getCookie("X-CSRF-TOKEN"),
                },
                body: formData,
            }
            console.log (options);
            fetch(Config.backendConfig.apiUrl+route, options)
            .then(response => {
                console.log(response)
                if (!response.ok) {
                    throw new Error('La requête a échoué.');
                }
                return response.json();
            }) 
            .then(data => {
                console.log(data.message);
                if (data.message =="sucess") {
                    alert ("inscription effectuée");
                }
                else {
                    alert(data.message || "Une erreur inattendue s'est produite.");
                }
            })
            .catch(error => {
                if (error instanceof Error) {
                // Erreur de réseau ou d'analyse JSON
                alert("Erreur : " + error.message + ". Veuillez c l'administrateur du site.");
            } else {
                // Erreur de réponse HTTP
                alert("Erreur HTTP : " + error + ". Veuillez vérifier votre connexion Internet.");
            }
            });
        }
        
     else {
            console.error("L'élément avec l'ID 'registration_form' n'est pas un formulaire HTML.");
            // Gérez le cas où l'élément n'est pas un formulaire
    }
    }
  
  onMounted( async () => {
    AskCsrfToken();

  });
  
</script>
    
<style scoped lang="scss">

    .offset-top {

    margin-top: 70px;
    }

</style>
    