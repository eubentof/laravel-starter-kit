<script setup lang="ts">
import InputText from 'primevue/inputtext';

defineProps<{
    modelValue?: string | null;
    placeholder?: string;
    disabled?: boolean;
    readonly?: boolean;
}>();
defineEmits<{ 'update:modelValue': [value: string] }>();
</script>

<template>
    <InputText
        :model-value="modelValue ?? ''"
        type="tel"
        inputmode="tel"
        autocomplete="tel"
        :placeholder="placeholder"
        :disabled="disabled"
        :readonly="readonly"
        class="w-full"
        @update:model-value="$emit('update:modelValue', $event ?? '')"
    />
</template>
