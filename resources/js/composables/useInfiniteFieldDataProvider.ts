import type { FieldOptionData } from '@/types/generated';
import { onBeforeUnmount, ref, watch, type Ref } from 'vue';

export function useInfiniteFieldDataProvider(
    provider: Ref<string>,
    modelValue: Ref<unknown>,
) {
    const options = ref<FieldOptionData[]>([]);
    const search = ref('');
    const page = ref(1);
    const hasMore = ref(true);
    const loading = ref(false);
    const error = ref<string | null>(null);
    let requestSequence = 0;
    let debounceTimer: ReturnType<typeof setTimeout> | undefined;

    const merge = (incoming: FieldOptionData[]) => {
        const values = new Map(
            options.value.map((option) => [String(option.value), option]),
        );
        incoming.forEach((option) => values.set(String(option.value), option));
        options.value = [...values.values()];
    };

    const load = async (reset = false) => {
        if (loading.value || (!reset && !hasMore.value)) return;
        if (reset) {
            page.value = 1;
            hasMore.value = true;
            options.value = [];
        }

        const sequence = ++requestSequence;
        loading.value = true;
        error.value = null;

        try {
            const params = new URLSearchParams({
                page: String(page.value),
                per_page: '10',
            });
            if (search.value) params.set('search', search.value);
            const response = await fetch(
                `/api/field-data/${provider.value}?${params}`,
            );
            if (!response.ok) throw new Error('Unable to load options.');
            const payload = (await response.json()) as {
                data: FieldOptionData[];
                hasMore: boolean;
            };
            if (sequence !== requestSequence) return;
            merge(payload.data);
            hasMore.value = payload.hasMore;
            if (payload.hasMore) page.value += 1;
        } catch (reason) {
            if (sequence === requestSequence)
                error.value =
                    reason instanceof Error
                        ? reason.message
                        : 'Unable to load options.';
        } finally {
            if (sequence === requestSequence) loading.value = false;
        }
    };

    watch(search, () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => void load(true), 300);
    });

    watch(provider, () => void load(true), { immediate: true });
    onBeforeUnmount(() => clearTimeout(debounceTimer));

    return {
        options,
        search,
        hasMore,
        loading,
        error,
        loadMore: () => load(false),
        refresh: () => load(true),
        modelValue,
    };
}
