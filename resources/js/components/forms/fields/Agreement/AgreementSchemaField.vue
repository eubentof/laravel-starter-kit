<script setup lang="ts">
import AgreementInput from '@/components/ui/primitives/input/AgreementInput/AgreementInput.vue';
import SchemaFieldFrame from '../SchemaFieldFrame.vue';
import { stringSetting } from '../fieldOptions';
import type { SchemaFieldProps } from '../types';

defineProps<SchemaFieldProps>();
defineEmits<{ 'update:modelValue': [value: boolean] }>();
</script>

<template>
    <SchemaFieldFrame :field="field" :error="error">
        <AgreementInput
            :model-value="Boolean(modelValue)"
            :text="stringSetting(field, 'agreementText', 'I agree')"
            :disabled="field.disabled"
            :readonly="readonly"
            @update:model-value="$emit('update:modelValue', $event)"
        />
    </SchemaFieldFrame>
</template>
