<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
    options: Object,
});

defineEmits(['update:modelValue']);

const input = ref(null);

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <select
        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        @input="$emit('update:modelValue', $event.target.value)"
        :value="modelValue"
    >
        <option
            v-for="(optionKey, optionValue) in options"
            :value="optionValue"
        >
            {{ optionKey }}
        </option>
    </select>
</template>
