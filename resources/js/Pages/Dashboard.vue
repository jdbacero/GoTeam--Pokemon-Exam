<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PokemonService from '../Services/PokemonService'
import { ref, onMounted } from 'vue'
import PokemonCard from '@/Components/PokemonCard.vue'
import Notification from '@/Components/Notification.vue';


// notif supposed to be vuex/pinia but running out of time
const notif_visibility = ref(false);
const notif_msg = ref(null)

const show_notif = (msg) => {
    notif_msg.value = msg
    console.log('showing notif...')
    console.log('Notification message should be: ', msg)
    notif_visibility.value = true
    setTimeout(() => {
        notif_visibility.value = false
        notif_msg.value = null
    }, 3000)
}

// const show_notif = msg => {
//     console.log(msg)
// }

const props = defineProps({
    uid: {
        type: Number,
        required: true
    }
})

const pokemons = ref(null)
onMounted(() => {
    PokemonService.getPokemons().
        then(result => {
            pokemons.value = result.data.results
            console.log(result)
        })
        .catch(e => {
            console.log(e)
        })
})

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <!-- Can be done globally but running out of time. Add color if u have the time. Otherwise, make transparent black by default -->
        <Notification :color="'red'" :msg="notif_msg" v-if="notif_visibility" />

        <div class="container mt-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 row">
                <div v-if="pokemons" v-for="pokemon in pokemons" class="col-6 col-lg-2 col-md-4">
                    <PokemonCard :id="pokemon.name" :uid="props.uid" @notify="show_notif" />
                </div>
                <div v-else>Loading pokemons...</div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
