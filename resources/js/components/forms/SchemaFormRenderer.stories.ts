import SchemaFormRenderer from './SchemaFormRenderer.vue';

export default {
    title: 'Forms/SchemaFormRenderer',
    component: SchemaFormRenderer,
};
export const Default = {
    args: {
        schema: {
            version: 1,
            title: { translations: { en: 'Example form' } },
            description: null,
            confirmation: null,
            pages: [
                {
                    key: 'main',
                    title: { translations: { en: 'Details' } },
                    description: null,
                    fields: [
                        {
                            key: 'name',
                            type: 'text',
                            label: { translations: { en: 'Name' } },
                            description: null,
                            required: true,
                            options: [],
                            provider: null,
                            validation: [],
                            settings: {},
                            disabled: false,
                        },
                    ],
                },
            ],
        },
        values: { name: '' },
    },
};
