<?php

namespace App\Support\Pages;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Inertia\Response;

abstract class Page
{
    abstract protected function component(): string;

    abstract protected function props(Request $request): PageProps;

    public function __invoke(Request $request): Response
    {
        abort_unless($this->authorize($request), 403);

        $tabs = collect($this->tabs());
        $activeKey = (string) $request->query('tab', $this->defaultTab() ?? $tabs->first()?->key());
        $activeTab = $tabs->first(fn (PageTab $tab): bool => $tab->key() === $activeKey);

        if ($activeTab !== null) {
            abort_unless($activeTab->authorize($request), 403);
        }

        return Inertia::render($this->component(), [
            ...$this->props($request)->toArray(),
            ...($activeTab?->props($request) ?? []),
            'pageTabs' => $tabs->map(fn (PageTab $tab): array => $tab->navigation())->values()->all(),
            'activeTab' => $activeTab?->key(),
        ]);
    }

    protected function authorize(Request $request): bool
    {
        return true;
    }

    /** @return list<PageTab> */
    protected function tabs(): array
    {
        return [];
    }

    protected function defaultTab(): ?string
    {
        return Arr::first($this->tabs())?->key();
    }
}
