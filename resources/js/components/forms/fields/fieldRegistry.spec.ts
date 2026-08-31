import type { FormFieldType } from '@/types/generated';
import { describe, expect, it } from 'vitest';
import {
    fieldRegistry,
    formFieldTypes,
    resolveSchemaField,
} from './fieldRegistry';

const fieldTypes: FormFieldType[] = [
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
];

describe('form field registry', () => {
    it('should register every generated form field type', () => {
        expect(Object.keys(fieldRegistry).sort()).toEqual(
            [...fieldTypes].sort(),
        );
        expect([...formFieldTypes]).toEqual(fieldTypes);
        fieldTypes.forEach((type) =>
            expect(resolveSchemaField(type)).toBeTruthy(),
        );
    });

    it('should use distinct adapters instead of falling back to text', () => {
        const text = resolveSchemaField('text');
        fieldTypes
            .filter((type) => type !== 'text')
            .forEach((type) => expect(resolveSchemaField(type)).not.toBe(text));
    });

    it('should not register the assessment-only rating field in Forms', () => {
        expect(resolveSchemaField('rating')).toBeUndefined();
    });
});
