<?php

namespace App\Forms\Builders;

use App\Forms\Data\FormPageData;
use App\Forms\Data\FormSchemaData;
use App\Forms\Data\LocalizedTextData;

final class FormSchemaBuilder
{
    /** @var list<FormPageData> */
    private array $pages = [];

    private ?LocalizedTextData $description = null;

    private ?LocalizedTextData $confirmation = null;

    public function __construct(private readonly LocalizedTextData $title) {}

    /** @param string|array<string, string> $title */
    public static function make(string|array $title): self
    {
        return new self(LocalizedTextData::from($title));
    }

    /** @param string|array<string, string> $description */
    public function description(string|array $description): self
    {
        $this->description = LocalizedTextData::from($description);

        return $this;
    }

    /** @param string|array<string, string> $confirmation */
    public function confirmation(string|array $confirmation): self
    {
        $this->confirmation = LocalizedTextData::from($confirmation);

        return $this;
    }

    public function page(FormPageData $page): self
    {
        $this->pages[] = $page;

        return $this;
    }

    public function build(): FormSchemaData
    {
        return new FormSchemaData(1, $this->title, $this->pages, $this->description, $this->confirmation);
    }
}
