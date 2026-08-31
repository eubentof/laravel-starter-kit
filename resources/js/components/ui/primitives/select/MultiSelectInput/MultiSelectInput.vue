<script setup lang="ts">
import type { PrimitiveOption, SelectValues } from '@/components/ui/primitives/types';
import MultiSelect from 'primevue/multiselect';
import { computed } from 'vue';

const props = defineProps<{
    modelValue?: SelectValues;
    options: PrimitiveOption[];
    placeholder?: string;
    filter?: boolean;
    loading?: boolean;
    disabled?: boolean;
    readonly?: boolean;
}>();
defineEmits<{
    'update:modelValue': [value: SelectValues];
    filter: [event: { value?: string }];
    'virtual-scroll': [];
}>();
const selectedLabels = computed(() => {
    const values = props.modelValue ?? [];
    const labels = values.map(
        (value) =>
            props.options.find(
                (option) => String(option.value) === String(value),
            )?.label ?? String(value),
    );
    return labels.length > 0 ? labels.join(', ') : '—';
});
</script>

<template>
    <div v-if="readonly" class="bg-muted rounded-md px-3 py-2 text-sm">
        {{ selectedLabels }}
    </div>
    <MultiSelect
        v-else
        :model-value="modelValue ?? []"
        :options="options"
        option-label="label"
        option-value="value"
        :placeholder="placeholder"
        :filter="filter"
        :loading="loading"
        :disabled="disabled"
        display="chip"
        class="w-full"
        @filter="$emit('filter', $event)"
        @virtual-scroll="$emit('virtual-scroll')"
        @update:model-value="$emit('update:modelValue', $event ?? [])"
    />
</template>
