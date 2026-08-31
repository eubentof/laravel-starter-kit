import Aura from '@primeuix/themes/aura';
import type { Preview } from '@storybook/vue3-vite';
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import { setup } from '@storybook/vue3-vite';
import '../resources/css/app.css';
import 'primeicons/primeicons.css';

setup((app) => {
    app.use(PrimeVue, { theme: { preset: Aura } });
    app.use(ToastService);
});

const preview: Preview = {
    parameters: {
        controls: {
            matchers: { color: /(background|color)$/i, date: /Date$/i },
        },
        a11y: { test: 'todo' },
    },
};

export default preview;
