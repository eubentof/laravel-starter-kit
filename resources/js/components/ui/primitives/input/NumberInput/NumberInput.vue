<script setup lang="ts">
import InputNumber from 'primevue/inputnumber';

defineProps<{
    modelValue?: number | null;
    min?: number;
    max?: number;
    disabled?: boolean;
    readonly?: boolean;
}>();
defineEmits<{ 'update:modelValue': [value: number | null] }>();
</script>

<template>
    <InputNumber
        :model-value="modelValue"
        :min="min"
        :max="max"
        :disabled="disabled"
        :readonly="readonly"
        class="w-full"
        fluid
        @update:model-value="$emit('update:modelValue', $event)"
    />
</template>
