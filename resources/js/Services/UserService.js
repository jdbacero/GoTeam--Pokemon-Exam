import axios from 'axios'

const apiClient = axios.create({
    baseURL: `${window.location.origin}/api/users`,
})

export default {
    //post actions
    // action: like, dislike, favorite
    preferencePokemon(pokemon, action) {
        return apiClient.post(`/pokemon/preference`, {
            pokemon: pokemon,
            action: action
        })
    },
    deleteUserPokemonPreference(pokemon) {
        return apiClient.delete('/pokemon/' + pokemon);
    },

    //retrieve actions
    getUsers() {
        return apiClient.get()
    },
    getUsersAndPokemonPreferences() {
        return apiClient.get('/pokemon-preferences')
    },
    getUserPreferencePokemon(uid, preference) {
        return apiClient.get(`/${uid}/${preference}}`)
    },
}