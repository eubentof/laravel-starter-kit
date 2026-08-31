<script setup lang="ts">
import Checkbox from 'primevue/checkbox';

defineProps<{
    modelValue?: boolean;
    disabled?: boolean;
    readonly?: boolean;
    ariaLabel?: string;
}>();
defineEmits<{ 'update:modelValue': [value: boolean] }>();
</script>

<template>
    <Checkbox
        :model-value="Boolean(modelValue)"
        binary
        :aria-label="ariaLabel"
        :disabled="disabled || readonly"
        @update:model-value="$emit('update:modelValue', Boolean($event))"
    />
</template>
