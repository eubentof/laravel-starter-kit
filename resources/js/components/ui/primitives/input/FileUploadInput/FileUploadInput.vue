<script setup lang="ts">
import FileUpload, { type FileUploadSelectEvent } from 'primevue/fileupload';
import { computed } from 'vue';

type FileValue = File | { name?: string; url?: string } | string | null;
const props = defineProps<{
    modelValue?: FileValue;
    accept?: string;
    disabled?: boolean;
    readonly?: boolean;
}>();
const emit = defineEmits<{ 'update:modelValue': [value: File | null] }>();
const isFile = (value: unknown): value is File =>
    typeof File !== 'undefined' && value instanceof File;
const fileName = computed(() => {
    if (isFile(props.modelValue)) return props.modelValue.name;
    if (typeof props.modelValue === 'string') return props.modelValue;
    return props.modelValue?.name ?? '—';
});
const fileUrl = computed(() =>
    props.modelValue && typeof props.modelValue === 'object' && !isFile(props.modelValue)
        ? props.modelValue.url?.startsWith('/') ||
          props.modelValue.url?.startsWith('https://') ||
          props.modelValue.url?.startsWith('http://')
            ? props.modelValue.url
            : undefined
        : undefined,
);
const selectFile = (event: FileUploadSelectEvent) => emit('update:modelValue', event.files[0] ?? null);
</script>

<template>
    <div v-if="readonly" class="bg-muted rounded-md px-3 py-2 text-sm">
        <a v-if="fileUrl" :href="fileUrl" target="_blank" rel="noopener noreferrer">{{ fileName }}</a>
        <span v-else>{{ fileName }}</span>
    </div>
    <FileUpload
        v-else
        mode="basic"
        custom-upload
        :accept="accept"
        :disabled="disabled"
        @select="selectFile"
        @clear="emit('update:modelValue', null)"
    />
</template>
