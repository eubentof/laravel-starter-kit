<script setup lang="ts">
import InputNumber from 'primevue/inputnumber';

withDefaults(
    defineProps<{
        modelValue?: number | null;
        currency?: string;
        locale?: string;
        disabled?: boolean;
        readonly?: boolean;
    }>(),
    { currency: 'EUR' },
);
defineEmits<{ 'update:modelValue': [value: number | null] }>();
</script>

<template>
    <InputNumber
        :model-value="modelValue"
        mode="currency"
        :currency="currency"
        :locale="locale"
        :disabled="disabled"
        :readonly="readonly"
        class="w-full"
        fluid
        @update:model-value="$emit('update:modelValue', $event)"
    />
</template>
