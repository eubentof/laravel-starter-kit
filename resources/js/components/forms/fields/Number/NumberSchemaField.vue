<script setup lang="ts">
import NumberInput from '@/components/ui/primitives/input/NumberInput/NumberInput.vue';
import SchemaFieldFrame from '../SchemaFieldFrame.vue';
import { numericSetting } from '../fieldOptions';
import type { SchemaFieldProps } from '../types';

defineProps<SchemaFieldProps>();
defineEmits<{ 'update:modelValue': [value: number | null] }>();
</script>

<template>
    <SchemaFieldFrame :field="field" :error="error">
        <NumberInput
            :model-value="typeof modelValue === 'number' ? modelValue : null"
            :min="numericSetting(field, 'min', Number.MIN_SAFE_INTEGER)"
            :max="numericSetting(field, 'max', Number.MAX_SAFE_INTEGER)"
            :disabled="field.disabled"
            :readonly="readonly"
            @update:model-value="$emit('update:modelValue', $event)"
        />
    </SchemaFieldFrame>
</template>
