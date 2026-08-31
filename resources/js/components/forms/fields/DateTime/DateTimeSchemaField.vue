<script setup lang="ts">
import DateTimeInput from '@/components/ui/primitives/input/DateTimeInput/DateTimeInput.vue';
import SchemaFieldFrame from '../SchemaFieldFrame.vue';
import { stringSetting } from '../fieldOptions';
import type { SchemaFieldProps } from '../types';

defineProps<SchemaFieldProps>();
defineEmits<{ 'update:modelValue': [value: string] }>();
</script>

<template>
    <SchemaFieldFrame :field="field" :error="error">
        <DateTimeInput
            :model-value="typeof modelValue === 'string' ? modelValue : ''"
            :mode="
                stringSetting(field, 'mode', 'date_time') as
                    'date' | 'time' | 'date_time'
            "
            :disabled="field.disabled"
            :readonly="readonly"
            @update:model-value="$emit('update:modelValue', $event)"
        />
    </SchemaFieldFrame>
</template>
