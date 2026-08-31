import vue from '@vitejs/plugin-vue';
import path from 'node:path';
import { defineConfig } from 'vitest/config';

export default defineConfig({
    plugins: [vue()],
    resolve: {
        alias: { '@': path.resolve(import.meta.dirname, 'resources/js') },
    },
    test: { environment: 'happy-dom', include: ['resources/js/**/*.spec.ts'] },
});
