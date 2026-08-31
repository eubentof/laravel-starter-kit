<script setup lang="ts">
import type { CellType } from '@/types/generated';

const props = defineProps<{ type: CellType; value: unknown }>();
const text = () => {
    if (Array.isArray(props.value)) return props.value.join(', ');
    if (props.value === null || props.value === undefined || props.value === '') return '—';
    return String(props.value).replace(/<[^>]*>/g, '');
};
</script>

<template>
    <a v-if="type === 'link' && value" :href="String(value)" class="text-primary underline">{{ text() }}</a>
    <a v-else-if="type === 'phone' && value" :href="`tel:${value}`" class="text-primary underline">{{ text() }}</a>
    <span v-else>{{ text() }}</span>
</template>
