<script setup lang="ts">
import type { PrimitiveOption, SelectValue, SelectValues } from '@/components/ui/primitives/types';
import Listbox from 'primevue/listbox';
import { computed } from 'vue';

const props = defineProps<{
    modelValue?: SelectValue | SelectValues;
    options: PrimitiveOption[];
    multiple?: boolean;
    maximumSelections?: number;
    disabled?: boolean;
    readonly?: boolean;
}>();
const emit = defineEmits<{
    'update:modelValue': [value: SelectValue | SelectValues];
}>();
const selectedLabels = computed(() => {
    const values = Array.isArray(props.modelValue)
        ? props.modelValue
        : props.modelValue === null || props.modelValue === undefined
          ? []
          : [props.modelValue];
    const labels = values.map(
        (value) =>
            props.options.find(
                (option) => String(option.value) === String(value),
            )?.label ?? String(value),
    );
    return labels.length > 0 ? labels.join(', ') : '—';
});
const update = (value: SelectValue | SelectValues) => {
    if (
        Array.isArray(value) &&
        props.maximumSelections !== undefined &&
        value.length > props.maximumSelections
    ) {
        return;
    }
    emit('update:modelValue', value);
};
</script>

<template>
    <div v-if="readonly" class="bg-muted rounded-md px-3 py-2 text-sm">
        {{ selectedLabels }}
    </div>
    <Listbox
        v-else
        :model-value="modelValue"
        :options="options"
        option-label="label"
        option-value="value"
        :multiple="multiple"
        :disabled="disabled"
        class="w-full"
        @update:model-value="update"
    />
</template>
