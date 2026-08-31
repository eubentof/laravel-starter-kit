<script setup lang="ts">
import ChoiceGridInput from '@/components/ui/primitives/input/ChoiceGridInput/ChoiceGridInput.vue';
import MultiSelectInput from '@/components/ui/primitives/select/MultiSelectInput/MultiSelectInput.vue';
import { computed } from 'vue';
import SchemaFieldFrame from '../SchemaFieldFrame.vue';
import { configuredOptions, fieldOptions } from '../fieldOptions';
import type { SchemaFieldProps } from '../types';

const props = defineProps<SchemaFieldProps>();
defineEmits<{
    'update:modelValue': [
        value:
            | Record<string, string | number | Array<string | number> | null>
            | Array<string | number>,
    ];
}>();
const rows = computed(() => configuredOptions(props.field.settings.rows));
const columns = computed(() =>
    configuredOptions(props.field.settings.columns, props.field.options),
);
const value = computed(() =>
    props.modelValue &&
    typeof props.modelValue === 'object' &&
    !Array.isArray(props.modelValue)
        ? (props.modelValue as Record<
              string,
              string | number | Array<string | number> | null
          >)
        : {},
);
const legacyValue = computed(() =>
    Array.isArray(props.modelValue)
        ? props.modelValue.filter(
              (item): item is string | number =>
                  typeof item === 'string' || typeof item === 'number',
          )
        : [],
);
</script>

<template>
    <SchemaFieldFrame :field="field" :error="error">
        <ChoiceGridInput
            v-if="rows.length > 0 && columns.length > 0"
            :model-value="value"
            :rows="rows"
            :columns="columns"
            :multiple="field.settings.multiple === true"
            :disabled="field.disabled"
            :readonly="readonly"
            @update:model-value="$emit('update:modelValue', $event)"
        />
        <MultiSelectInput
            v-else
            :model-value="legacyValue"
            :options="fieldOptions(field)"
            :disabled="field.disabled"
            :readonly="readonly"
            @update:model-value="$emit('update:modelValue', $event)"
        />
    </SchemaFieldFrame>
</template>
