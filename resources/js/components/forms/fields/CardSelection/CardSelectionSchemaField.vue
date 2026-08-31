<script setup lang="ts">
import CardSelectionInput from '@/components/ui/primitives/input/CardSelectionInput/CardSelectionInput.vue';
import SchemaFieldFrame from '../SchemaFieldFrame.vue';
import { fieldOptions } from '../fieldOptions';
import type { SchemaFieldProps } from '../types';

defineProps<SchemaFieldProps>();
defineEmits<{ 'update:modelValue': [value: string | number | null] }>();
</script>

<template>
    <SchemaFieldFrame :field="field" :error="error">
        <CardSelectionInput
            :model-value="
                typeof modelValue === 'string' || typeof modelValue === 'number'
                    ? modelValue
                    : null
            "
            :options="fieldOptions(field)"
            :disabled="field.disabled"
            :readonly="readonly"
            @update:model-value="$emit('update:modelValue', $event)"
        />
    </SchemaFieldFrame>
</template>
