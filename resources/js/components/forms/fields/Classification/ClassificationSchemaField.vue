<script setup lang="ts">
import RatingInput from '@/components/ui/primitives/rating/RatingInput/RatingInput.vue';
import SchemaFieldFrame from '../SchemaFieldFrame.vue';
import { numericSetting } from '../fieldOptions';
import type { SchemaFieldProps } from '../types';

defineProps<SchemaFieldProps>();
defineEmits<{ 'update:modelValue': [value: number | null] }>();
</script>

<template>
    <SchemaFieldFrame :field="field" :error="error">
        <RatingInput
            :model-value="typeof modelValue === 'number' ? modelValue : null"
            :stars="numericSetting(field, 'max', 5)"
            :disabled="field.disabled"
            :readonly="readonly"
            @update:model-value="$emit('update:modelValue', $event)"
        />
    </SchemaFieldFrame>
</template>
