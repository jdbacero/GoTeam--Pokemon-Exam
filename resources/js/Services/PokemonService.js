import axios from 'axios'

const apiClient = axios.create({
    baseURL: 'https://pokeapi.co/api/v2',
    withCredentials: false,
    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json'
    }
})

export default {
    // getPokemons() {
    //     return apiClient.get('/pokemon/?limit=10000')
    // },
    getPokemons() {
        return axios.get('/api/pokemon')
    },
    getPokemon(id) {
        return apiClient.get(`/pokemon/${id}`)
    },
    getPokemons2(limit, offset) {
        return apiClient.get(`/pokemon/?limit=${limit}&${offset}`)
    },
}