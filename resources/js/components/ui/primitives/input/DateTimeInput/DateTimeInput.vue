<script setup lang="ts">
import DatePicker from 'primevue/datepicker';
import { computed } from 'vue';

type DateTimeMode = 'date' | 'time' | 'date_time';
const props = withDefaults(
    defineProps<{
        modelValue?: string | null;
        mode?: DateTimeMode;
        disabled?: boolean;
        readonly?: boolean;
    }>(),
    { mode: 'date_time' },
);
const emit = defineEmits<{ 'update:modelValue': [value: string] }>();

const value = computed(() => {
    if (!props.modelValue) return null;
    const source =
        props.mode === 'date'
            ? `${props.modelValue}T00:00:00`
            : props.mode === 'time'
              ? `1970-01-01T${props.modelValue}:00`
              : props.modelValue;
    const parsed = new Date(source);
    return Number.isNaN(parsed.getTime()) ? null : parsed;
});
const formattedValue = computed(() => {
    if (!value.value) return '—';
    return new Intl.DateTimeFormat(undefined, {
        ...(props.mode !== 'time' ? { dateStyle: 'medium' as const } : {}),
        ...(props.mode !== 'date' ? { timeStyle: 'short' as const } : {}),
    }).format(value.value);
});
const pad = (part: number) => String(part).padStart(2, '0');
const update = (value: Date | Date[] | (Date | null)[] | null | undefined) => {
    const date = value instanceof Date ? value : null;
    if (!date) return emit('update:modelValue', '');
    const day = `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}`;
    const time = `${pad(date.getHours())}:${pad(date.getMinutes())}`;
    emit(
        'update:modelValue',
        props.mode === 'date' ? day : props.mode === 'time' ? time : `${day}T${time}`,
    );
};
</script>

<template>
    <div v-if="readonly" class="bg-muted rounded-md px-3 py-2 text-sm">
        {{ formattedValue }}
    </div>
    <DatePicker
        v-else
        :model-value="value"
        :time-only="mode === 'time'"
        :show-time="mode === 'date_time'"
        :disabled="disabled"
        fluid
        @update:model-value="update"
    />
</template>
