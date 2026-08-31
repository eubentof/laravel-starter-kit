import type { FieldOptionData } from '@/types/generated';

export type PrimitiveValue = string | number | boolean | File | null;
export type SelectValue = string | number | null;
export type SelectValues = Array<string | number>;
export type PrimitiveOption = FieldOptionData;

export interface PrimitiveStateProps {
    disabled?: boolean;
    readonly?: boolean;
}
