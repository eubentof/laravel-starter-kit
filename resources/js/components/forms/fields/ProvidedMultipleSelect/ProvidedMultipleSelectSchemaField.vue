<script setup lang="ts">
import ProvidedSelectInput from '@/components/ui/primitives/select/ProvidedSelectInput/ProvidedSelectInput.vue';
import SchemaFieldFrame from '../SchemaFieldFrame.vue';
import type { SchemaFieldProps } from '../types';

defineProps<SchemaFieldProps>();
defineEmits<{ 'update:modelValue': [value: unknown] }>();
</script>

<template>
    <SchemaFieldFrame :field="field" :error="error">
        <ProvidedSelectInput
            :model-value="Array.isArray(modelValue) ? modelValue : []"
            :provider="field.provider ?? ''"
            multiple
            :disabled="field.disabled"
            :readonly="readonly"
            @update:model-value="$emit('update:modelValue', $event)"
        />
    </SchemaFieldFrame>
</template>
