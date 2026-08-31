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

it('should use the starter provider search parameter', async () => {
    vi.useFakeTimers();
    vi.stubGlobal(
        'fetch',
        vi.fn().mockResolvedValue({
            ok: true,
            json: async () => ({ data: [], hasMore: false }),
        }),
    );

    const state = useInfiniteFieldDataProvider(ref('examples'), ref(null));
    await nextTick();
    await vi.runAllTimersAsync();
    state.search.value = 'person';
    await nextTick();
    await vi.advanceTimersByTimeAsync(300);

    expect(fetch).toHaveBeenLastCalledWith(
        expect.stringContaining('search=person'),
    );
    vi.useRealTimers();
});

it('should hydrate options for saved values', async () => {
    vi.stubGlobal(
        'fetch',
        vi.fn().mockImplementation(async (url: string) => ({
            ok: true,
            json: async () =>
                url.includes('values%5B%5D=42')
                    ? {
                          data: [
                              {
                                  value: 42,
                                  label: 'Saved option',
                                  description: null,
                              },
                          ],
                          hasMore: false,
                      }
                    : { data: [], hasMore: false },
        })),
    );

    const state = useInfiniteFieldDataProvider(ref('examples'), ref(42));
    await vi.waitFor(() =>
        expect(state.options.value).toContainEqual(
            expect.objectContaining({ value: 42, label: 'Saved option' }),
        ),
    );
});

it('should ignore stale option responses after a search reset', async () => {
    vi.useFakeTimers();
    let resolveInitial: ((value: unknown) => void) | undefined;
    vi.stubGlobal(
        'fetch',
        vi.fn().mockImplementation((url: string) => {
            if (!url.includes('search=current')) {
                return new Promise((resolve) => {
                    resolveInitial = resolve;
                });
            }

            return Promise.resolve({
                ok: true,
                json: async () => ({
                    data: [
                        {
                            value: 'current',
                            label: 'Current',
                            description: null,
                        },
                    ],
                    hasMore: false,
                }),
            });
        }),
    );

    const state = useInfiniteFieldDataProvider(ref('examples'), ref(null));
    await nextTick();
    state.search.value = 'current';
    await nextTick();
    await vi.advanceTimersByTimeAsync(300);
    await vi.waitFor(() => expect(state.options.value).toHaveLength(1));

    resolveInitial?.({
        ok: true,
        json: async () => ({
            data: [{ value: 'stale', label: 'Stale', description: null }],
            hasMore: false,
        }),
    });
    await Promise.resolve();

    expect(state.options.value).toEqual([
        { value: 'current', label: 'Current', description: null },
    ]);
    vi.useRealTimers();
});
