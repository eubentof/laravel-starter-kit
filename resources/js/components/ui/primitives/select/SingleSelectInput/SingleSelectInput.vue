<script setup lang="ts">
import type { PrimitiveOption, SelectValue } from '@/components/ui/primitives/types';
import Select from 'primevue/select';
import { computed } from 'vue';

const props = defineProps<{
    modelValue?: SelectValue;
    options: PrimitiveOption[];
    placeholder?: string;
    filter?: boolean;
    loading?: boolean;
    disabled?: boolean;
    readonly?: boolean;
}>();
defineEmits<{
    'update:modelValue': [value: SelectValue];
    filter: [event: { value?: string }];
    'virtual-scroll': [];
}>();
const selectedLabel = computed(
    () =>
        props.options.find(
            (option) => String(option.value) === String(props.modelValue),
        )?.label ?? '—',
);
</script>

<template>
    <div v-if="readonly" class="bg-muted rounded-md px-3 py-2 text-sm">
        {{ selectedLabel }}
    </div>
    <Select
        v-else
        :model-value="modelValue"
        :options="options"
        option-label="label"
        option-value="value"
        :placeholder="placeholder"
        :filter="filter"
        :loading="loading"
        :disabled="disabled"
        class="w-full"
        @filter="$emit('filter', $event)"
        @virtual-scroll="$emit('virtual-scroll')"
        @update:model-value="$emit('update:modelValue', $event)"
    />
</template>
