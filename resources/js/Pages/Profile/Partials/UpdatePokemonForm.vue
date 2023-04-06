<script setup>
import { onMounted, ref } from 'vue'
import PokemonService from '@/Services/PokemonService';
import UserService from '@/Services/UserService';
const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    likes: {
        required: true
    },
    hates: {
        required: true
    },
    favorite: {
        required: true
    },
});

const getSprite = async (pokemon) => {
    const pkmn = await PokemonService.getPokemon(pokemon)
    return pkmn.data.sprites.front_default
}

const likes_sprites = ref(null)
const hates_sprites = ref(null)
const favorite_sprites = ref(null)

onMounted(async () => {
    console.log(props.likes)

    likes_sprites.value = await Promise.all(
        props.likes.map(async (item) => {
            let sprite = await getSprite(item.pokemon)
            return [sprite, item.pokemon]
        })
    )
    hates_sprites.value = await Promise.all(
        props.hates.map(async (item) => {
            let sprite = await getSprite(item.pokemon)
            return [sprite, item.pokemon]
        })
    )
    favorite_sprites.value = await Promise.all(
        props.favorite.map(async (item) => {
            let sprite = await getSprite(item.pokemon)
            return [sprite, item.pokemon]
        })
    )
})


const removeLikes = (pokemon) => {
    likes_sprites.value = likes_sprites.value.filter(item => item[1] != pokemon)
    console.log("removing like")
    UserService.deleteUserPokemonPreference(pokemon)
    console.log("like removed")
}
const removeFavorite = (pokemon) => {
    favorite_sprites.value = favorite_sprites.value.filter(item => item[1] != pokemon)
    UserService.deleteUserPokemonPreference(pokemon)
}

const removeHates = (pokemon) => {
    console.log('removing hate')
    hates_sprites.value = hates_sprites.value.filter(item => item[1] != pokemon)
    UserService.deleteUserPokemonPreference(pokemon)
}

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Pokemon Preferences</h2>

            <p class="mt-1 text-sm text-gray-600">
                Remove your Pokemon preferences here.
            </p>
        </header>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5>Likes</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-4 relative" v-if="likes_sprites" v-for="pokemon in likes_sprites">
                    <h4 class="remove" @click="removeLikes(pokemon[1])">x</h4>
                    {{ pokemon[1] }}
                    <img :src="pokemon[0]" alt="">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h5>Hates</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-4 relative" v-for="hate in hates_sprites">
                    <h4 class="remove" @click="removeHates(hate[1])">x</h4>
                    {{ hate[1] }}
                    <img :src="hate[0]" alt="">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h5>Favorite</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-4 relative" v-for="favorite in favorite_sprites">
                    <h4 class="remove" @click="removeFavorite(favorite[1])">x</h4>
                    {{ favorite[1] }}
                    <img :src="favorite[0]" alt="">
                </div>
            </div>
        </div>
    </section>
</template>
<style scoped>
h4.remove {
    color: red;
    position: absolute;
    top: 20px;
    left: 0;
}

h4.remove:hover {
    cursor: pointer;
}
</style>