<script setup lang="ts">
import type { PrimitiveOption, SelectValue, SelectValues } from '@/components/ui/primitives/types';
import Checkbox from 'primevue/checkbox';
import RadioButton from 'primevue/radiobutton';

type GridValue = Record<string, SelectValue | SelectValues>;
const props = defineProps<{
    modelValue?: GridValue;
    rows: PrimitiveOption[];
    columns: PrimitiveOption[];
    multiple?: boolean;
    disabled?: boolean;
    readonly?: boolean;
}>();
const emit = defineEmits<{ 'update:modelValue': [value: GridValue] }>();
const rowValue = (row: PrimitiveOption) => props.modelValue?.[String(row.value)];
const isSelected = (row: PrimitiveOption, column: PrimitiveOption) => {
    const value = rowValue(row);
    return (
        Array.isArray(value) &&
        value.some((selectedValue) => String(selectedValue) === String(column.value))
    );
};
const updateSingle = (row: PrimitiveOption, value: SelectValue) => {
    emit('update:modelValue', {
        ...(props.modelValue ?? {}),
        [String(row.value)]: value,
    });
};
const updateMultiple = (row: PrimitiveOption, column: PrimitiveOption, checked: boolean) => {
    const current = rowValue(row);
    const values = Array.isArray(current) ? [...current] : [];
    const next = checked
        ? [...new Set([...values, column.value])]
        : values.filter((value) => String(value) !== String(column.value));
    emit('update:modelValue', {
        ...(props.modelValue ?? {}),
        [String(row.value)]: next,
    });
};
</script>

<template>
    <div class="overflow-x-auto rounded-md border">
        <table class="w-full border-collapse text-sm">
            <thead>
                <tr>
                    <th class="p-3 text-left font-medium" scope="col">Choice</th>
                    <th
                        v-for="column in columns"
                        :key="String(column.value)"
                        class="p-3 text-center font-medium"
                        scope="col"
                    >
                        {{ column.label }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="row in rows" :key="String(row.value)" class="border-t">
                    <th class="p-3 text-left font-normal" scope="row">{{ row.label }}</th>
                    <td
                        v-for="column in columns"
                        :key="String(column.value)"
                        class="p-3 text-center"
                    >
                        <Checkbox
                            v-if="multiple"
                            :model-value="isSelected(row, column)"
                            binary
                            :aria-label="`${row.label}: ${column.label}`"
                            :disabled="disabled || readonly"
                            @update:model-value="
                                updateMultiple(row, column, Boolean($event))
                            "
                        />
                        <RadioButton
                            v-else
                            :model-value="rowValue(row)"
                            :value="column.value"
                            :name="`grid-${row.value}`"
                            :aria-label="`${row.label}: ${column.label}`"
                            :disabled="disabled || readonly"
                            @update:model-value="updateSingle(row, $event)"
                        />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
