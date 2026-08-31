import PageTabs from './PageTabs.vue';

export default { title: 'Navigation/PageTabs', component: PageTabs };
export const Default = {
    args: {
        active: 'overview',
        tabs: [{ key: 'overview', label: 'Overview', cardless: false }],
    },
};
