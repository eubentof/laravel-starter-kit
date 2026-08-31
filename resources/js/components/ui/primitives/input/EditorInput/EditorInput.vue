<script setup lang="ts">
import Editor from 'primevue/editor';

defineProps<{
    modelValue?: string | null;
    disabled?: boolean;
    readonly?: boolean;
}>();
defineEmits<{ 'update:modelValue': [value: string] }>();
</script>

<template>
    <Editor
        :model-value="modelValue ?? ''"
        :readonly="disabled || readonly"
        editor-style="min-height: 10rem"
        @update:model-value="$emit('update:modelValue', $event ?? '')"
    />
</template>
