<script setup lang="ts">
import CheckboxInput from '@/components/ui/primitives/input/CheckboxInput/CheckboxInput.vue';
import { localizedText } from '@/lib/localizedText';
import SchemaFieldFrame from '../SchemaFieldFrame.vue';
import type { SchemaFieldProps } from '../types';

defineProps<SchemaFieldProps>();
defineEmits<{ 'update:modelValue': [value: boolean] }>();
</script>

<template>
    <SchemaFieldFrame :field="field" :error="error">
        <div class="flex items-center gap-2">
            <CheckboxInput
                :model-value="Boolean(modelValue)"
                :disabled="field.disabled"
                :readonly="readonly"
                :aria-label="localizedText(field.label)"
                @update:model-value="$emit('update:modelValue', $event)"
            />
            <span class="text-sm">{{ localizedText(field.label) }}</span>
        </div>
    </SchemaFieldFrame>
</template>
