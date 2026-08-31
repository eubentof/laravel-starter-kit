<script setup lang="ts">
import CheckboxInput from '../CheckboxInput/CheckboxInput.vue';

defineProps<{
    modelValue?: boolean;
    text?: string;
    disabled?: boolean;
    readonly?: boolean;
}>();
defineEmits<{ 'update:modelValue': [value: boolean] }>();
</script>

<template>
    <div class="flex items-start gap-2">
        <CheckboxInput
            :model-value="modelValue"
            :disabled="disabled"
            :readonly="readonly"
            :aria-label="text"
            @update:model-value="$emit('update:modelValue', $event)"
        />
        <p v-if="text" class="text-sm leading-6">{{ text }}</p>
    </div>
</template>
