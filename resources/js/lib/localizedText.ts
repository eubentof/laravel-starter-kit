import type { LocalizedTextData } from '@/types/generated';

export function localizedText(
    value: LocalizedTextData | null | undefined,
    locale = document.documentElement.lang || 'en',
): string {
    if (!value) return '';
    return (
        value.translations[locale] ??
        value.translations.en ??
        Object.values(value.translations)[0] ??
        ''
    );
}
