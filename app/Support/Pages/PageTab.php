<?php

namespace App\Support\Pages;

use Illuminate\Http\Request;

abstract class PageTab
{
    abstract public function key(): string;

    abstract public function label(): string;

    /** @return array<string, mixed> */
    public function props(Request $request): array
    {
        return [];
    }

    public function authorize(Request $request): bool
    {
        return true;
    }

    /** @return array{key: string, label: string, cardless: bool} */
    final public function navigation(): array
    {
        return ['key' => $this->key(), 'label' => $this->label(), 'cardless' => $this->cardless()];
    }

    public function cardless(): bool
    {
        return false;
    }
}
