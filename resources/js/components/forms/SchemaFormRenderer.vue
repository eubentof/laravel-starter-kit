<script setup lang="ts">
import SchemaFieldRenderer from '@/components/forms/fields/SchemaFieldRenderer.vue';
import { localizedText } from '@/lib/localizedText';
import type { FormSchemaData } from '@/types/generated';

defineProps<{
    schema: FormSchemaData;
    values: Record<string, unknown>;
    errors?: Record<string, string>;
    readonly?: boolean;
}>();
const emit = defineEmits<{ change: [key: string, value: unknown] }>();
</script>

<template>
    <div class="grid gap-8">
        <header class="grid gap-2">
            <h2 class="text-xl font-semibold">
                {{ localizedText(schema.title) }}
            </h2>
            <p v-if="schema.description" class="text-muted-foreground">
                {{ localizedText(schema.description) }}
            </p>
        </header>
        <section
            v-for="page in schema.pages"
            :key="page.key"
            class="grid gap-5"
        >
            <div>
                <h3 class="font-medium">{{ localizedText(page.title) }}</h3>
                <p
                    v-if="page.description"
                    class="text-muted-foreground text-sm"
                >
                    {{ localizedText(page.description) }}
                </p>
            </div>
            <SchemaFieldRenderer
                v-for="field in page.fields"
                :key="field.key"
                :field="field"
                :model-value="values[field.key]"
                :error="errors?.[field.key]"
                :readonly="readonly"
                @update:model-value="emit('change', field.key, $event)"
            />
        </section>
    </div>
</template>
