<template>

<div class="card payment_card p-2 w-100 h-100">
    <div class="card-body d-flex flex-column justify-content-between">
        <div>
            <h4 class="card-title">Total</h4>
            <div class="my-2 rounded-3">({{ qte_tot }} articles) : <span class="fw-bold">{{ prix_total }} €</span></div>
        </div>
        <button class="btn btn-warning my-2 align-self-center" @click="commander">Passer la commande</button>
    </div>
</div>

</template>

<script setup lang="ts">

    import { defineProps,computed } from 'vue';
    import { useRouter } from 'vue-router';
    //    import { CommandeStore } from '../../store/commande';

    interface CartItem {
        nom: string;
        prix: number;
        short_desc: string;
        img_path: string;
        article_token: string;
        qte: number;
        standby: boolean;
    // Autres propriétés nécessaires
    }   

    const router = useRouter();
    const props = defineProps({
    carts: {
        type: [Array, null] as unknown as () => (CartItem[] | null),
        default: null
    }
});


    const prix_total = computed(()=>{
        let prix_tot=0;
        if (props.carts===null) {
            return prix_tot;
        }
        for (let cart of props.carts){
            if (!cart.standby) {
                prix_tot+=cart.prix*cart.qte;
            }
        }
        return prix_tot/100;
    })
    const qte_tot= computed(()=>{
        let qte=0;
        if (props.carts===null) {
            return qte;
        }
        for (let cart of props.carts){
            if (!cart.standby) {
                qte+=cart.qte;
            }
        }
        return qte;
    })
    
    const commander = () => {
        //CommandeStore.carts=props.carts; reliquat
        router.push({ name: 'Commande'});
    }
</script>
    
<style scoped lang="scss">




</style>
        