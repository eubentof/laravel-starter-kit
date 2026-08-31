<script setup lang="ts">
import InputState from '@/components/ui/primitives/InputState.vue';
import { localizedText } from '@/lib/localizedText';
import type { FormFieldData } from '@/types/generated';

defineProps<{ field: FormFieldData; error?: string }>();
</script>

<template>
    <InputState
        :label="localizedText(field.label)"
        :description="
            field.description ? localizedText(field.description) : undefined
        "
        :error="error"
        :required="field.required"
    >
        <slot />
    </InputState>
</template>
