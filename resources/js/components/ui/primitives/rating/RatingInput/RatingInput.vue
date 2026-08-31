<script setup lang="ts">
import Rating from 'primevue/rating';

withDefaults(
    defineProps<{
        modelValue?: number | null;
        stars?: number;
        disabled?: boolean;
        readonly?: boolean;
    }>(),
    { stars: 5 },
);
defineEmits<{ 'update:modelValue': [value: number | null] }>();
</script>

<template>
    <Rating
        :model-value="modelValue ?? undefined"
        :stars="stars"
        :disabled="disabled || readonly"
        @update:model-value="$emit('update:modelValue', $event)"
    />
</template>
