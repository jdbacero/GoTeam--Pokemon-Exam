<script setup>
import { onMounted, computed, ref } from 'vue'
import PokemonService from '@/Services/PokemonService';
const props = defineProps({
    pokemon_preferences: {
        required: true,
    }
})

const favorites = ref(null)
const likes = ref(null)
const hates = ref(null)

onMounted(async () => {
    console.log("pokemon pref", props.pokemon_preferences)
    favorites.value = await Promise.all(
        props.pokemon_preferences.flatMap(item => {
            if (item.action == 'favorite') {
                return PokemonService.getPokemon(item.pokemon)
                    .then(response => response.data)
            } else {
                return []
            }
        })
    )

    likes.value = await Promise.all(
        props.pokemon_preferences.flatMap(item => {
            if (item.action == 'like') {
                return PokemonService.getPokemon(item.pokemon)
                    .then(response => response.data)
            } else {
                return []
            }
        })
    )

    hates.value = await Promise.all(
        props.pokemon_preferences.flatMap(item => {
            if (item.action == 'hate') {
                return PokemonService.getPokemon(item.pokemon)
                    .then(response => response.data)
            } else {
                return []
            }
        })
    )
    console.log("fav", favorites.value)
})

</script>
<template>
    <div class="d-flex flex-row col-12" id="pokemon_container">
        <div class="favorites col-lg-4 col-12 d-flex flex-row justify-content-center relative justify-items-center">
            <h4 class="preference">Favorites</h4>
            <span v-for="favorite in favorites" class="">
                <img :src="favorite.sprites.front_default" alt="" loading="lazy" class="favorites-img">
                <p class="text-center pokemon-name">
                    {{ favorite.name.toUpperCase() }}
                </p>
            </span>
        </div>
        <div class="hates col-lg-4 col-12 d-flex flex-row justify-content-center relative justify-items-center">
            <h4 class="preference">Hates</h4>
            <span v-for="hate in hates">
                <img :src="hate.sprites.front_default" alt="" loading="lazy" class="hates-img">
                <p class="text-center pokemon-name">
                    {{ hate.name.toUpperCase() }}
                </p>
            </span>
        </div>
        <div class="likes col-lg-4 col-12 d-flex flex-row justify-content-center relative justify-items-center">
            <h4 class="preference">Likes</h4>
            <span v-for="like in likes">
                <img :src="like.sprites.front_default" alt="" loading="lazy" class="likes-img">
                <p class="text-center pokemon-name">
                    {{ like.name.toUpperCase() }}
                </p>
            </span>
        </div>
    </div>
</template>

<style scoped>
.favorites,
.hates,
.likes {
    padding-top: 30px;
    border-radius: 10px;
    margin: 10px 10px;
    min-height: 100px;
}

.favorites {
    background-color: #c8d8ea;
    color: #2e2f31;
}

.hates {
    background-color: #e1e3e9;
}

.likes {
    background-color: #cdf9fd;
    color: black;
}

.likes img {}

.preference {
    position: absolute;
    top: 5px;
    left: 10px;
}

img {}

img:hover+p.pokemon-name {
    display: block;
    visibility: visible;
    opacity: 1;
}

p.pokemon-name {
    visibility: hidden;
    opacity: 0;
    transition: visibility 0s, opacity 0.5s linear;
    transition: 1s;
}

span {
    padding: 5px;
}

#pokemon_container {
    flex-wrap: wrap;
}

@media screen and (min-width: 900px) {
    #pokemon_container {
        flex-wrap: nowrap;
    }
}
</style>