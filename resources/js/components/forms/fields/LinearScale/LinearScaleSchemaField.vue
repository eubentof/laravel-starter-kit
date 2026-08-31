<script setup lang="ts">
import InputRange from '@/components/ui/primitives/input/InputRange/InputRange.vue';
import SchemaFieldFrame from '../SchemaFieldFrame.vue';
import { numericSetting } from '../fieldOptions';
import type { SchemaFieldProps } from '../types';

defineProps<SchemaFieldProps>();
defineEmits<{ 'update:modelValue': [value: number] }>();
</script>

<template>
    <SchemaFieldFrame :field="field" :error="error">
        <InputRange
            :model-value="typeof modelValue === 'number' ? modelValue : null"
            :min="numericSetting(field, 'min', 1)"
            :max="numericSetting(field, 'max', 10)"
            :disabled="field.disabled"
            :readonly="readonly"
            @update:model-value="$emit('update:modelValue', $event)"
        />
    </SchemaFieldFrame>
</template>
