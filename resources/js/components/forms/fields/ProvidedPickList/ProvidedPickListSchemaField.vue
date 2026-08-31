<script setup lang="ts">
import ProvidedPickListInput from '@/components/ui/primitives/pick-list/ProvidedPickListInput/ProvidedPickListInput.vue';
import SchemaFieldFrame from '../SchemaFieldFrame.vue';
import type { SchemaFieldProps } from '../types';

defineProps<SchemaFieldProps>();
defineEmits<{ 'update:modelValue': [value: Array<string | number>] }>();
</script>

<template>
    <SchemaFieldFrame :field="field" :error="error">
        <ProvidedPickListInput
            :model-value="
                Array.isArray(modelValue)
                    ? (modelValue as Array<string | number>)
                    : []
            "
            :provider="field.provider ?? ''"
            :disabled="field.disabled"
            :readonly="readonly"
            @update:model-value="$emit('update:modelValue', $event)"
        />
    </SchemaFieldFrame>
</template>
