<script setup lang="ts">
import MultiSelectInput from '@/components/ui/primitives/select/MultiSelectInput/MultiSelectInput.vue';
import SchemaFieldFrame from '../SchemaFieldFrame.vue';
import { fieldOptions } from '../fieldOptions';
import type { SchemaFieldProps } from '../types';

defineProps<SchemaFieldProps>();
defineEmits<{ 'update:modelValue': [value: Array<string | number>] }>();
</script>

<template>
    <SchemaFieldFrame :field="field" :error="error">
        <MultiSelectInput
            :model-value="
                Array.isArray(modelValue)
                    ? (modelValue as Array<string | number>)
                    : []
            "
            :options="fieldOptions(field)"
            :disabled="field.disabled"
            :readonly="readonly"
            @update:model-value="$emit('update:modelValue', $event)"
        />
    </SchemaFieldFrame>
</template>
