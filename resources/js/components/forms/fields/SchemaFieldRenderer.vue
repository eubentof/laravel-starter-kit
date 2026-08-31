<script setup lang="ts">
import InputState from '@/components/ui/primitives/InputState.vue';
import ProvidedSelectInput from '@/components/ui/primitives/ProvidedSelectInput.vue';
import { localizedText } from '@/lib/localizedText';
import type { FormFieldData } from '@/types/generated';
import Checkbox from 'primevue/checkbox';
import DatePicker from 'primevue/datepicker';
import Editor from 'primevue/editor';
import FileUpload, { type FileUploadSelectEvent } from 'primevue/fileupload';
import InputNumber from 'primevue/inputnumber';
import InputText from 'primevue/inputtext';
import MultiSelect from 'primevue/multiselect';
import Rating from 'primevue/rating';
import Select from 'primevue/select';
import SelectButton from 'primevue/selectbutton';
import Slider from 'primevue/slider';
import Textarea from 'primevue/textarea';

const props = defineProps<{
    field: FormFieldData;
    modelValue: unknown;
    error?: string;
    readonly?: boolean;
}>();
const emit = defineEmits<{ 'update:modelValue': [value: unknown] }>();
const optionList = props.field.options.map((option) => ({
    value: option.value,
    label: localizedText(option.label),
}));
const update = (value: unknown) => emit('update:modelValue', value);
const selectFile = (event: FileUploadSelectEvent) =>
    update(event.files[0] ?? null);
</script>

<template>
    <InputState
        :label="localizedText(field.label)"
        :description="localizedText(field.description)"
        :error="error"
        :required="field.required"
    >
        <div v-if="readonly" class="bg-muted rounded-md px-3 py-2 text-sm">
            {{
                Array.isArray(modelValue)
                    ? modelValue.join(', ')
                    : (modelValue ?? '—')
            }}
        </div>
        <Editor
            v-else-if="field.type === 'rich_text'"
            :model-value="modelValue as string"
            :readonly="field.disabled"
            editor-style="height: 180px"
            @update:model-value="update"
        />
        <Textarea
            v-else-if="field.type === 'textarea'"
            :model-value="modelValue as string"
            :disabled="field.disabled"
            rows="4"
            class="w-full"
            @update:model-value="update"
        />
        <InputNumber
            v-else-if="field.type === 'number' || field.type === 'money'"
            :model-value="modelValue as number"
            :mode="field.type === 'money' ? 'currency' : 'decimal'"
            :currency="String(field.settings.currency ?? 'EUR')"
            :disabled="field.disabled"
            class="w-full"
            @update:model-value="update"
        />
        <DatePicker
            v-else-if="field.type === 'date_time'"
            :model-value="modelValue as Date"
            :disabled="field.disabled"
            show-time
            fluid
            @update:model-value="update"
        />
        <div
            v-else-if="field.type === 'agreement' || field.type === 'checkbox'"
            class="flex items-center gap-2"
        >
            <Checkbox
                :model-value="Boolean(modelValue)"
                binary
                :disabled="field.disabled"
                @update:model-value="update"
            />
            <span class="text-sm">{{ localizedText(field.label) }}</span>
        </div>
        <Select
            v-else-if="field.type === 'single_choice'"
            :model-value="modelValue"
            :options="optionList"
            option-label="label"
            option-value="value"
            :disabled="field.disabled"
            class="w-full"
            @update:model-value="update"
        />
        <MultiSelect
            v-else-if="
                field.type === 'multiple_choice' || field.type === 'choice_grid'
            "
            :model-value="modelValue as unknown[]"
            :options="optionList"
            option-label="label"
            option-value="value"
            :disabled="field.disabled"
            class="w-full"
            @update:model-value="update"
        />
        <SelectButton
            v-else-if="field.type === 'card_selection'"
            :model-value="modelValue"
            :options="optionList"
            option-label="label"
            option-value="value"
            :disabled="field.disabled"
            @update:model-value="update"
        />
        <Rating
            v-else-if="field.type === 'rating'"
            :model-value="modelValue as number"
            :stars="Number(field.settings.stars ?? 5)"
            :disabled="field.disabled"
            @update:model-value="update"
        />
        <Slider
            v-else-if="
                field.type === 'linear_scale' || field.type === 'classification'
            "
            :model-value="modelValue as number"
            :min="Number(field.settings.min ?? 1)"
            :max="Number(field.settings.max ?? 10)"
            :disabled="field.disabled"
            class="my-4"
            @update:model-value="update"
        />
        <FileUpload
            v-else-if="field.type === 'file'"
            mode="basic"
            custom-upload
            :disabled="field.disabled"
            @select="selectFile"
        />
        <ProvidedSelectInput
            v-else-if="field.type === 'provided_single_select'"
            :model-value="modelValue"
            :provider="field.provider!"
            :disabled="field.disabled"
            @update:model-value="update"
        />
        <ProvidedSelectInput
            v-else-if="
                field.type === 'provided_multiple_select' ||
                field.type === 'provided_pick_list'
            "
            :model-value="modelValue"
            :provider="field.provider!"
            multiple
            :disabled="field.disabled"
            @update:model-value="update"
        />
        <InputText
            v-else
            :model-value="modelValue as string"
            :type="
                field.type === 'phone'
                    ? 'tel'
                    : field.type === 'email'
                      ? 'email'
                      : field.type === 'url'
                        ? 'url'
                        : 'text'
            "
            :disabled="field.disabled"
            class="w-full"
            @update:model-value="update"
        />
    </InputState>
</template>
