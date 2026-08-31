<script setup lang="ts">
import FileUploadInput from '@/components/ui/primitives/input/FileUploadInput/FileUploadInput.vue';
import { computed } from 'vue';
import SchemaFieldFrame from '../SchemaFieldFrame.vue';
import { stringSetting } from '../fieldOptions';
import type { SchemaFieldProps } from '../types';

const props = defineProps<SchemaFieldProps>();
defineEmits<{ 'update:modelValue': [value: File | null] }>();
const isFile = (value: unknown): value is File =>
    typeof File !== 'undefined' && value instanceof File;
const value = computed(() =>
    isFile(props.modelValue) ||
    typeof props.modelValue === 'string' ||
    props.modelValue === null ||
    (typeof props.modelValue === 'object' && !Array.isArray(props.modelValue))
        ? (props.modelValue as
              | File
              | { name?: string; url?: string }
              | string
              | null)
        : null,
);
const accept = computed(() => {
    const configured = stringSetting(props.field, 'accept');
    if (configured) return configured;
    const formats = props.field.settings.acceptedFormats;
    return Array.isArray(formats)
        ? formats
              .filter((format): format is string => typeof format === 'string')
              .join(',')
        : undefined;
});
</script>

<template>
    <SchemaFieldFrame :field="field" :error="error">
        <FileUploadInput
            :model-value="value"
            :accept="accept"
            :disabled="field.disabled"
            :readonly="readonly"
            @update:model-value="$emit('update:modelValue', $event)"
        />
    </SchemaFieldFrame>
</template>
