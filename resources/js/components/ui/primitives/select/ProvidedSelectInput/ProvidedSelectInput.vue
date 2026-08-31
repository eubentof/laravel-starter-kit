<script setup lang="ts">
import { useInfiniteFieldDataProvider } from '@/composables/useInfiniteFieldDataProvider';
import Message from 'primevue/message';
import { toRef } from 'vue';
import MultiSelectInput from '../MultiSelectInput/MultiSelectInput.vue';
import SingleSelectInput from '../SingleSelectInput/SingleSelectInput.vue';

const props = withDefaults(
    defineProps<{
        modelValue: unknown;
        provider: string;
        multiple?: boolean;
        disabled?: boolean;
        readonly?: boolean;
    }>(),
    { multiple: false, disabled: false, readonly: false },
);
const emit = defineEmits<{ 'update:modelValue': [value: unknown] }>();
const provider = toRef(props, 'provider');
const model = toRef(props, 'modelValue');
const providerApi = useInfiniteFieldDataProvider(provider, model);
defineExpose({ providerApi });
</script>

<template>
    <div class="grid gap-2">
        <MultiSelectInput
            v-if="multiple"
            :model-value="Array.isArray(modelValue) ? modelValue : []"
            :options="providerApi.options.value"
            filter
            :loading="providerApi.loading.value"
            :disabled="disabled"
            :readonly="readonly"
            @filter="providerApi.search.value = $event.value ?? ''"
            @virtual-scroll="providerApi.loadMore"
            @update:model-value="emit('update:modelValue', $event)"
        />
        <SingleSelectInput
            v-else
            :model-value="
                typeof modelValue === 'string' || typeof modelValue === 'number'
                    ? modelValue
                    : null
            "
            :options="providerApi.options.value"
            filter
            :loading="providerApi.loading.value"
            :disabled="disabled"
            :readonly="readonly"
            @filter="providerApi.search.value = $event.value ?? ''"
            @virtual-scroll="providerApi.loadMore"
            @update:model-value="emit('update:modelValue', $event)"
        />
        <Message v-if="providerApi.error.value" severity="error" size="small" variant="simple">
            {{ providerApi.error.value }}
        </Message>
    </div>
</template>
