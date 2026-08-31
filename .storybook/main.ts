import type { StorybookConfig } from '@storybook/vue3-vite';
import path from 'node:path';

const config: StorybookConfig = {
    stories: ['../resources/js/**/*.stories.@(js|ts)'],
    addons: ['@storybook/addon-docs', '@storybook/addon-a11y'],
    framework: { name: '@storybook/vue3-vite', options: {} },
    viteFinal: async (config) => {
        config.resolve = config.resolve ?? {};
        const existingAliases = Array.isArray(config.resolve.alias)
            ? config.resolve.alias
            : Object.entries(config.resolve.alias ?? {}).map(
                  ([find, replacement]) => ({ find, replacement }),
              );
        config.resolve.alias = [
            ...existingAliases,
            {
                find: '@',
                replacement: path.resolve(
                    import.meta.dirname,
                    '../resources/js',
                ),
            },
        ];
        return config;
    },
};

export default config;
