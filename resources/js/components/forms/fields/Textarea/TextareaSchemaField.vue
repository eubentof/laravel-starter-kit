<script setup lang="ts">
import TextInput from '@/components/ui/primitives/input/TextInput/TextInput.vue';
import SchemaFieldFrame from '../SchemaFieldFrame.vue';
import type { SchemaFieldProps } from '../types';

defineProps<SchemaFieldProps>();
defineEmits<{ 'update:modelValue': [value: string] }>();
</script>

<template>
    <SchemaFieldFrame :field="field" :error="error">
        <TextInput
            :model-value="typeof modelValue === 'string' ? modelValue : ''"
            multiline
            :disabled="field.disabled"
            :readonly="readonly"
            @update:model-value="$emit('update:modelValue', $event)"
        />
    </SchemaFieldFrame>
</template>
