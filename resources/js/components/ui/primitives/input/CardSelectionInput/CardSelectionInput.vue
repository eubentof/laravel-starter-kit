<script setup lang="ts">
import type { PrimitiveOption, SelectValue } from '@/components/ui/primitives/types';
import SelectButton from 'primevue/selectbutton';
import { computed } from 'vue';

const props = defineProps<{
    modelValue?: SelectValue;
    options: PrimitiveOption[];
    disabled?: boolean;
    readonly?: boolean;
}>();
defineEmits<{ 'update:modelValue': [value: SelectValue] }>();
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
    <SelectButton
        v-else
        :model-value="modelValue"
        :options="options"
        option-label="label"
        option-value="value"
        :disabled="disabled"
        @update:model-value="$emit('update:modelValue', $event)"
    />
</template>
