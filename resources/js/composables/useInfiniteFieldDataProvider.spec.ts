import { useInfiniteFieldDataProvider } from './useInfiniteFieldDataProvider';
import { nextTick, ref } from 'vue';
import { afterEach, expect, it, vi } from 'vitest';

afterEach(() => vi.restoreAllMocks());

it('should load ten provider options and expose more pages', async () => {
    vi.stubGlobal(
        'fetch',
        vi.fn().mockResolvedValue({
            ok: true,
            json: async () => ({
                data: [{ value: 1, label: 'One', description: null }],
                hasMore: true,
            }),
        }),
    );

    const state = useInfiniteFieldDataProvider(ref('examples'), ref(null));
    await nextTick();
    await vi.waitFor(() => expect(state.options.value).toHaveLength(1));

    expect(fetch).toHaveBeenCalledWith(expect.stringContaining('per_page=10'));
    expect(state.hasMore.value).toBe(true);
});
