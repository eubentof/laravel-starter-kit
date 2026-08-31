<?php

namespace App\Forms\Data;

use App\Support\Data\DataObject;

final readonly class LocalizedTextData extends DataObject
{
    /** @param array<string, string> $translations */
    public function __construct(public array $translations) {}

    /** @param string|array<string, string> $value */
    public static function from(string|array $value): self
    {
        return new self(is_string($value) ? ['en' => $value] : $value);
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        $source = $data['translations'] ?? $data;
        if (! is_array($source)) {
            throw new \InvalidArgumentException('Localized text translations must be an object.');
        }

        $translations = [];
        foreach ($source as $locale => $translation) {
            if (! is_string($locale) || ! is_string($translation)) {
                throw new \InvalidArgumentException('Localized text translations must contain string locale and value pairs.');
            }

            $translations[$locale] = $translation;
        }

        return new self($translations);
    }

    public function resolve(?string $locale = null): string
    {
        $locale ??= app()->getLocale();

        $fallbackLocale = config('app.fallback_locale');

        return $this->translations[$locale]
            ?? (is_string($fallbackLocale) ? ($this->translations[$fallbackLocale] ?? null) : null)
            ?? array_values($this->translations)[0]
            ?? '';
    }
}
