<script setup>
import { } from 'vue'
const props = defineProps({
    msg: {
        type: String,
        default: "notify"
    },
    color: {
        type: String,
        requied: true,
        default: "test"
    }
})

</script>

<template>
    <div :class="[color, 'position-fixed', 'top-20', 'end-20']">
        {{ props.msg }}
    </div>
</template>

<style scoped>
div {
    padding: 10px;
    background-color: rgba(0, 0, 0, 0.4);
    color: white;
    border-radius: 20px;
}
</style>