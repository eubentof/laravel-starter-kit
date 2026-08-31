<script setup lang="ts">
import Slider from 'primevue/slider';

withDefaults(
    defineProps<{
        modelValue?: number | null;
        min?: number;
        max?: number;
        step?: number;
        disabled?: boolean;
        readonly?: boolean;
    }>(),
    { min: 1, max: 10, step: 1 },
);
defineEmits<{ 'update:modelValue': [value: number] }>();
</script>

<template>
    <div class="grid gap-3">
        <Slider
            :model-value="modelValue ?? min"
            :min="min"
            :max="max"
            :step="step"
            :disabled="disabled || readonly"
            @update:model-value="$emit('update:modelValue', $event as number)"
        />
        <output class="text-muted-foreground text-center text-sm">{{ modelValue ?? '—' }}</output>
    </div>
</template>
