<script setup lang="ts">
import { useInfiniteFieldDataProvider } from '@/composables/useInfiniteFieldDataProvider';
import MultiSelect from 'primevue/multiselect';
import Select from 'primevue/select';
import { toRef } from 'vue';

const props = withDefaults(defineProps<{ modelValue: unknown; provider: string; multiple?: boolean; disabled?: boolean }>(), { multiple: false, disabled: false });
const emit = defineEmits<{ 'update:modelValue': [value: unknown] }>();
const provider = toRef(props, 'provider');
const model = toRef(props, 'modelValue');
const { options, search, loading, loadMore } = useInfiniteFieldDataProvider(provider, model);
</script>

<template>
    <MultiSelect
        v-if="multiple"
        :model-value="modelValue as unknown[]"
        :options="options"
        option-label="label"
        option-value="value"
        filter
        :loading="loading"
        :disabled="disabled"
        class="w-full"
        @filter="search = $event.value"
        @virtual-scroll="loadMore"
        @update:model-value="emit('update:modelValue', $event)"
    />
    <Select
        v-else
        :model-value="modelValue"
        :options="options"
        option-label="label"
        option-value="value"
        filter
        :loading="loading"
        :disabled="disabled"
        class="w-full"
        @filter="search = $event.value"
        @virtual-scroll="loadMore"
        @update:model-value="emit('update:modelValue', $event)"
    />
</template>
