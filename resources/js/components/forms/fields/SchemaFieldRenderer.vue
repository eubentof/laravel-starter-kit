<script setup lang="ts">
import Message from 'primevue/message';
import { computed } from 'vue';
import { resolveSchemaField } from './fieldRegistry';
import type { SchemaFieldProps } from './types';

const props = defineProps<SchemaFieldProps>();
defineEmits<{ 'update:modelValue': [value: unknown] }>();
const component = computed(() => resolveSchemaField(props.field.type));
</script>

<template>
    <component
        :is="component"
        v-if="component"
        :field="field"
        :model-value="modelValue"
        :error="error"
        :readonly="readonly"
        @update:model-value="$emit('update:modelValue', $event)"
    />
    <Message v-else severity="error">
        Unsupported form field type: {{ field.type }}
    </Message>
</template>
