<script setup lang="ts">
import InputText from 'primevue/inputtext';
import Textarea from 'primevue/textarea';

withDefaults(
    defineProps<{
        modelValue?: string | null;
        type?: 'text' | 'email' | 'url';
        multiline?: boolean;
        rows?: number;
        placeholder?: string;
        disabled?: boolean;
        readonly?: boolean;
    }>(),
    { type: 'text', multiline: false, rows: 4, modelValue: '' },
);
defineEmits<{ 'update:modelValue': [value: string] }>();
</script>

<template>
    <Textarea
        v-if="multiline"
        :model-value="modelValue ?? ''"
        :rows="rows"
        :placeholder="placeholder"
        :disabled="disabled"
        :readonly="readonly"
        class="w-full"
        @update:model-value="$emit('update:modelValue', $event ?? '')"
    />
    <InputText
        v-else
        :model-value="modelValue ?? ''"
        :type="type"
        :placeholder="placeholder"
        :disabled="disabled"
        :readonly="readonly"
        class="w-full"
        @update:model-value="$emit('update:modelValue', $event ?? '')"
    />
</template>
