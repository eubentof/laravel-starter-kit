import { expect, it } from 'vitest';
import { formFieldTypes } from './fieldRegistry';

const stories = import.meta.glob('./**/*.stories.ts');
type FormFieldType = (typeof formFieldTypes)[number];
const storyFolders: Record<FormFieldType, string> = {
    text: 'Text',
    email: 'Email',
    url: 'Url',
    rich_text: 'RichText',
    textarea: 'Textarea',
    number: 'Number',
    money: 'Money',
    date_time: 'DateTime',
    phone: 'Phone',
    agreement: 'Agreement',
    checkbox: 'Checkbox',
    single_choice: 'SingleChoice',
    multiple_choice: 'MultipleChoice',
    card_selection: 'CardSelection',
    choice_grid: 'ChoiceGrid',
    linear_scale: 'LinearScale',
    classification: 'Classification',
    file: 'File',
    provided_single_select: 'ProvidedSingleSelect',
    provided_multiple_select: 'ProvidedMultipleSelect',
    provided_pick_list: 'ProvidedPickList',
};

it('should provide colocated stories for every form field adapter', () => {
    Object.values(storyFolders).forEach((folder) => {
        expect(
            Object.keys(stories).some((path) =>
                path.startsWith(`./${folder}/`),
            ),
            `${folder} is missing a colocated story`,
        ).toBe(true);
    });
});
