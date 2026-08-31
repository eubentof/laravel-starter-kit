<script setup lang="ts">
import PhoneInput from '@/components/ui/primitives/input/PhoneInput/PhoneInput.vue';
import SchemaFieldFrame from '../SchemaFieldFrame.vue';
import type { SchemaFieldProps } from '../types';

defineProps<SchemaFieldProps>();
defineEmits<{ 'update:modelValue': [value: string] }>();
</script>

<template>
    <SchemaFieldFrame :field="field" :error="error">
        <PhoneInput
            :model-value="typeof modelValue === 'string' ? modelValue : ''"
            :disabled="field.disabled"
            :readonly="readonly"
            @update:model-value="$emit('update:modelValue', $event)"
        />
    </SchemaFieldFrame>
</template>
