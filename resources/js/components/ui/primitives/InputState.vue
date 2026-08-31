<script setup lang="ts">
import Message from 'primevue/message';

defineProps<{ label: string; description?: string; error?: string; required?: boolean }>();
</script>

<template>
    <div class="grid gap-2">
        <label class="text-sm font-medium">
            {{ label }}
            <span v-if="required" aria-hidden="true" class="text-red-500">*</span>
        </label>
        <p v-if="description" class="text-muted-foreground text-sm">{{ description }}</p>
        <slot />
        <Message v-if="error" severity="error" size="small" variant="simple">{{ error }}</Message>
    </div>
</template>
