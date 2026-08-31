<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import Tabs from 'primevue/tabs';
import TabList from 'primevue/tablist';
import Tab from 'primevue/tab';

defineProps<{
    tabs: { key: string; label: string; cardless: boolean }[];
    active: string | null;
}>();
</script>

<template>
    <Tabs :value="active ?? ''">
        <TabList>
            <Tab v-for="tab in tabs" :key="tab.key" :value="tab.key" as-child>
                <Link :href="`?tab=${tab.key}`" preserve-state>{{
                    tab.label
                }}</Link>
            </Tab>
        </TabList>
        <div class="pt-5"><slot :name="active ?? undefined" /></div>
    </Tabs>
</template>
