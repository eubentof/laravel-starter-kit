import type { FormFieldType } from '@/types/generated';
import type { Component } from 'vue';
import AgreementSchemaField from './Agreement/AgreementSchemaField.vue';
import CardSelectionSchemaField from './CardSelection/CardSelectionSchemaField.vue';
import CheckboxSchemaField from './Checkbox/CheckboxSchemaField.vue';
import ChoiceGridSchemaField from './ChoiceGrid/ChoiceGridSchemaField.vue';
import ClassificationSchemaField from './Classification/ClassificationSchemaField.vue';
import DateTimeSchemaField from './DateTime/DateTimeSchemaField.vue';
import EmailSchemaField from './Email/EmailSchemaField.vue';
import FileSchemaField from './File/FileSchemaField.vue';
import LinearScaleSchemaField from './LinearScale/LinearScaleSchemaField.vue';
import MoneySchemaField from './Money/MoneySchemaField.vue';
import MultipleChoiceSchemaField from './MultipleChoice/MultipleChoiceSchemaField.vue';
import NumberSchemaField from './Number/NumberSchemaField.vue';
import PhoneSchemaField from './Phone/PhoneSchemaField.vue';
import ProvidedMultipleSelectSchemaField from './ProvidedMultipleSelect/ProvidedMultipleSelectSchemaField.vue';
import ProvidedPickListSchemaField from './ProvidedPickList/ProvidedPickListSchemaField.vue';
import ProvidedSingleSelectSchemaField from './ProvidedSingleSelect/ProvidedSingleSelectSchemaField.vue';
import RichTextSchemaField from './RichText/RichTextSchemaField.vue';
import SingleChoiceSchemaField from './SingleChoice/SingleChoiceSchemaField.vue';
import TextSchemaField from './Text/TextSchemaField.vue';
import TextareaSchemaField from './Textarea/TextareaSchemaField.vue';
import UrlSchemaField from './Url/UrlSchemaField.vue';

export const formFieldTypes = [
    'text',
    'email',
    'url',
    'rich_text',
    'textarea',
    'number',
    'money',
    'date_time',
    'phone',
    'agreement',
    'checkbox',
    'single_choice',
    'multiple_choice',
    'card_selection',
    'choice_grid',
    'linear_scale',
    'classification',
    'file',
    'provided_single_select',
    'provided_multiple_select',
    'provided_pick_list',
] as const satisfies readonly FormFieldType[];

export const fieldRegistry: Partial<Record<FormFieldType, Component>> = {
    text: TextSchemaField,
    email: EmailSchemaField,
    url: UrlSchemaField,
    rich_text: RichTextSchemaField,
    textarea: TextareaSchemaField,
    number: NumberSchemaField,
    money: MoneySchemaField,
    date_time: DateTimeSchemaField,
    phone: PhoneSchemaField,
    agreement: AgreementSchemaField,
    checkbox: CheckboxSchemaField,
    single_choice: SingleChoiceSchemaField,
    multiple_choice: MultipleChoiceSchemaField,
    card_selection: CardSelectionSchemaField,
    choice_grid: ChoiceGridSchemaField,
    linear_scale: LinearScaleSchemaField,
    classification: ClassificationSchemaField,
    file: FileSchemaField,
    provided_single_select: ProvidedSingleSelectSchemaField,
    provided_multiple_select: ProvidedMultipleSelectSchemaField,
    provided_pick_list: ProvidedPickListSchemaField,
};

export const resolveSchemaField = (
    type: FormFieldType,
): Component | undefined => fieldRegistry[type];
