<template>
    <footer class="border-top border-dark border-5 bg-ligth">
        <div class="container-fluid container-lg py-3 px-5">
            <div class="row gy-4">
                <div class="col-12 text-center">
                    <a class="text-dark link-hover me-4" data-bs-toggle="modal" data-bs-target="#modal_mention_legales">Mentions légales</a>
                    <a class="text-dark link-hover" data-bs-toggle="modal" data-bs-target="#modal_conditions_vente">Conditions de ventes</a>
                </div>
                <div class="modal" id="modal_mention_legales" tabindex="-1">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Mentions Légales</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h5 class="text-uppercase fw-bold">Editeur du Site</h5>
                            <p>SORIA Erwan<br>
                            1 place du 1er Mai 36330 Le Poinçonnet<br>
                            0652501448<br>
                            erwan.soria@xoop.fr</p>

                            <h5 class="text-uppercase fw-bold">Directeur de la publication</h5>
                            <p>SORIA Erwan</p>

                            <h5 class="text-uppercase fw-bold">Hébergement</h5>
                            <p>Hostinger</p>

                            <h5 class="text-uppercase fw-bold">Propriété intellectuelle</h5>
                            <p>Le contenu de ce site web est protégé par les lois sur la propriété intellectuelle. Toute reproduction ou utilisation non autorisée du contenu est strictement interdite.</p>
                            
                            <h5 class="text-uppercase fw-bold">Cookies</h5>
                            <p>Ce site utilise des cookies pour améliorer votre expérience de navigation. Vous pouvez désactiver les cookies dans les paramètres de votre navigateur.</p>
                            
                            <h5 class="text-uppercase fw-bold">Liens externes</h5>
                            <p>Ce site peut contenir des liens vers des sites externes sur lesquels nous n'avons aucun contrôle. Nous déclinons toute responsabilité quant au contenu de ces sites externes.</p>
                            
                            <h5 class="text-uppercase fw-bold">Responsabilité</h5>
                            <p>L'éditeur du site ne peut être tenu responsable des erreurs, omissions ou problèmes techniques pouvant survenir sur le site.</p>
                            
                            <h5 class="text-uppercase fw-bold">Contact</h5>
                            <p>Pour toute question ou préoccupation concernant ces mentions légales, veuillez nous contacter à l'adresse suivante : erwan.soria@xoop.fr</p>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="modal" id="modal_conditions_vente" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">Conditions de Vente</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                

                                <h5 class="text-uppercase fw-bold">Commandes</h5>
                                <p>Les commandes sont soumises à disponibilité. En passant commande, vous acceptez de payer le montant total indiqué pour le produit ou le service sélectionné.</p>

                                <h5 class="text-uppercase fw-bold">Paiement</h5>
                                <p>Le paiement est requis au moment de la commande. Nous acceptons les modes de paiement suivants : [indiquer les modes de paiement acceptés].</p>

                                <h5 class="text-uppercase fw-bold">Livraison</h5>
                                <p>Les programmes de musculation seront accessibles en ligne immédiatement après le paiement. Pour les coachings de suivi mensuel, un membre de notre équipe vous contactera dans les [indiquer délai] pour démarrer le programme.</p>

                                <h5 class="text-uppercase fw-bold">Remboursement</h5>
                                <p>Les remboursements sont disponibles dans les [indiquer délai] suivant la date d'achat, sous réserve de nos conditions de remboursement.</p>

                                <h5 class="text-uppercase fw-bold">Contact</h5>
                                <p>Pour toute question ou préoccupation concernant nos conditions de vente, veuillez nous contacter à l'adresse suivante : [adresse e-mail de contact].</p>
                            </div>
                        <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

            </div>
        </div>
    </footer>
</template>

<script setup lang="ts">

</script>

<style scoped lang="scss">


</style>