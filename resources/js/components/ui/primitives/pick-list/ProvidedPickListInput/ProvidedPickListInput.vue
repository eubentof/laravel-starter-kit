<script setup lang="ts">
import type { PrimitiveOption, SelectValues } from '@/components/ui/primitives/types';
import { useInfiniteFieldDataProvider } from '@/composables/useInfiniteFieldDataProvider';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Listbox from 'primevue/listbox';
import Message from 'primevue/message';
import { computed, ref, toRef } from 'vue';

const props = defineProps<{
    modelValue?: SelectValues;
    provider: string;
    disabled?: boolean;
    readonly?: boolean;
}>();
const emit = defineEmits<{ 'update:modelValue': [value: SelectValues] }>();
const providerApi = useInfiniteFieldDataProvider(
    toRef(props, 'provider'),
    toRef(props, 'modelValue'),
);
const sourceSelection = ref<SelectValues>([]);
const targetSelection = ref<SelectValues>([]);
const values = computed(() => props.modelValue ?? []);
const available = computed(() =>
    providerApi.options.value.filter(
        (option) => !values.value.some((value) => String(value) === String(option.value)),
    ),
);
const selected = computed(() =>
    values.value.map(
        (value) =>
            providerApi.options.value.find(
                (option) => String(option.value) === String(value),
            ) ?? { value, label: String(value), description: null },
    ),
);
const add = () => {
    emit('update:modelValue', [...new Set([...values.value, ...sourceSelection.value])]);
    sourceSelection.value = [];
};
const remove = () => {
    emit(
        'update:modelValue',
        values.value.filter(
            (value) => !targetSelection.value.some((selectedValue) => String(selectedValue) === String(value)),
        ),
    );
    targetSelection.value = [];
};
const onSourceScroll = (event: Event) => {
    const target = event.currentTarget as HTMLElement;
    if (target.scrollTop + target.clientHeight >= target.scrollHeight - 24) providerApi.loadMore();
};
const labelList = (options: PrimitiveOption[]) => options.map((option) => option.label).join(', ') || '—';
defineExpose({ providerApi });
</script>

<template>
    <div v-if="readonly" class="bg-muted rounded-md px-3 py-2 text-sm">
        {{ labelList(selected) }}
    </div>
    <div v-else class="grid gap-3">
        <InputText
            :model-value="providerApi.search.value"
            placeholder="Search options"
            :disabled="disabled"
            @update:model-value="providerApi.search.value = $event ?? ''"
        />
        <div class="grid gap-3 sm:grid-cols-[1fr_auto_1fr] sm:items-center">
            <div class="max-h-64 overflow-auto" @scroll.passive="onSourceScroll">
                <Listbox
                    v-model="sourceSelection"
                    :options="available"
                    option-label="label"
                    option-value="value"
                    multiple
                    :disabled="disabled"
                    class="w-full"
                />
            </div>
            <div class="flex justify-center gap-2 sm:flex-col">
                <Button label="Add" icon="pi pi-angle-right" :disabled="disabled || sourceSelection.length === 0" @click="add" />
                <Button label="Remove" icon="pi pi-angle-left" :disabled="disabled || targetSelection.length === 0" @click="remove" />
            </div>
            <Listbox
                v-model="targetSelection"
                :options="selected"
                option-label="label"
                option-value="value"
                multiple
                :disabled="disabled"
                class="w-full"
            />
        </div>
        <Message v-if="providerApi.error.value" severity="error" size="small" variant="simple">
            {{ providerApi.error.value }}
        </Message>
    </div>
</template>
