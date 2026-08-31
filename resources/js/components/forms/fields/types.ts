import type { FormFieldData } from '@/types/generated';

export interface SchemaFieldProps {
    field: FormFieldData;
    modelValue: unknown;
    error?: string;
    readonly?: boolean;
}
