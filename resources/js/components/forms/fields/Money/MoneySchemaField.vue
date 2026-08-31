<script setup lang="ts">
import MoneyInput from '@/components/ui/primitives/input/MoneyInput/MoneyInput.vue';
import SchemaFieldFrame from '../SchemaFieldFrame.vue';
import { stringSetting } from '../fieldOptions';
import type { SchemaFieldProps } from '../types';

defineProps<SchemaFieldProps>();
defineEmits<{ 'update:modelValue': [value: number | null] }>();
</script>

<template>
    <SchemaFieldFrame :field="field" :error="error">
        <MoneyInput
            :model-value="typeof modelValue === 'number' ? modelValue : null"
            :currency="stringSetting(field, 'currency', 'EUR')"
            :disabled="field.disabled"
            :readonly="readonly"
            @update:model-value="$emit('update:modelValue', $event)"
        />
    </SchemaFieldFrame>
</template>
