<template>
    <div class="d-flex flex-column relative" id="card_container" v-if="pokemon">
        <h1>{{ id }}</h1>
        <img :src="pokemon.sprites.front_default" alt="" loading="lazy">
        <!-- <img :src="pokemon.sprites.other['official-artwork'].front_default" alt="" loading="lazy"> -->
        <div class="reaction">
            <h3 class="favorite" @click="preference('favorite')" :value="id">❤</h3>
            <h3 class="like" @click="preference('like')" :value="id">👍</h3>
            <h3 class="hate" @click="preference('hate')" :value="id">👎</h3>
        </div>
    </div>
</template>
<script setup>
import PokemonService from "@/Services/PokemonService"
import UserService from "@/Services/UserService";
import { onMounted, ref, defineEmits } from 'vue'

// Could use Vuex/Pinia but running out of time
const emit = defineEmits({
    'notify': (message) => true
})


const props = defineProps({
    id: {
        // type: Number, //can be name or number
        required: true
    },
    uid: {
        type: Number,
        required: true
    }
})
const pokemon = ref(null)

onMounted(() => {
    PokemonService.getPokemon(props.id)
        .then(result => {
            pokemon.value = result.data
            console.log(result.data)
        })
})

const preference = action => {
    emit('notify')
    UserService.preferencePokemon(props.id, action)
        .then(result => {
            console.log(result)
            emit('notify', result.data.message)
        })
        .catch(e => {
            console.log(e)
            emit('notify', e.response.data.message)
        })
    // Emit result to notify user
}


</script>
<style scoped>
#card_container {
    border: solid black 2px;
    margin: 5px;
    padding: 5px;
    transition: 0.2s;
    border-radius: 5%;
}

.reaction {
    position: absolute;
    top: 0;
    left: 0;
}

.reaction h3 {
    transition: 0.2s;
    font-size: 1.5em
}

.reaction h3:hover {
    font-size: 1.7em;
    cursor: pointer;
}

h1 {
    font-size: 1em;
    position: absolute;
    bottom: 0;
    color: white;
    text-transform: uppercase;
    border: black 1px solid;
    border-radius: 10px;
    padding: 0 10px;
    background: rgba(0, 0, 0, 0.5);
    transition: 0.5s;
}

h1:hover,
#card_container:hover {
    cursor: default;
    background: rgba(0, 0, 0, 0.5);
}

div:hover>h1 {
    font-size: 1.2em;
}
</style>