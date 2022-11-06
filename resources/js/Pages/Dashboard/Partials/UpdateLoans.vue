<script setup>
import { ref, onMounted } from 'vue'
import { Inertia } from "@inertiajs/inertia";
import UpdateLoan from "./UpdateLoan.vue";
const props = defineProps({
    loans: { type: Array, required: false },
})

onMounted(() => {
    console.log('loans update', props.loans);
})
</script>
<template>
<div>
    <div
        v-for="loan in props.loans"
    >
        <UpdateLoan :loan="loan"></UpdateLoan>
    </div>
</div>
</template>
