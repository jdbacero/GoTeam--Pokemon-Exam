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
    getPokemon() {
        return apiClient.get('/pokemon')
    },
    getEvent(id) {
        return apiClient.get('/events/' + id)
    }
}