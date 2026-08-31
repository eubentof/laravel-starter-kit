<script setup lang="ts">
import DataTableCell from '@/components/ui/datatable/DataTableCell.vue';
import ProvidedSelectInput from '@/components/ui/primitives/ProvidedSelectInput.vue';
import type { DataTableSchemaData } from '@/types/generated';
import Column from 'primevue/column';
import DataTable, { type DataTableCellEditCompleteEvent, type DataTableSortEvent } from 'primevue/datatable';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import DatePicker from 'primevue/datepicker';
import Message from 'primevue/message';
import MultiSelect from 'primevue/multiselect';
import Paginator, { type PageState } from 'primevue/paginator';
import { computed, onMounted, ref, watch } from 'vue';

const props = defineProps<{ schema: DataTableSchemaData }>();
const emit = defineEmits<{ rowSave: [payload: { rowKey: string | number; field: string; value: unknown }] }>();
const rows = ref<Record<string, unknown>[]>([]);
const loading = ref(false);
const error = ref<string | null>(null);
const total = ref(0);
const page = ref(1);
const sortField = ref(props.schema.defaultSortField);
const sortDirection = ref(props.schema.defaultSortDirection);
const filters = ref<Record<string, unknown>>({});
const selection = ref<Record<string, unknown>[]>([]);
const selectedColumns = ref(props.schema.columns.filter((column) => column.visible).map((column) => column.field));
const visibleColumns = computed(() => props.schema.columns.filter((column) => selectedColumns.value.includes(column.field)));
const layoutKey = `datatable:${props.schema.name}:columns`;

const fetchRows = async () => {
    loading.value = true;
    error.value = null;
    const params = new URLSearchParams({ page: String(page.value), per_page: String(props.schema.perPage) });
    if (sortField.value) params.set('sort_field', sortField.value);
    params.set('sort_direction', sortDirection.value);
    Object.entries(filters.value).forEach(([key, value]) => {
        if (Array.isArray(value)) {
            const entries = value.filter(Boolean);
            if (entries.length === 2) {
                entries.forEach((entry) => params.append(`filters[${key}][]`, entry instanceof Date ? entry.toISOString().slice(0, 10) : String(entry)));
            }
        } else if (value !== null && value !== '') {
            params.set(`filters[${key}]`, String(value));
        }
    });

    try {
        const response = await fetch(`/api/data-tables/${props.schema.name}?${params}`);
        if (!response.ok) throw new Error('Unable to load table data.');
        const payload = await response.json() as { data: { data: Record<string, unknown>[]; total: number } };
        rows.value = payload.data.data;
        total.value = payload.data.total;
    } catch (reason) {
        error.value = reason instanceof Error ? reason.message : 'Unable to load table data.';
    } finally {
        loading.value = false;
    }
};

const changePage = (event: PageState) => {
    page.value = event.page + 1;
    void fetchRows();
};

const changeSort = (event: DataTableSortEvent) => {
    if (typeof event.sortField !== 'string') return;
    sortField.value = event.sortField;
    sortDirection.value = event.sortOrder === -1 ? 'desc' : 'asc';
    void fetchRows();
};

let filterTimer: ReturnType<typeof setTimeout> | undefined;
const changeFilter = (field: string, value: unknown) => {
    filters.value[field] = value;
    clearTimeout(filterTimer);
    filterTimer = setTimeout(() => {
        page.value = 1;
        void fetchRows();
    }, 300);
};

const completeCellEdit = (event: DataTableCellEditCompleteEvent<Record<string, unknown>>) => {
    if (event.newValue === event.value) return;
    event.data[event.field] = event.newValue;
    emit('rowSave', { rowKey: event.data[props.schema.rowKey] as string | number, field: event.field, value: event.newValue });
};

watch(selectedColumns, (columns) => localStorage.setItem(layoutKey, JSON.stringify(columns)), { deep: true });
onMounted(() => {
    const saved = localStorage.getItem(layoutKey);
    if (saved) {
        const fields = JSON.parse(saved) as string[];
        selectedColumns.value = fields.filter((field) => props.schema.columns.some((column) => column.field === field));
    }
    void fetchRows();
});
defineExpose({ refresh: fetchRows });
</script>

<template>
    <div class="grid gap-3">
        <Message v-if="error" severity="error">{{ error }}</Message>
        <div class="flex justify-end">
            <MultiSelect v-model="selectedColumns" :options="schema.columns" option-label="label" option-value="field" display="chip" placeholder="Columns" class="max-w-md" />
        </div>
        <DataTable v-model:selection="selection" :value="rows" :loading="loading" lazy :data-key="schema.rowKey" edit-mode="cell" removable-sort striped-rows @sort="changeSort" @cell-edit-complete="completeCellEdit">
            <template #empty>
                <div class="grid justify-items-center gap-1 py-10 text-center">
                    <strong>{{ schema.emptyTitle }}</strong>
                    <span v-if="schema.emptyDescription" class="text-muted-foreground text-sm">{{ schema.emptyDescription }}</span>
                </div>
            </template>
            <Column selection-mode="multiple" header-style="width: 3rem" />
            <Column
                v-for="column in visibleColumns"
                :key="column.field"
                :field="column.field"
                :header="column.label"
                :sortable="column.sortable"
                :frozen="column.pinned"
            >
                <template #header v-if="column.filter">
                    <div class="grid gap-2">
                        <span>{{ column.label }}</span>
                        <ProvidedSelectInput
                            v-if="column.filter === 'select' && column.provider"
                            :model-value="filters[column.field]"
                            :provider="column.provider"
                            @update:model-value="changeFilter(column.field, $event)"
                        />
                        <DatePicker
                            v-else-if="column.filter === 'date_range'"
                            :model-value="filters[column.field] as Date[]"
                            selection-mode="range"
                            size="small"
                            @update:model-value="changeFilter(column.field, $event)"
                        />
                        <InputNumber
                            v-else-if="column.filter === 'number'"
                            :model-value="filters[column.field] as number"
                            size="small"
                            @update:model-value="changeFilter(column.field, $event)"
                        />
                        <InputText
                            v-else
                            :model-value="filters[column.field] as string"
                            :placeholder="`Filter ${column.label.toLowerCase()}`"
                            size="small"
                            @update:model-value="changeFilter(column.field, $event)"
                        />
                    </div>
                </template>
                <template #body="slotProps">
                    <DataTableCell :type="column.cell" :value="slotProps.data[column.field]" />
                </template>
                <template v-if="column.editable" #editor="slotProps">
                    <InputText v-model="slotProps.data[column.field]" autofocus fluid />
                </template>
            </Column>
        </DataTable>
        <Paginator :rows="schema.perPage" :total-records="total" @page="changePage" />
    </div>
</template>
