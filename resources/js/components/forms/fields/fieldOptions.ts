import { localizedText } from '@/lib/localizedText';
import type {
    ChoiceOptionData,
    FieldOptionData,
    FormFieldData,
} from '@/types/generated';

export const fieldOptions = (field: FormFieldData): FieldOptionData[] =>
    field.options.map((option) => ({
        value: option.value,
        label: localizedText(option.label),
        description: option.description
            ? localizedText(option.description)
            : null,
    }));

export const configuredOptions = (
    value: unknown,
    fallback: ChoiceOptionData[] = [],
): FieldOptionData[] => {
    const options = Array.isArray(value) ? value : fallback;
    return options.flatMap((option) => {
        if (!option || typeof option !== 'object') return [];
        const candidate = option as Record<string, unknown>;
        const rawValue = candidate.value;
        if (typeof rawValue !== 'string' && typeof rawValue !== 'number')
            return [];
        const rawLabel = candidate.label;
        const label =
            typeof rawLabel === 'string'
                ? rawLabel
                : rawLabel &&
                    typeof rawLabel === 'object' &&
                    'translations' in rawLabel
                  ? localizedText(rawLabel as ChoiceOptionData['label'])
                  : String(rawValue);
        return [{ value: rawValue, label, description: null }];
    });
};

export const numericSetting = (
    field: FormFieldData,
    key: string,
    fallback: number,
): number => {
    const value = Number(field.settings[key]);
    return Number.isFinite(value) ? value : fallback;
};

export const stringSetting = (
    field: FormFieldData,
    key: string,
    fallback = '',
): string => {
    const value = field.settings[key];
    return typeof value === 'string' ? value : fallback;
};
