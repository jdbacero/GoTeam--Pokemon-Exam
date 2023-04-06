<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PokemonService from '../Services/PokemonService'
import UserService from '@/Services/UserService';
import { ref, onMounted } from 'vue'
import UserPokemonPreference from '@/Components/UserPokemonPreference.vue'

const users = ref(null)

onMounted(async () => {
    await UserService.getUsersAndPokemonPreferences()
        .then(response => {
            users.value = response.data
            console.log(response.data)
        })
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Users</h2>
        </template>
        <div class="container mt-2">
            <div class="row" v-if="users" v-for="(user, index) in users" :key="index">
                <div class="col-12 col-md-2 d-flex flex-row align-items-center">
                    <h3>
                        {{ user.first_name }}
                        {{ user.last_name }}
                    </h3>
                </div>
                <div class="col-md-10 col-12 d-flex flex-row">
                    <UserPokemonPreference :pokemon_preferences="user.pokemon_preferences" />
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
